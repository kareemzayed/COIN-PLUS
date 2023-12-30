<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\DirectPurchase;
use App\Models\SystemTransaction;
use App\Models\TransactionReport;
use App\Models\UpdateUsersBalance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserSendReportNotification;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserController extends Controller
{
    public function profile()
    {
        $pageTitle = 'تعديل الملف الشخصي';
        $user = auth()->user();
        return view(template() . 'user.profile', compact('pageTitle', 'user'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required|unique:users,username,' . Auth::id(),
            'image' => 'sometimes|image|mimes:jpg,png,jpeg',
            'email' => 'required|unique:users,email,' . Auth::id(),
            'phone' => 'unique:users,id,' . Auth::id(),
        ], [
            'fname.required' => 'يجب إدخال الاسم الأول.',
            'lname.required' => 'يجب إدخال اسم العائلة.',
            'username.required' => 'يجب إدخال اسم المستخدم.',
            'username.unique' => 'اسم المستخدم مستخدم من قبل مستخدم آخر.',
            'image.image' => 'يجب أن يكون الملف المحدد صورة.',
            'image.mimes' => 'يجب أن تكون الصورة من نوع JPG، PNG، أو JPEG.',
            'email.required' => 'يجب إدخال البريد الإلكتروني.',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل مستخدم آخر.',
            'phone.unique' => 'رقم الهاتف مستخدم من قبل مستخدم آخر.',
        ]);


        $user = auth()->user();
        if ($request->hasFile('image')) {
            $filename = uploadImage($request->image, filePath('user', true), $user->image);
            $user->image = $filename;
        }
        $data = [
            'country' => $request->country,
            'city' => $request->city,
            'zip' => $request->zip,
            'state' => $request->state,
        ];
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->address = $data;
        $user->save();
        $notify[] = ['success', 'تم تحديث الملف الشخصي بنجاح'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'تغيير كلمة المرور';
        return view(template() . 'user.auth.changepassword', compact('pageTitle'));
    }

    public function updatePassword(Request $request)
    {
        $messages = [
            'oldpassword.required' => 'يتطلب إدخال كلمة المرور القديمة.',
            'oldpassword.min' => 'يجب أن تكون كلمة المرور القديمة على الأقل 6 أحرف.',
            'password.min' => 'يجب أن تكون كلمة المرور الجديدة على الأقل 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ];

        $request->validate([
            'oldpassword' => 'required|min:6',
            'password' => 'min:6|confirmed',
        ], $messages);


        $user = User::find(Auth::id());

        if (!Hash::check($request->oldpassword, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور القديمة غير متطابقة');
        } else {
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->back()->with('success', 'تم تحديث كلمة المرور بنجاح');
        }
    }

    public function reportTransaction(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'reason' => 'required|string',
        ], [
            'reason.required' => 'يجب إدخال سبب.',
            'reason.string' => 'يجب أن يكون السبب نصًا.',
        ]);

        $transaction = SystemTransaction::findOrFail($id);

        $amount_before = 0;
        if(($transaction->transactional_type == 'App\Models\Purchase' && $transaction->transactional->buyer == auth()->user())) {
            $amount_before = $transaction->transactional->sales_cost;
        } elseif($transaction->transactional_type == 'App\Models\Purchase' && $transaction->transactional->seller == auth()->user()) {
            $amount_before = $transaction->transactional->purchase_cost;
        } elseif ($transaction->transactional_type == 'App\Models\DirectPurchase') {
            $amount_before = $transaction->transactional->purchase_cost;
        } elseif($transaction->transactional_type == 'App\Models\Sale') {
            $amount_before = $transaction->transactional->sales_cost;
        } else {
            $amount_before = $transaction->amount;
        }

        $report = TransactionReport::create([
            'transaction_id' => $transaction->id,
            'user_id' => $user->id,
            'reason' => $request->reason,
            'amount_before' => $amount_before,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $user->notify(new UserSendReportNotification($report));
        return redirect()->back()->with('success', 'تم تقديم الشكوى بنجاح. سيتم التواصل معك قريبًا.');
    }

    public function transactionLog(Request $request)
    {
        $pageTitle = 'سجل المعاملات';
        $user = Auth::user();
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
                function ($query, $type) use ($user, $request) {
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
                    $query->when($request->utr, function ($query) use ($request) {
                        return $query->where('utr', 'LIKE', "%{$request->utr}%");
                    });
                }
            )
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('created_at', Carbon::parse($request->date));
            })
            ->when($request->transactional_type, function ($q) use ($request) {
                $q->where('transactional_type', $request->transactional_type);
            })
            ->latest()
            ->paginate(20);

        return view(template() . 'user.transaction', compact('pageTitle', 'transactions'));
    }

    public function notifications()
    {
        $data['pageTitle'] = 'الإشعارات';
        $data['notifications'] = auth()->user()->unreadNotifications;
        return view(template() . 'user.notifications')->with($data);
    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();
        return response()->noContent();
    }
}
