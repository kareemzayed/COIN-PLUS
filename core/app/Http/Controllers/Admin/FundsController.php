<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fund;
use Illuminate\Http\Request;
use App\Models\FundsTransaction;
use App\Models\SystemTransaction;
use App\Http\Controllers\Controller;

class FundsController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة صناديق الشركة';

        $search['name'] = $request->name;
        $search['date'] = $request->date;
        $search['status'] = $request->status;

        $data['funds'] = Fund::when($search['name'], function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search['name'] . '%');
        })
            ->when($search['date'], function ($q) use ($search) {
                $q->whereDate('created_at', $search['date']);
            })
            ->when($search['status'], function ($q) use ($search) {
                $q->where('status', $search['status']);
            })
            ->latest()->paginate(10);
        return view('backend.funds.index', compact('search'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:funds,name|max:255|string',
            'status' => 'required|in:2,1'
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.unique' => 'الاسم موجود بالفعل في السجلات.',
            'name.max' => 'يجب أن لا يتجاوز الاسم :max حرفًا.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'قيمة الحالة يجب أن تكون إما 0 أو 1.'
        ]);
        Fund::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
        $notify[] = ['success', 'تم إنشاء الصندوق بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, Fund $fund)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:funds,name,' . $fund->id,
            'status' => 'required|in:2,1'
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب أن لا يتجاوز الاسم :max حرفًا.',
            'name.unique' => 'الاسم موجود بالفعل في السجلات. الرجاء اختيار اسم آخر.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'قيمة الحالة يجب أن تكون إما 0 أو 1.'
        ]);
        $fund->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        $notify[] = ['success', 'تم تعديل الصندوق بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function addBalance(Request $request, Fund $fund)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ], [
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'amount.min' => 'يجب أن يكون المبلغ على الأقل :min.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $fund->balance += $request->amount;
        $fund->save();

        $fund_transaction = FundsTransaction::create([
            'fund_id' => $fund->id,
            'type' => 'add balance',
            'amount' => $request->amount,
            'charge' => 0,
            'note' => $request->note ?? null,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $fund_transaction->amount;
        $transaction->charge = $fund_transaction->charge;
        $fund_transaction->transactional()->save($transaction);

        $notify[] = ['success', 'تم إيداع الرصيد بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function subtractBalance(Request $request, Fund $fund)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ], [
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'amount.min' => 'يجب أن يكون المبلغ على الأقل :min.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);
        $fund->balance -= $request->amount;
        $fund->save();

        $fund_transaction = FundsTransaction::create([
            'fund_id' => $fund->id,
            'type' => 'subtract balance',
            'amount' => $request->amount,
            'charge' => 0,
            'note' => $request->note ?? null,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $fund_transaction->amount;
        $transaction->charge = $fund_transaction->charge;
        $fund_transaction->transactional()->save($transaction);

        $notify[] = ['success', 'تم سحب المبلغ بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function fundsTransactions(Request $request)
    {
        $data['pageTitle'] = 'قائمة معاملات صناديق الشركة';

        $search['utr'] = $request->utr;
        $search['date'] = $request->date;
        $search['type'] = $request->type;

        $fund_transactions = FundsTransaction::with('fund', 'transactional')
            ->when($search['utr'], function ($q) use ($search) {
                $q->where('utr', 'LIKE', '%' . $search['utr'] . '%');
            })
            ->when($search['date'], function ($q) use ($search) {
                if (preg_match('/^\d{4}-\d{2}$/', $search['date'])) {
                    list($year, $month) = explode('-', $search['date']);
                    $q->whereYear('created_at', $year)->whereMonth('created_at', $month);
                } else {
                    $q->whereDate('created_at', $search['date']);
                }
            })
            ->when($search['type'], function ($q) use ($search) {
                $q->where('type', $search['type']);
            })
            ->latest()->paginate(10);

        return view('backend.funds.funds_transactions', compact('fund_transactions', 'search'))->with($data);
    }

    public function getFundTransactions(Request $request, $id)
    {
        $data['pageTitle'] = 'قائمة معاملات الصندوق';

        $search['utr'] = $request->utr;
        $search['date'] = $request->date;
        $search['type'] = $request->type;

        $fund = Fund::findOrFail($id);
        $fund_transactions = FundsTransaction::with('fund', 'transactional')
            ->where('fund_id', $fund->id)
            ->when($search['utr'], function ($q) use ($search) {
                $q->where('utr', 'LIKE', '%' . $search['utr'] . '%');
            })
            ->when($search['date'], function ($q) use ($search) {
                $q->whereDate('created_at', $search['date']);
            })
            ->when($search['type'], function ($q) use ($search) {
                $q->where('type', $search['type']);
            })
            ->latest()->paginate();

        return view('backend.funds.history', compact('fund_transactions', 'fund', 'search'))->with($data);
    }

    public function updateTransaction(Request $request, $id)
    {
        $transaction = FundsTransaction::with('fund', 'transactional')->findOrFail($id);
        $fund = $transaction->fund;
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ], [
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'amount.min' => 'يجب أن يكون المبلغ على الأقل :min.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        if ($transaction->type == 'add balance') {
            $fund->balance -= $transaction->amount;
            $fund->balance += $request->amount;
            $fund->save();
            $transaction->update([
                'amount' => $request->amount,
                'charge' => 0,
                'note' => $request->note ?? null,
            ]);
            if ($transaction->transactional) {
                $transaction->transactional->update([
                    'amount' => $transaction->amount,
                    'charge' => $transaction->charge,
                ]);
            }
        } elseif ($transaction->type == 'subtract balance') {
            $fund->balance += $transaction->amount;
            $fund->balance -= $request->amount;
            $fund->save();
            $transaction->update([
                'amount' => $request->amount,
                'charge' => 0,
                'note' => $request->note ?? null,
            ]);
            if ($transaction->transactional) {
                $transaction->transactional->update([
                    'amount' => $transaction->amount,
                    'charge' => $transaction->charge,
                ]);
            }
        }

        $notify[] = ['success', 'تم تحديث المعاملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $transaction = FundsTransaction::with('fund', 'transactional')->findOrFail($id);
        $fund = $transaction->fund;

        if ($transaction->type == 'add balance') {
            $fund->balance -= $transaction->amount;
            $fund->save();
        } elseif ($transaction->type == 'subtract balance') {
            $fund->balance += $transaction->amount;
            $fund->save();
        }

        if ($transaction->transactional) {
            $transaction->transactional->delete();
        }

        $transaction->delete();
        $notify[] = ['success', 'تم حذف المعاملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}