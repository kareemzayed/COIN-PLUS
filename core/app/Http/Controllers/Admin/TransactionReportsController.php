<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionReport;
use App\Notifications\AdminReplyTransReportNotification;
use Illuminate\Http\Request;

class TransactionReportsController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = "قائمة بلاغات المعاملات";

        $search['utr'] = $request->utr;
        $search['transaction_utr'] = $request->transaction_utr;
        $search['status'] = $request->status;
        $search['date'] = $request->date;

        $data['reports'] = TransactionReport::with('user')
            ->when($search['utr'], function ($item) use ($search) {
                $item->where('utr', 'LIKE', '%' . $search['utr'] . '%');
            })
            ->when($search['transaction_utr'], function ($item) use ($search) {
                $item->where('transaction_utr', 'LIKE', '%' . $search['transaction_utr'] . '%');
            })
            ->when($search['status'], function ($item) use ($search) {
                $item->where('replied', $search['status']);
            })
            ->when($search['date'], function ($item) use ($search) {
                $item->whereDate('created_at', $search['date']);
            })
            ->latest()->paginate();
        return view('backend.transaction_reports.index', compact('search'))->with($data);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ], [
            'reply.required' => 'حقل الرد مطلوب.',
            'reply.string' => 'يجب أن يكون الرد نصًا.',
        ]);

        $report = TransactionReport::findOrFail($id);

        $amount_after = 0;
        if (($report->transaction->transactional_type == 'App\Models\Purchase' && $report->transaction->transactional->buyer == $report->user)) {
            $amount_after =  $report->transaction->transactional->sales_cost;
        } elseif (($report->transaction->transactional_type == 'App\Models\Purchase' && $report->transaction->transactional->seller == $report->user)) {
            $amount_after = $report->transaction->transactional->purchase_cost;
        } elseif ($report->transaction->transactional_type == 'App\Models\Sale') {
            $amount_after = $report->transaction->transactional->sales_cost;
        } elseif ($report->transaction->transactional_type == 'App\Models\DirectPurchase') {
            $amount_after = $report->transaction->transactional->purchase_cost;
        } else {
            $amount_after = $report->transaction->amount;
        }

        $report->admin_reply = $request->reply;
        $report->amount_after = $amount_after;
        $report->replied = 1;
        $report->save();

        $user = $report->user;
        $user->notify(new AdminReplyTransReportNotification($report));

        $notify[] = ['success', 'تم الرد علي البلاغ بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}
