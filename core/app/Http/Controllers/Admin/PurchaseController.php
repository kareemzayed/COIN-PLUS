<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\SystemTransaction;
use App\Http\Controllers\Controller;
use App\Notifications\PurchaseAdminNotification;
use App\Notifications\PurchaseBuyerNotification;
use App\Notifications\PurchaseSellerNotification;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة معاملات الشراء';
        $data['users'] = User::get();

        $search['utr'] = $request->utr;
        $search['item'] = $request->item;
        $search['date'] = $request->date;

        $data['purchases'] = Purchase::when($search['utr'], function ($q) use ($search) {
            $q->where('utr', 'LIKE', '%' . $search['utr'] . '%');
        })
            ->when($search['item'], function ($q) use ($search) {
                $q->where('item_name', 'LIKE', '%' . $search['item'] . '%');
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

        return view('backend.purchases.index', compact('search'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'seller_account_number' => 'required|string',
            'buyer_account_number' => 'required|string',
            'amount' => 'required|numeric',
            'purchase_cost' => 'required|numeric',
            'sale_invoice' => 'required|numeric',
            'note' => 'nullable|string'
        ], [
            'item_name.required' => 'حقل اسم العنصر مطلوب.',
            'item_name.string' => 'يجب أن يكون اسم العنصر نصًا.',
            'item_name.max' => 'يجب ألا يتجاوز اسم العنصر :max حرفًا.',
            'seller_account_number.required' => 'حقل رقم حساب البائع مطلوب.',
            'seller_account_number.string' => 'يجب أن يكون رقم حساب البائع نصًا.',
            'buyer_account_number.required' => 'حقل رقم حساب المشتري مطلوب.',
            'buyer_account_number.string' => 'يجب أن يكون رقم حساب المشتري نصًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'purchase_cost.required' => 'حقل تكلفة الشراء مطلوب.',
            'purchase_cost.numeric' => 'يجب أن تكون تكلفة الشراء رقمًا.',
            'sale_invoice.required' => 'حقل فاتورة البيع مطلوب.',
            'sale_invoice.numeric' => 'يجب أن تكون فاتورة البيع رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $buyer = User::where('account_number', $request->buyer_account_number)
            ->first();

        if (!$buyer) {
            $notify[] = ['error', "رقم حساب المشتري غير موجود"];
            return redirect()->back()->withNotify($notify);
        }

        $seller = User::where('account_number', $request->seller_account_number)
            ->first();

        if (!$seller) {
            $notify[] = ['error', "رقم حساب البائع غير موجود"];
            return redirect()->back()->withNotify($notify);
        }

        if ($seller == $buyer) {
            $notify[] = ['error', 'لا يمكن ان يكون البائع هو نفس المشتري'];
            return redirect()->back()->withNotify($notify);
        }

        $seller->balance += $request->purchase_cost;
        $seller->save();
        $buyer->balance -= $request->sale_invoice;
        $buyer->save();
        $charge = $request->sale_invoice - $request->purchase_cost;

        $purchase = Purchase::create([
            'item_name' => $request->item_name,
            'seller_id' => $seller->id,
            'buyer_id' => $buyer->id,
            'amount' => $request->amount,
            'purchase_cost' => $request->purchase_cost,
            'sales_cost' => $request->sale_invoice,
            'seller_floating_balance' => $seller->balance,
            'buyer_floating_balance' => $buyer->balance,
            'charge' => $charge,
            'note' => $request->note ?? null,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $purchase->amount;
        $transaction->charge = $purchase->charge;
        $purchase->transactional()->save($transaction);

        $admin = Admin::first();
        $seller->notify(new PurchaseSellerNotification($purchase));
        $buyer->notify(new PurchaseBuyerNotification($purchase));
        $admin->notify(new PurchaseAdminNotification($purchase));

        $notify[] = ['success', 'تم اتمام عملية الشراء بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $purchase = Purchase::with('transactional')->findOrFail($id);
        $seller = $purchase->seller;
        $buyer = $purchase->buyer;

        $seller->balance -= $purchase->purchase_cost;
        $seller->save();

        $buyer->balance += $purchase->sales_cost;
        $buyer->save();

        if ($purchase->transactional) {
            $purchase->transactional->delete();
        }
        $purchase->delete();

        $notify[] = ['success', 'تم حذف عملية الشراء بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'buyer_account_number' => 'required|string',
            'seller_account_number' => 'required|string',
            'amount' => 'required|numeric',
            'purchase_cost' => 'required|numeric',
            'sale_invoice' => 'required|numeric',
            'note' => 'nullable|string'
        ], [
            'item_name.required' => 'حقل اسم العنصر مطلوب.',
            'item_name.string' => 'يجب أن يكون اسم العنصر نصًا.',
            'item_name.max' => 'يجب ألا يتجاوز اسم العنصر :max حرفًا.',
            'buyer_account_number.required' => 'حقل رقم حساب المشتري مطلوب.',
            'buyer_account_number.string' => 'يجب أن يكون رقم حساب المشتري نصًا.',
            'seller_account_number.required' => 'حقل رقم حساب البائع مطلوب.',
            'seller_account_number.string' => 'يجب أن يكون رقم حساب البائع نصًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'purchase_cost.required' => 'حقل تكلفة الشراء مطلوب.',
            'purchase_cost.numeric' => 'يجب أن تكون تكلفة الشراء رقمًا.',
            'sale_invoice.required' => 'حقل فاتورة البيع مطلوب.',
            'sale_invoice.numeric' => 'يجب أن تكون فاتورة البيع رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $new_buyer = User::where('account_number', $request->buyer_account_number)
            ->first();

        if (!$new_buyer) {
            $notify[] = ['error', "رقم حساب المشتري غير موجود"];
            return redirect()->back()->withNotify($notify);
        }

        $new_seller = User::where('account_number', $request->seller_account_number)
            ->first();

        if (!$new_seller) {
            $notify[] = ['error', "رقم حساب البائع غير موجود"];
            return redirect()->back()->withNotify($notify);
        }

        if ($new_seller == $new_buyer) {
            $notify[] = ['error', 'لا يمكن ان يكون البائع هو نفس المشتري'];
            return redirect()->back()->withNotify($notify);
        }

        $purchase = Purchase::with('transactional')->findOrFail($id);

        $new_seller->balance += $request->purchase_cost;
        $new_seller->save();
        $new_buyer->balance -= $request->sale_invoice;
        $new_buyer->save();

        $old_seller = $purchase->seller;
        $old_buyer = $purchase->buyer;
        $old_seller->balance -= $purchase->purchase_cost;
        $old_seller->save();
        $old_buyer->balance += $purchase->sales_cost;
        $old_buyer->save();

        $charge = $request->sale_invoice - $request->purchase_cost;

        $purchase->update([
            'item_name' => $request->item_name,
            'seller_id' => $new_seller->id,
            'buyer_id' => $new_buyer->id,
            'amount' => $request->amount,
            'purchase_cost' => $request->purchase_cost,
            'sales_cost' => $request->sale_invoice,
            'seller_floating_balance' => $new_seller->balance,
            'buyer_floating_balance' => $new_seller->balance,
            'charge' => $charge,
            'note' => $request->note ?? null,
        ]);

        if ($purchase->transactional) {
            $purchase->transactional->update([
                'charge' => $charge,
                'amount' => $request->amount,
            ]);
        }

        $notify[] = ['success', 'تم تعديل عملية الشراء بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}