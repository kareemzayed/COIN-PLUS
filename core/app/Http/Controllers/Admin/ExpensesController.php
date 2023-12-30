<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة المصروفات';

        $search['utr'] = $request->utr;
        $search['expense_type'] = $request->expense_type;
        $search['date'] = $request->date;

        $data['expenses'] = Expense::when($search['utr'], function ($q) use ($search) {
            $q->where('utr', 'LIKE', '%' . $search['utr'] . '%');
        })
            ->when($search['expense_type'], function ($q) use ($search) {
                $q->where('expense_type', 'LIKE', '%' . $search['expense_type'] . '%');
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

        return view('backend.expenses.index', compact('search'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'expense_type' => 'required|string',
            'amount' => 'required|numeric',
            'note' => 'nullable|string'
        ], [
            'expense_type.required' => 'حقل نوع المصروف مطلوب.',
            'expense_type.string' => 'يجب أن يكون نوع المصروف نصًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        Expense::create([
            'expense_type' => $request->expense_type,
            'amount' => $request->amount,
            'note' => $request->note ?? null,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $notify[] = ['success', 'تم انشاء المصروف بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'expense_type' => 'required|string',
            'amount' => 'required|numeric',
            'note' => 'nullable|string'
        ], [
            'expense_type.required' => 'حقل نوع المصروف مطلوب.',
            'expense_type.string' => 'يجب أن يكون نوع المصروف نصًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->update([
            'expense_type' => $request->expense_type,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);

        $notify[] = ['success', 'تم تعديل المصروف بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        $notify[] = ['success', 'تم حذف المصروف بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}