<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Fund;
use App\Models\Sale;
use App\Models\User;
use App\Models\Check;
use App\Models\Ticket;
use App\Models\Purchase;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\DirectPurchase;
use App\Models\PaymentVoucher;
use App\Models\ReceiptVoucher;
use App\Models\FundsTransaction;
use App\Models\SystemTransaction;
use App\Models\TransactionReport;
use App\Models\UpdateUsersBalance;
use App\Models\ExternalTransaction;
use App\Http\Controllers\Controller;
use App\Models\TransactionWithCurrency;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        if ($request->search) {
            $searchValue = $request->search;
            if (preg_match('/^AC-\w+/', $searchValue)) {
                return redirect()->route('admin.user', ['account_number' => $searchValue]);
            } elseif (filter_var($searchValue, FILTER_VALIDATE_EMAIL)) {
                return redirect()->route('admin.user', ['email' => $searchValue]);
            } else {
                return redirect()->route('admin.transaction', ['utr' => $searchValue]);
            }
        }

        $data['pageTitle'] = 'لوحة التحكم';
        $data['navDashboardActiveClass'] = "active";
        $data['totalTickets'] = Ticket::count();
        $data['totalTransReports'] = TransactionReport::count();
        $data['totalFunds'] = Fund::count();
        $data['totalUser'] = User::count();
        $data['activeUser'] = User::where('status', 1)->count();
        $data['deActiveUser'] = User::where('status', 0)->count();
        $data['purchasesTransactions'] = Purchase::count();
        $data['salesTransactions'] = Sale::count();
        $data['externalTransactions'] = ExternalTransaction::count();
        $data['receiptVouchers'] = ReceiptVoucher::count();
        $data['paymentVouchers'] = PaymentVoucher::count();
        $data['transWithCurrencies'] = TransactionWithCurrency::count();
        $data['directPurchase'] = DirectPurchase::count();
        $data['checks'] = Check::count();

        return view('backend.dashboard')->with($data);
    }

    public function transaction(Request $request)
    {
        $data['pageTitle'] = 'سجل المعاملات';
        $search['utr'] = $request->utr;
        $search['date'] = $request->date;

        $dates = array_map(function ($date) {
            return Carbon::parse($date);
        }, explode('-', $request->dates));

        if ($search['utr']) {
            $morphWith = [
                Purchase::class => ['buyer', 'seller'],
                Sale::class => ['fund', 'buyer'],
                UpdateUsersBalance::class => ['user'],
                FundsTransaction::class => ['fund'],
                ExternalTransaction::class,
                TransactionWithCurrency::class => ['currency'],
                DirectPurchase::class => ['seller', 'fund'],
            ];
            $whereHasMorph = [
                Purchase::class,
                Sale::class,
                UpdateUsersBalance::class,
                FundsTransaction::class,
                ExternalTransaction::class,
                TransactionWithCurrency::class,
                DirectPurchase::class,
            ];

            $data['transactions'] = SystemTransaction::with(['transactional' => function (MorphTo $morphTo) use ($morphWith, $whereHasMorph) {
                $morphTo->morphWith($morphWith);
            }])
                ->whereHasMorph(
                    'transactional',
                    $whereHasMorph,
                    function ($query, $type) use ($search) {
                        $query->when(isset($search['utr']), function ($query) use ($search) {
                            return $query->where('utr', 'LIKE', $search['utr']);
                        });
                    }
                )->latest()
                ->paginate(15);

            $totalCharge = $data['transactions']->sum('charge');

            return view('backend.transaction', compact('dates', 'totalCharge'))->with($data);
        }

        $data['transactions'] = SystemTransaction::with(['transactional' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                Purchase::class => ['buyer', 'seller'],
                Sale::class => ['fund', 'buyer'],
                UpdateUsersBalance::class => ['user'],
                PaymentVoucher::class,
                ReceiptVoucher::class,
                FundsTransaction::class => ['fund'],
                ExternalTransaction::class,
                TransactionWithCurrency::class => ['currency'],
                DirectPurchase::class => ['seller', 'fund'],
            ]);
        }])
            ->whereHasMorph(
                'transactional',
                [
                    Purchase::class,
                    Sale::class,
                    UpdateUsersBalance::class,
                    PaymentVoucher::class,
                    ReceiptVoucher::class,
                    FundsTransaction::class,
                    ExternalTransaction::class,
                    TransactionWithCurrency::class,
                    DirectPurchase::class,
                ]
            )
            ->when($request->dates, function ($q) use ($dates) {
                $q->whereBetween('created_at', $dates);
            })
            ->when($search['date'], function ($q) use ($search) {
                if (preg_match('/^\d{4}-\d{2}$/', $search['date'])) {
                    list($year, $month) = explode('-', $search['date']);
                    $q->whereYear('created_at', $year)->whereMonth('created_at', $month);
                } else {
                    $q->whereDate('created_at', $search['date']);
                }
            })
            ->latest()
            ->paginate(20);

        $totalCharge = $data['transactions']->sum('charge');

        return view('backend.transaction', compact('dates', 'totalCharge'))->with($data);
    }

    public function markNotification(Request $request)
    {
        auth()->guard('admin')->user()
            ->unreadNotifications
            ->markAsRead();

        return redirect()->back()->with('success', 'تم تعليم جميع الأشعارات كمقروءة');
    }

    public function subscribers()
    {
        $pageTitle = "Newsletter Subscriber";
        $subscribers = Subscriber::latest()->paginate();
        return view('backend.subscriber', compact('subscribers', 'pageTitle'));
    }
}
