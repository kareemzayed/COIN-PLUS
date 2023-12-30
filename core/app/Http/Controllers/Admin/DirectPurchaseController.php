<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fund;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\DirectPurchase;
use Illuminate\Validation\Rule;
use App\Models\SystemTransaction;
use App\Http\Controllers\Controller;
use App\Notifications\AdminDirectPurchaseNotification;
use App\Notifications\DirectPurchaseSellerNotification;

class DirectPurchaseController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة معاملات الشراء المباشر';
        $data['users'] = User::get();
        $data['funds'] = Fund::where('status', 1)->get();

        $search['utr'] = $request->utr;
        $search['item'] = $request->item;
        $search['date'] = $request->date;

        $data['purchases'] = DirectPurchase::when($search['utr'], function ($q) use ($search) {
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

        return view('backend.direct_purchases.index', compact('search'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'seller_type' => 'required|numeric|in:1,2',
            'seller_account_number' => Rule::when($request->input('seller_type') == 1, ['required', 'string']),
            'seller_name' => Rule::when($request->input('seller_type') == 2, ['required', 'string', 'max:255']),
            'amount' => 'required|numeric',
            'purchase_cost' => 'required|numeric',
            'fund_id' => 'required|numeric',
            'note' => 'nullable|string'
        ], [
            'item_name.required' => 'حقل العنصر مطلوب.',
            'item_name.string' => 'يجب أن يكون العنصر نصًا.',
            'item_name.max' => 'الحد الأقصى لعدد الأحرف هو :max.',
            'seller_type.required' => 'حقل نوع البائع مطلوب.',
            'seller_type.numeric' => 'يجب أن يكون نوع البائع رقمًا.',
            'seller_type.in' => 'نوع البائع يجب أن يكون 1 أو 2.',
            'seller_account_number.required' => 'يجب تقديم رقم حساب البائع.',
            'seller_account_number.string' => 'رقم حساب البائع يجب أن يكون نصًا.',
            'seller_name.required' => 'يجب تقديم اسم البائع.',
            'seller_name.string' => 'اسم البائع يجب أن يكون نصًا.',
            'seller_name.max' => 'الحد الأقصى لعدد الأحرف هو :max.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'purchase_cost.required' => 'حقل تكلفة الشراء مطلوب.',
            'purchase_cost.numeric' => 'يجب أن تكون تكلفة الشراء رقمًا.',
            'fund_id.required' => 'حقل معرّف الصندوق مطلوب.',
            'fund_id.numeric' => 'يجب أن يكون معرّف الصندوق رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $seller = null;
        if ($request->seller_type == 1 && !empty($request->seller_account_number)) {
            $seller = User::where('account_number', $request->seller_account_number)->first();
            if (!$seller) {
                $notify[] = ['error', "رقم حساب البائع غير موجود"];
                return redirect()->back()->withNotify($notify);
            }

            $seller->balance += $request->purchase_cost;
            $seller->save();
        }

        $fund = Fund::findOrFail($request->fund_id);
        $fund->balance += $request->amount;
        $fund->save();

        $charge = $request->amount - $request->purchase_cost;
        $purchase = DirectPurchase::create([
            'item_name' => $request->item_name,
            'seller_type' => $request->seller_type,
            'seller_id' => (!empty($seller)) ? $seller->id : null,
            'seller_on_way_name' => $request->seller_name ?? null,
            'fund_id' => $request->fund_id,
            'amount' => $request->amount,
            'purchase_cost' => $request->purchase_cost,
            'charge' => $charge,
            'fund_floating_balance' => $fund->balance,
            'seller_floating_balance' => (!empty($seller)) ? $seller->balance : 0,
            'note' => $request->note ?? null,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $purchase->amount;
        $transaction->charge = $purchase->charge;
        $purchase->transactional()->save($transaction);

        $admin = Admin::first();
        $admin->notify(new AdminDirectPurchaseNotification($purchase));
        if(!empty($seller)) {
            $seller->notify(new DirectPurchaseSellerNotification($purchase));
        }
        $notify[] = ['success', 'تم اتمام عملية الشراء المباشر بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'seller_type' => 'required|numeric|in:1,2',
            'seller_account_number' => Rule::when($request->input('seller_type') == 1, ['required', 'string']),
            'seller_name' => Rule::when($request->input('seller_type') == 2, ['required', 'string', 'max:255']),
            'amount' => 'required|numeric',
            'purchase_cost' => 'required|numeric',
            'fund_id' => 'required|numeric',
            'note' => 'nullable|string'
        ], [
            'item_name.required' => 'حقل العنصر مطلوب.',
            'item_name.string' => 'يجب أن يكون العنصر نصًا.',
            'item_name.max' => 'الحد الأقصى لعدد الأحرف هو :max.',
            'seller_type.required' => 'حقل نوع البائع مطلوب.',
            'seller_type.numeric' => 'يجب أن يكون نوع البائع رقمًا.',
            'seller_type.in' => 'نوع البائع يجب أن يكون 1 أو 2.',
            'seller_account_number.required' => 'يجب تقديم رقم حساب البائع.',
            'seller_account_number.string' => 'رقم حساب البائع يجب أن يكون نصًا.',
            'seller_name.required' => 'يجب تقديم اسم البائع.',
            'seller_name.string' => 'اسم البائع يجب أن يكون نصًا.',
            'seller_name.max' => 'الحد الأقصى لعدد الأحرف هو :max.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'purchase_cost.required' => 'حقل تكلفة الشراء مطلوب.',
            'purchase_cost.numeric' => 'يجب أن تكون تكلفة الشراء رقمًا.',
            'fund_id.required' => 'حقل معرّف الصندوق مطلوب.',
            'fund_id.numeric' => 'يجب أن يكون معرّف الصندوق رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $new_seller = null;
        if ($request->seller_type == 1 && !empty($request->seller_account_number)) {
            $new_seller = User::where('account_number', $request->seller_account_number)
                ->first();
            if (!$new_seller) {
                $notify[] = ['error', "رقم حساب البائع غير موجود"];
                return redirect()->back()->withNotify($notify);
            }
        }

        $new_fund = Fund::findOrFail($request->fund_id);

        $purchase = DirectPurchase::with('transactional')->findOrFail($id);

        if (!empty($new_seller)) {
            $new_seller->balance += $request->purchase_cost;
            $new_seller->save();
        }

        $new_fund->balance += $request->amount;
        $new_fund->save();

        $old_seller = $purchase->seller;
        $old_fund = $purchase->fund;
        if (!empty($old_seller)) {
            $old_seller->balance -= $purchase->purchase_cost;
            $old_seller->save();
        }
        $old_fund->balance -= $purchase->amount;
        $old_fund->save();

        $charge = $request->amount - $request->purchase_cost;
        $purchase->update([
            'item_name' => $request->item_name,
            'seller_type' => $request->seller_type,
            'seller_id' => (!empty($new_seller)) ? $new_seller->id : null,
            'seller_on_way_name' => $request->seller_name ?? null,
            'fund_id' => $request->fund_id,
            'amount' => $request->amount,
            'purchase_cost' => $request->purchase_cost,
            'charge' => $charge,
            'fund_floating_balance' => $new_fund->balance,
            'seller_floating_balance' => (!empty($new_seller)) ? $new_seller->balance : 0,
            'note' => $request->note ?? null,
        ]);

        if ($purchase->transactional) {
            $purchase->transactional->update([
                'charge' => $charge,
                'amount' => $request->amount,
            ]);
        }

        $notify[] = ['success', 'تم تعديل عملية الشراء المباشر بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $purchase = DirectPurchase::with('transactional')->findOrFail($id);
        $seller = $purchase->seller;
        $fund = $purchase->fund;

        if (!empty($seller)) {
            $seller->balance -= $purchase->purchase_cost;
            $seller->save();
        }
        $fund->balance -= $purchase->amount;
        $fund->save();

        if ($purchase->transactional) {
            $purchase->transactional->delete();
        }
        $purchase->delete();

        $notify[] = ['success', 'تم حذف عملية الشراء المباشر بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}