<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\SystemTransaction;
use App\Models\ExternalTransaction;
use App\Http\Controllers\Controller;
use App\Notifications\AdminExternalTransaction;

class ExternalTransactionController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة المعاملات الخارجية';

        $search['utr'] = $request->utr;
        $search['customar_name'] = $request->customar_name;
        $search['date'] = $request->date;
        $search['trans_type'] = $request->trans_type;

        $data['external_transactions'] = ExternalTransaction::when($search['utr'], function ($q) use ($search) {
            $q->where('utr', 'LIKE', '%' . $search['utr'] . '%');
        })
            ->when($search['customar_name'], function ($q) use ($search) {
                $q->where('customar_name', 'LIKE', '%' . $search['customar_name'] . '%');
            })
            ->when($search['trans_type'], function ($q) use ($search) {
                $q->where('trans_type', $search['trans_type']);
            })
            ->when($search['date'], function ($q) use ($search) {
                if (preg_match('/^\d{4}-\d{2}$/', $search['date'])) {
                    list($year, $month) = explode('-', $search['date']);
                    $q->whereYear('created_at', $year)->whereMonth('created_at', $month);
                } else {
                    $q->whereDate('created_at', $search['date']);
                }
            })
            ->latest()->paginate(10);
        return view('backend.external_transaction.index', compact('search'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'trans_type' => 'required|in:1,2',
            'customar_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'charge' => 'required|numeric',
            'details' => 'nullable|string'
        ], [
            'trans_type.required' => 'حقل نوع المعاملة مطلوب.',
            'trans_type.in' => 'قيمة نوع المعاملة غير صالحة.',
            'customar_name.required' => 'حقل اسم العميل مطلوب.',
            'customar_name.string' => 'يجب أن يكون اسم العميل نصًا.',
            'customar_name.max' => 'يجب ألا يتجاوز اسم العميل :max حرفًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'charge.required' => 'حقل صافي الربح مطلوب.',
            'charge.numeric' => 'يجب أن تكون صافي الربح رقمًا.',
            'details.string' => 'يجب أن تكون تفاصيل المعاملة نصًا.',
        ]);

        $external_transaction = ExternalTransaction::create([
            'trans_type' => $request->trans_type,
            'customar_name' => $request->customar_name,
            'amount' => $request->amount,
            'charge' => $request->charge,
            'details' => $request->details ?? null,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $external_transaction->amount;
        $transaction->charge = $external_transaction->charge;
        $external_transaction->transactional()->save($transaction);

        $admin = Admin::first();
        $admin->notify(new AdminExternalTransaction($external_transaction));

        $notify[] = ['success', 'تم اتمام المعاملة الخارجية بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'trans_type' => 'required|in:1,2',
            'customar_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'charge' => 'required|numeric',
            'details' => 'nullable|string'
        ], [
            'trans_type.required' => 'حقل نوع المعاملة مطلوب.',
            'trans_type.in' => 'قيمة نوع المعاملة غير صالحة.',
            'customar_name.required' => 'حقل اسم العميل مطلوب.',
            'customar_name.string' => 'يجب أن يكون اسم العميل نصًا.',
            'customar_name.max' => 'يجب ألا يتجاوز اسم العميل :max حرفًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'charge.required' => 'حقل صافي الربح مطلوب.',
            'charge.numeric' => 'يجب أن تكون صافي الربح رقمًا.',
            'details.string' => 'يجب أن تكون تفاصيل المعاملة نصًا.',
        ]);

        $external_transaction = ExternalTransaction::findOrFail($id);

        $external_transaction->update([
            'trans_type' => $request->trans_type,
            'customar_name' => $request->customar_name,
            'amount' => $request->amount,
            'charge' => $request->charge,
            'details' => $request->details ?? null,
        ]);

        if ($external_transaction->transactional) {
            $external_transaction->transactional->update([
                'charge' => $external_transaction->charge,
                'amount' => $external_transaction->amount,
            ]);
        }

        $notify[] = ['success', 'تم تعديل المعاملة الخارجية بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $external_transaction = ExternalTransaction::findOrFail($id);
        if ($external_transaction->transactional) {
            $external_transaction->transactional->delete();
        }

        $external_transaction->delete();
        $notify[] = ['success', 'تم حذف المعاملة الخارجية بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}