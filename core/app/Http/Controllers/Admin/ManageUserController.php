<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\User;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\SystemTransaction;
use App\Models\UpdateUsersBalance;
use App\Http\Controllers\Controller;
use App\Models\DirectPurchase;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Notifications\UpdateUserBalanceNotification;


class ManageUserController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة المستخدمين';

        $search['account_number'] = $request->account_number;
        $search['user_name'] = $request->user_name;
        $search['status'] = $request->status;
        $search['email'] = $request->email;

        $data['users'] = User::when($search['account_number'], function ($q) use ($search) {
            $q->where('account_number', 'LIKE', '%' . $search['account_number'] . '%');
        })
            ->when($search['user_name'], function ($q) use ($search) {
                $q->where('username', 'LIKE', '%' . $search['user_name'] . '%');
            })
            ->when($search['email'], function ($q) use ($search) {
                $q->where('email', 'LIKE', '%' . $search['email'] . '%');
            })
            ->when($search['status'], function ($q) use ($search) {
                $q->where('status', '=', $search['status']);
            })
            ->latest()->paginate();

        return view('backend.users.index', compact('search'))->with($data);
    }

    public function userAccountStatement(Request $request, User $user)
    {
        $data['pageTitle'] = 'سجل معاملات المستخدم';

        $pass_dates = $request->dates;

        $dates = array_map(function ($date) {
            return Carbon::parse($date);
        }, explode('-', $pass_dates));

        $transactions = SystemTransaction::with(['transactional' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                Purchase::class => ['buyer', 'seller'],
                Sale::class => ['fund', 'buyer'],
                UpdateUsersBalance::class => ['user'],
                DirectPurchase::class => ['seller', 'fund'],
            ]);
        }])
            ->whereHasMorph(
                'transactional',
                [
                    Purchase::class,
                    Sale::class,
                    UpdateUsersBalance::class,
                    DirectPurchase::class,
                ],
                function ($query, $type) use ($user) {
                    if ($type == Purchase::class) {
                        $query->where(function ($query) use ($user) {
                            $query->where('buyer_id', '=', $user->id);
                            $query->orWhere('seller_id', '=', $user->id);
                        });
                    } elseif ($type === Sale::class) {
                        $query->where(function ($query) use ($user) {
                            $query->where('buyer_id', '=', $user->id);
                        });
                    } elseif ($type === DirectPurchase::class) {
                        $query->where(function ($query) use ($user) {
                            $query->where('seller_id', '=', $user->id);
                        });
                    } elseif ($type === UpdateUsersBalance::class) {
                        $query->where('user_id', $user->id);
                    }
                }
            )
            ->when($request->dates, function ($q) use ($dates) {
                $q->whereBetween('created_at', $dates);
            })
            ->latest()
            ->paginate(15);

        return view('backend.users.account_statement', compact('transactions', 'user', 'pass_dates'))->with($data);
    }

    public function transactionDetails($id) {
        $data['pageTitle'] = 'تفاصيل المعاملة';
        $transaction = SystemTransaction::findOrFail($id);
        return view('backend.users.transaction_details', compact('transaction'))->with($data);
    }

    public function userAccountStatementPDF(User $user, $dates = null)
    {
        $pass_dates = str_replace('+', '/', $dates);

        $dates = array_map(function ($pass_dates) {
            return Carbon::parse($pass_dates);
        }, explode('-', $pass_dates));

        $transactions = SystemTransaction::with(['transactional' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                Purchase::class => ['buyer', 'seller'],
                Sale::class => ['fund', 'buyer'],
                UpdateUsersBalance::class => ['user'],
                DirectPurchase::class => ['seller', 'fund'],
            ]);
        }])
            ->whereHasMorph(
                'transactional',
                [
                    Purchase::class,
                    Sale::class,
                    UpdateUsersBalance::class,
                    DirectPurchase::class,
                ],
                function ($query, $type) use ($user) {
                    if ($type == Purchase::class) {
                        $query->where(function ($query) use ($user) {
                            $query->where('buyer_id', '=', $user->id);
                            $query->orWhere('seller_id', '=', $user->id);
                        });
                    } elseif ($type === Sale::class) {
                        $query->where(function ($query) use ($user) {
                            $query->where('buyer_id', '=', $user->id);
                        });
                    } elseif ($type === DirectPurchase::class) {
                        $query->where(function ($query) use ($user) {
                            $query->where('seller_id', '=', $user->id);
                        });
                    } elseif ($type === UpdateUsersBalance::class) {
                        $query->where('user_id', $user->id);
                    }
                }
            )
            ->when($pass_dates, function ($q) use ($dates) {
                $q->whereBetween('created_at', $dates);
            })
            ->latest()
            ->paginate();

        $general = GeneralSetting::first();

        return view('backend.users.account_statement_pdf', compact('user', 'dates', 'transactions', 'general'));
    }

    public function userDetails(Request $request)
    {
        $user = User::where('id', $request->user)->firstOrFail();
        $payment = Payment::with('transfer')->where('user_id', $user->id)->where('payment_status', 1)->latest()->first();
        $pageTitle = "تفاصيل المستخدم";
        return view('backend.users.details', compact('pageTitle', 'user'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'unique:users,phone,' . $user->id,
            'status' => 'required|in:0,1'
        ], [
            'fname.required' => 'حقل الاسم الأول مطلوب.',
            'lname.required' => 'حقل الاسم الأخير مطلوب.',
            'phone.unique' => 'رقم الهاتف موجود بالفعل في السجلات.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'قيمة الحالة يجب أن تكون إما 0 أو 1.'
        ]);

        $data = [
            'country' => $request->country,
            'city' => $request->city,
            'zip' => $request->zip,
            'state' => $request->state,
        ];

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->address = $data;
        $user->status = $request->status;
        $user->save();
        $notify[] = ['success', 'تم تحديث المستخدم بنجاح'];

        return back()->withNotify($notify);
    }

    public function sendUserMail(Request $request, User $user)
    {
        $data = $request->validate([
            'subject' => 'required',
            "message" => 'required',
        ], [
            'subject.required' => 'حقل الموضوع مطلوب.',
            'message.required' => 'حقل الرسالة مطلوب.',
        ]);
        $data['name'] = $user->fullname;
        $data['email'] = $user->email;
        sendGeneralMail($data);
        $notify[] = ['success', 'تم ارسال البريد الألكتروني الي المستخدم بنجاح'];
        return back()->withNotify($notify);
    }

    public function disabled(Request $request)
    {
        $pageTitle = 'Disabled Users';
        $search = $request->search;
        $users = User::when($search, function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('company_name', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('mobile', 'LIKE', '%' . $search . '%');
        })->where('status', 0)->latest()->paginate();
        return view('backend.users.index', compact('pageTitle', 'users'));
    }

    public function userStatusWiseFilter(Request $request)
    {
        $data['pageTitle'] = ucwords($request->status) . ' Users';
        $data['navManageUserActiveClass'] = 'active';
        if ($request->status == 'active') {
            $data['subNavActiveUserActiveClass'] = 'active';
        } else {
            $data['subNavDeactiveUserActiveClass'] = 'active';
        }

        $users = User::query();

        if ($request->status == 'active') {
            $users->where('status', 1);
        } elseif ($request->status == 'deactive') {
            $users->where('status', 0);
        }
        $data['users'] = $users->paginate();
        return view('backend.users.index')->with($data);
    }

    public function userBalanceUpdate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'balance' => 'required|numeric|gt:0',
            'note' => 'nullable|string',
        ], [
            'user_id.required' => 'حقل معرف المستخدم مطلوب.',
            'user_id.numeric' => 'يجب أن يكون معرف المستخدم رقمًا.',
            'balance.required' => 'حقل الرصيد مطلوب.',
            'balance.numeric' => 'يجب أن يكون الرصيد رقمًا.',
            'balance.gt' => 'يجب أن يكون الرصيد أكبر من صفر.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $user = User::findOrFail($request->user_id);
        if ($request->input('action') == 'add') {
            $user->balance =  $user->balance + $request->balance;
        } else {
            $user->balance =  $user->balance - $request->balance;
        }

        $user->save();

        $updated_balance = UpdateUsersBalance::create([
            'user_id' => $user->id,
            'type' => $request->input('action'),
            'amount' => $request->balance,
            'floating_balance' => $user->balance,
            'note' => $request->note,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $updated_balance->amount;
        $transaction->charge = 0;
        $updated_balance->transactional()->save($transaction);

        $user->notify(new UpdateUserBalanceNotification($updated_balance, $request->input('action')));

        if( $request->input('action') == 'add') {
            $notify[] = ['success', 'تم إيداع الرصيد بنجاح'];
        } else {
            $notify[] = ['success', 'تم سحب الرصيد بنجاح'];
        }
        return back()->withNotify($notify);
    }

    public function loginAsUser($id)
    {
        $user = User::findOrFail($id);
        Auth::loginUsingId($user->id);
        return redirect()->route('user.transaction.log');
    }
}
