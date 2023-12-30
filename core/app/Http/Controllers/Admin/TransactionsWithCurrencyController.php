<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\SystemTransaction;
use App\Http\Controllers\Controller;
use App\Models\TransactionWithCurrency;
use App\Notifications\AdminTransactionWithCurrencyNotification;

class TransactionsWithCurrencyController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة المعاملات بعملات متعددة';

        $search['utr'] = $request->utr;
        $search['trans_type'] = $request->trans_type;
        $search['currency_id'] = $request->currency_id;
        $search['date'] = $request->date;

        $data['currencies'] = Currency::get();
        $data['transactions'] = TransactionWithCurrency::when($search['utr'], function ($q) use ($search) {
            $q->where('utr', 'LIKE', '%' . $search['utr'] . '%');
        })
            ->when($search['trans_type'], function ($q) use ($search) {
                $q->where('trans_type', $search['trans_type']);
            })
            ->when($search['currency_id'], function ($q) use ($search) {
                $q->where('currency_id', $search['currency_id']);
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

        return view('backend.transactions_with_currencies.index', compact('search'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'trans_type' => 'required|in:1,2',
            'currency_id' => 'required|numeric|not_in:0',
            'amount_in_other_currency' => 'required|numeric',
            'amount_in_base_currency' => 'required|numeric',
            'charge_type' => 'required|numeric|in:1,2',
            'charge_value' => 'required|numeric',
            'note' => 'nullable|string',
        ], [
            'trans_type.required' => 'حقل نوع المعاملة مطلوب.',
            'trans_type.in' => 'قيمة نوع المعاملة غير صالحة.',
            'currency_id.required' => 'حقل عملة المعاملة مطلوب.',
            'currency_id.numeric' => 'قيمة عملة المعاملة يجب أن تكون رقمية.',
            'currency_id.not_in' => 'يجب تحديد عملة المعاملة.',
            'amount_in_other_currency.required' => 'حقل مبلغ المعاملة بالعملة مطلوب.',
            'amount_in_other_currency.numeric' => 'قيمة مبلغ المعاملة بالعملة يجب أن تكون رقمية.',
            'amount_in_base_currency.required' => 'حقل مبلغ المعاملة بالعملة الأساسية مطلوب.',
            'amount_in_base_currency.numeric' => 'قيمة مبلغ المعاملة بالعملة الأساسية يجب أن تكون رقمية.',
            'charge_type.required' => 'حقل نوع الرسوم مطلوب.',
            'charge_type.numeric' => 'قيمة نوع الرسوم يجب أن تكون رقمية.',
            'charge_value.required' => 'حقل الرسوم مطلوب.',
            'charge_value.numeric' => 'قيمة الرسوم يجب أن تكون رقمية.',
            'note.string' => 'قيمة الملاحظة يجب أن تكون نصية.',
        ]);

        $charge = 0;
        if ($request->charge_type == 1) {
            $charge = $request->charge_value;
        } elseif ($request->charge_type == 2) {
            $charge = ($request->amount_in_base_currency * $request->charge_value) / 100;
        }

        $transaction_with_currency = TransactionWithCurrency::create([
            'trans_type' => $request->trans_type,
            'currency_id' => $request->currency_id,
            'amount_in_other_currency' => $request->amount_in_other_currency,
            'amount_in_base_currency' => $request->amount_in_base_currency,
            'charge_type' => $request->charge_type,
            'charge_value' => $request->charge_value,
            'charge' => $charge,
            'note' => $request->note ?? null,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $transaction_with_currency->amount_in_base_currency;
        $transaction->charge = $transaction_with_currency->charge;
        $transaction_with_currency->transactional()->save($transaction);

        $admin = Admin::first();
        $admin->notify(new AdminTransactionWithCurrencyNotification($transaction_with_currency));

        $notify[] = ['success', 'تم إنشاء المعاملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'trans_type' => 'required|in:1,2',
            'currency_id' => 'required|numeric|not_in:0',
            'amount_in_other_currency' => 'required|numeric',
            'amount_in_base_currency' => 'required|numeric',
            'charge_type' => 'required|numeric|in:1,2',
            'charge_value' => 'required|numeric',
            'note' => 'nullable|string',
        ], [
            'trans_type.required' => 'حقل نوع المعاملة مطلوب.',
            'trans_type.in' => 'قيمة نوع المعاملة غير صالحة.',
            'currency_id.required' => 'حقل عملة المعاملة مطلوب.',
            'currency_id.numeric' => 'قيمة عملة المعاملة يجب أن تكون رقمية.',
            'currency_id.not_in' => 'يجب تحديد عملة المعاملة.',
            'amount_in_other_currency.required' => 'حقل مبلغ المعاملة بالعملة مطلوب.',
            'amount_in_other_currency.numeric' => 'قيمة مبلغ المعاملة بالعملة يجب أن تكون رقمية.',
            'amount_in_base_currency.required' => 'حقل مبلغ المعاملة بالعملة الأساسية مطلوب.',
            'amount_in_base_currency.numeric' => 'قيمة مبلغ المعاملة بالعملة الأساسية يجب أن تكون رقمية.',
            'charge_type.required' => 'حقل نوع الرسوم مطلوب.',
            'charge_type.numeric' => 'قيمة نوع الرسوم يجب أن تكون رقمية.',
            'charge_value.required' => 'حقل الرسوم مطلوب.',
            'charge_value.numeric' => 'قيمة الرسوم يجب أن تكون رقمية.',
            'note.string' => 'قيمة الملاحظة يجب أن تكون نصية.',
        ]);

        $charge = 0;
        if ($request->charge_type == 1) {
            $charge = $request->charge_value;
        } elseif ($request->charge_type == 2) {
            $charge = ($request->amount_in_base_currency * $request->charge_value) / 100;
        }

        $transaction_with_currency = TransactionWithCurrency::findOrFail($id);
        $transaction_with_currency->update([
            'trans_type' => $request->trans_type,
            'currency_id' => $request->currency_id,
            'amount_in_base_currency' => $request->amount_in_base_currency,
            'amount_in_other_currency' => $request->amount_in_other_currency,
            'charge_type' => $request->charge_type,
            'charge_value' => $request->charge_value,
            'charge' => $charge,
            'note' => $request->note ?? null,
        ]);

        if ($transaction_with_currency->transactional) {
            $transaction_with_currency->transactional->update([
                'charge' => $transaction_with_currency->charge,
                'amount' => $transaction_with_currency->amount_in_base_currency,
            ]);
        }

        $notify[] = ['success', 'تم تعديل المعاملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $transaction_with_currency = TransactionWithCurrency::findOrFail($id);

        if ($transaction_with_currency->transactional) {
            $transaction_with_currency->transactional->delete();
        }
        $transaction_with_currency->delete();

        $notify[] = ['success', 'تم حذف المعاملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}