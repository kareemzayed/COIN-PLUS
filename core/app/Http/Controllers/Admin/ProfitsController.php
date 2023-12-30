<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\SystemTransaction;
use App\Http\Controllers\Controller;
use App\Models\DirectPurchase;
use App\Models\Expense;
use App\Models\ExternalTransaction;
use App\Models\TransactionWithCurrency;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProfitsController extends Controller
{
    public function profits(Request $request)
    {
        $data['pageTitle'] = 'الأرباح';
        $dateString = $request->input('date') ?? now()->format('Y-m');
        $date = Carbon::createFromFormat('Y-m', $dateString);

        $expenses = Expense::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->get();

        $totalAmountOfExpenses = $expenses->sum('amount');
        $totalExpenses = $expenses->count();

        $transactions = SystemTransaction::with(['transactional' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                Purchase::class => ['buyer', 'seller'],
                Sale::class => ['fund', 'buyer'],
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
                    ExternalTransaction::class,
                    TransactionWithCurrency::class,
                    DirectPurchase::class,
                ]
            )
            ->whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->get();

        $groupedProfits = $transactions->groupBy('transactional_type')
            ->map(function ($transactions) {
                return [
                    'totalProfits' => $transactions->sum('charge'),
                    'transactionCount' => $transactions->count(),
                ];
            });

        $totalProfits = $groupedProfits->sum('totalProfits');
        $totalNetProfits = $totalProfits - $totalAmountOfExpenses;
        $totalTrans = $groupedProfits->sum('transactionCount');

        return view('backend.profits.index', compact('dateString', 'groupedProfits', 'totalProfits', 'totalTrans', 'totalNetProfits', 'totalAmountOfExpenses', 'totalExpenses'))->with($data);
    }
}