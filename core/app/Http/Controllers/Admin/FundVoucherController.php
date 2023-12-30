<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ReceiptVoucher;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\PaymentVoucher;

class FundVoucherController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'صندوق السندات';

        $search['date'] = $request->date;
        $deposits = ReceiptVoucher::when($search['date'], function ($query) use ($search) {
            return $query->whereYear('created_at', '=', date('Y', strtotime($search['date'])))
                ->whereMonth('created_at', '=', date('m', strtotime($search['date'])));
        })->selectRaw('currency_id, count(*) as count, sum(amount) as totalAmount')
            ->groupBy('currency_id')
            ->get();

        $withdrawlas = PaymentVoucher::when($search['date'], function ($query) use ($search) {
            return $query->whereYear('created_at', '=', date('Y', strtotime($search['date'])))
                ->whereMonth('created_at', '=', date('m', strtotime($search['date'])));
        })->selectRaw('currency_id, count(*) as count, sum(amount) as totalAmount')
            ->groupBy('currency_id')
            ->get();

        $formattedResultsDeposits = [];
        foreach ($deposits as $deposit) {
            $currency = Currency::find($deposit->currency_id);
            $formattedResultsDeposits[$currency->name] = [
                'count' => $deposit->count,
                'totalAmount' => $deposit->totalAmount,
                'currency_id' => $deposit->currency_id,
                'currency_code' => $currency->code,
            ];
        }

        $formattedResultsWithdrawals = [];
        foreach ($withdrawlas as $withdraw) {
            $currency = Currency::find($withdraw->currency_id);
            $formattedResultsWithdrawals[$currency->name] = [
                'count' => $withdraw->count,
                'totalAmount' => $withdraw->totalAmount,
                'currency_id' => $withdraw->currency_id,
                'currency_code' => $currency->code,
            ];
        }

        return view('backend.vouchers_fund.index', compact('formattedResultsWithdrawals', 'formattedResultsDeposits', 'deposits', 'withdrawlas', 'search'))->with($data);
    }
}
