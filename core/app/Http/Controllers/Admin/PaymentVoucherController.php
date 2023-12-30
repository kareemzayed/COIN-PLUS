<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\PaymentVoucher;
use App\Models\SystemTransaction;
use App\Http\Controllers\Controller;
use App\Notifications\PaymentVoucherNotification;

class PaymentVoucherController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة سندات الصرف';
        $data['currencies'] = Currency::where('status', 1)->get();

        $search['receipt_number'] = $request->receipt_number;
        $search['customer_name'] = $request->customer_name;
        $search['date'] = $request->date;
        $search['type'] = $request->type;
        $search['currency_id'] = $request->currency_id;

        $data['payment_vouchers'] = PaymentVoucher::when($search['receipt_number'], function ($q) use ($search) {
            $q->where('receipt_num', 'LIKE', '%' . $search['receipt_number'] . '%');
        })
            ->when($search['customer_name'], function ($q) use ($search) {
                $q->where('customar_name', 'LIKE', '%' . $search['customer_name'] . '%');
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
                $q->where('receipt_type', $search['type']);
            })
            ->when($search['currency_id'], function ($q) use ($search) {
                $q->where('currency_id', $search['currency_id']);
            })
            ->latest()->paginate(10);
        return view('backend.payment_vouchers.index', compact('search'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'customar_name' => 'required|string|max:255',
            'currency_id' => 'required|numeric',
            'amount_in_words' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'receipt_type' => 'required|numeric|in:1,2',
            'check_no' => 'nullable|string|max:255',
            'bank' => 'nullable|string|max:255',
            'exchange_for' => 'nullable|string',
            'note' => 'nullable|string',
        ], [
            'customar_name.required' => 'حقل اسم العميل مطلوب.',
            'currency_id.required' => 'حقل عملة السند مطلوب.',
            'customar_name.string' => 'يجب أن يكون اسم العميل نصًا.',
            'customar_name.max' => 'يجب ألا يتجاوز اسم العميل :max حرفًا.',
            'amount_in_words.required' => 'حقل المبلغ بالكلمات مطلوب.',
            'amount_in_words.string' => 'يجب أن يكون المبلغ بالكلمات نصًا.',
            'amount_in_words.max' => 'يجب ألا يتجاوز المبلغ بالكلمات :max حرفًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'receipt_type.required' => 'حقل نوع الإيصال مطلوب.',
            'receipt_type.numeric' => 'يجب أن يكون نوع الإيصال رقمًا.',
            'receipt_type.in' => 'قيمة نوع الإيصال يجب أن تكون إما 1 أو 2.',
            'check_no.string' => 'يجب أن يكون رقم الشيك نصًا.',
            'check_no.max' => 'يجب ألا يتجاوز رقم الشيك :max حرفًا.',
            'bank.string' => 'يجب أن يكون اسم البنك نصًا.',
            'bank.max' => 'يجب ألا يتجاوز اسم البنك :max حرفًا.',
            'exchange_for.string' => 'يجب أن يكون سبب التحويل نصًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $payment_voucher = PaymentVoucher::create([
            'receipt_num' => null,
            'customar_name' => $request->customar_name,
            'currency_id' => $request->currency_id,
            'amount' => $request->amount,
            'amount_in_words' => $request->amount_in_words,
            'receipt_type' => $request->receipt_type,
            'check_no' => $request->check_no,
            'bank' => $request->bank,
            'exchange_for' => $request->exchange_for,
            'note' => $request->note
        ]);

        $payment_voucher->update([
            'receipt_num' => generateVoucherNumber($payment_voucher->id)
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $payment_voucher->amount;
        $transaction->charge = 0;
        $payment_voucher->transactional()->save($transaction);

        $admin = Admin::first();
        $admin->notify(new PaymentVoucherNotification($payment_voucher));

        $action = $request->input('action');
        if ($action == 'save') {
            $notify[] = ['success', 'تم إنشاء سند الصرف بنجاح'];
            return redirect()->back()->withNotify($notify);
        } elseif ($action == 'saveAndPrint') {
            return view('backend.payment_vouchers.pdf', compact('payment_voucher'));
        }
    }

    public function print($id)
    {
        $payment_voucher = PaymentVoucher::findOrFail($id);
        return view('backend.payment_vouchers.pdf', compact('payment_voucher'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customar_name' => 'required|string|max:255',
            'currency_id' => 'required|numeric',
            'amount_in_words' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'receipt_type' => 'required|numeric|in:1,2',
            'check_no' => 'nullable|string|max:255',
            'bank' => 'nullable|string|max:255',
            'exchange_for' => 'nullable|string',
            'note' => 'nullable|string',
        ], [
            'customar_name.required' => 'حقل اسم العميل مطلوب.',
            'currency_id.required' => 'حقل عملة السند مطلوب.',
            'customar_name.string' => 'يجب أن يكون اسم العميل نصًا.',
            'customar_name.max' => 'يجب ألا يتجاوز اسم العميل :max حرفًا.',
            'amount_in_words.required' => 'حقل المبلغ بالكلمات مطلوب.',
            'amount_in_words.string' => 'يجب أن يكون المبلغ بالكلمات نصًا.',
            'amount_in_words.max' => 'يجب ألا يتجاوز المبلغ بالكلمات :max حرفًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'receipt_type.required' => 'حقل نوع الإيصال مطلوب.',
            'receipt_type.numeric' => 'يجب أن يكون نوع الإيصال رقمًا.',
            'receipt_type.in' => 'قيمة نوع الإيصال يجب أن تكون إما 1 أو 2.',
            'check_no.string' => 'يجب أن يكون رقم الشيك نصًا.',
            'check_no.max' => 'يجب ألا يتجاوز رقم الشيك :max حرفًا.',
            'bank.string' => 'يجب أن يكون اسم البنك نصًا.',
            'bank.max' => 'يجب ألا يتجاوز اسم البنك :max حرفًا.',
            'exchange_for.string' => 'يجب أن يكون سبب التحويل نصًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $payment_voucher = PaymentVoucher::with('transactional')->findOrFail($id);

        $payment_voucher->update([
            'check_no' => $request->receipt_type == 2 ? $request->check_no : null,
            'bank' => $request->receipt_type == 2 ? $request->bank : null,
        ]);

        $payment_voucher->update([
            'customar_name' => $request->customar_name,
            'currency_id' => $request->currency_id,
            'amount' => $request->amount,
            'amount_in_words' => $request->amount_in_words,
            'receipt_type' => $request->receipt_type,
            'exchange_for' => $request->exchange_for,
            'note' => $request->note,
        ]);

        if ($payment_voucher->transactional) {
            $payment_voucher->transactional->update([
                'amount' => $request->amount,
                'charge' => 0,
            ]);
        }

        $action = $request->input('action');
        if ($action == 'save') {
            $notify[] = ['success', 'تم تعديل سند الصرف بنجاح'];
            return redirect()->back()->withNotify($notify);
        } elseif ($action == 'saveAndPrint') {
            return view('backend.payment_vouchers.pdf', compact('payment_voucher'));
        }
    }

    public function delete($id)
    {
        $payment_voucher = PaymentVoucher::with('transactional')->findOrFail($id);
        if ($payment_voucher->transactional) {
            $payment_voucher->transactional->delete();
        }
        $payment_voucher->delete();
        $notify[] = ['success', 'تم حذف سند الصرف بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}
