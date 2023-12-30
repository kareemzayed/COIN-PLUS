<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fund;
use App\Models\Sale;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\SystemTransaction;
use App\Http\Controllers\Controller;
use App\Notifications\SaleAdminNotification;
use App\Notifications\SaleBuyerNotification;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة معاملات البيع';
        $data['funds'] = Fund::where('status', 1)->get(); // active funds
        $data['users'] = User::get();

        $search['utr'] = $request->utr;
        $search['item_name'] = $request->item_name;
        $search['date'] = $request->date;
        $search['fund_id'] = $request->fund_id;

        $data['sales'] = Sale::when($search['utr'], function ($q) use ($search) {
            $q->where('utr', 'LIKE', '%' . $search['utr'] . '%');
        })
            ->when($search['item_name'], function ($q) use ($search) {
                $q->where('item_name', 'LIKE', '%' . $search['item_name'] . '%');
            })
            ->when($search['fund_id'], function ($q) use ($search) {
                $q->where('fund_id', $search['fund_id']);
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
        return view('backend.sales.index', compact('search'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'buyer_account_number' => 'required|string',
            'fund_id' => 'required|numeric|not_in:0',
            'amount' => 'required|numeric',
            'sale_cost' => 'required|numeric',
            'note' => 'nullable|string'
        ], [
            'item_name.required' => 'حقل اسم العنصر مطلوب.',
            'item_name.string' => 'يجب أن يكون اسم العنصر نصًا.',
            'item_name.max' => 'يجب ألا يتجاوز اسم العنصر :max حرفًا.',
            'buyer_account_number.required' => 'حقل رقم حساب المشتري مطلوب.',
            'buyer_account_number.string' => 'يجب أن يكون رقم حساب المشتري نصًا.',
            'fund_id.required' => 'حقل رقم الصندوق مطلوب.',
            'fund_id.numeric' => 'يجب أن يكون رقم الصندوق رقمًا.',
            'fund_id.not_in' => 'يجب تحديد قيمة غير صفر لرقم الصندوق.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'sale_cost.required' => 'حقل تكلفة البيع مطلوب.',
            'sale_cost.numeric' => 'يجب أن تكون تكلفة البيع رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $buyer = User::where('account_number', $request->buyer_account_number)
            ->first();

        if (!$buyer) {
            $notify[] = ['error', "رقم حساب المشتري غير موجود"];
            return redirect()->back()->withNotify($notify);
        }

        $fund = Fund::findOrFail($request->fund_id);

        $fund->balance -= $request->amount;
        $fund->save();
        $buyer->balance -= $request->sale_cost;
        $buyer->save();

        $charge = $request->sale_cost - $request->amount;

        $sale = Sale::create([
            'item_name' => $request->item_name,
            'fund_id' => $fund->id,
            'buyer_id' => $buyer->id,
            'amount' => $request->amount,
            'sales_cost' => $request->sale_cost,
            'fund_floating_balance' => $fund->balance,
            'buyer_floating_balance' => $buyer->balance,
            'charge' => $charge,
            'note' => $request->note ?? null,
            'utr' => mt_rand(1000000000, 9999999999),
        ]);

        $transaction = new SystemTransaction();
        $transaction->amount = $sale->amount;
        $transaction->charge = $sale->charge;
        $sale->transactional()->save($transaction);

        $admin = Admin::first();
        $buyer->notify(new SaleBuyerNotification($sale));
        $admin->notify(new SaleAdminNotification($sale));

        $notify[] = ['success', 'تم اتمام عملية البيع بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $sale = Sale::with('transactional')->findOrFail($id);

        $fund = $sale->fund;
        $buyer = $sale->buyer;

        $fund->balance += $sale->amount;
        $fund->save();
        $buyer->balance += $sale->sales_cost;
        $buyer->save();

        if ($sale->transactional) {
            $sale->transactional->delete();
        }
        $sale->delete();

        $notify[] = ['success', 'تم حذف عملية البيع بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required|string|max:255',
            'buyer_account_number' => 'required|string',
            'fund_id' => 'required|numeric|not_in:0',
            'amount' => 'required|numeric',
            'sale_cost' => 'required|numeric',
            'note' => 'nullable|string',
        ], [
            'item_name.required' => 'حقل اسم العنصر مطلوب.',
            'item_name.string' => 'يجب أن يكون اسم العنصر نصًا.',
            'item_name.max' => 'يجب ألا يتجاوز اسم العنصر :max حرفًا.',
            'buyer_account_number.required' => 'حقل رقم حساب المشتري مطلوب.',
            'buyer_account_number.string' => 'يجب أن يكون رقم حساب المشتري نصًا.',
            'fund_id.required' => 'حقل رقم الصندوق مطلوب.',
            'fund_id.numeric' => 'يجب أن يكون رقم الصندوق رقمًا.',
            'fund_id.not_in' => 'يجب تحديد قيمة غير صفر لرقم الصندوق.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'sale_cost.required' => 'حقل تكلفة البيع مطلوب.',
            'sale_cost.numeric' => 'يجب أن تكون تكلفة البيع رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $new_buyer = User::where('account_number', $request->buyer_account_number)
            ->first();

        if (!$new_buyer) {
            $notify[] = ['error', "رقم حساب المشتري غير موجود"];
            return redirect()->back()->withNotify($notify);
        }

        $new_fund = Fund::findOrFail($request->fund_id);
        $sale = Sale::with('transactional')->findOrFail($id);

        $new_fund->balance -= $request->amount;
        $new_fund->save();
        $new_buyer->balance -= $request->sale_cost;
        $new_buyer->save();

        $old_fund = $sale->fund;
        $old_buyer = $sale->buyer;

        $old_fund->balance += $sale->amount;
        $old_fund->save();
        $old_buyer->balance += $sale->sales_cost;
        $old_buyer->save();

        $charge = $request->sale_cost - $request->amount;

        $sale->update([
            'item_name' => $request->item_name,
            'fund_id' => $new_fund->id,
            'buyer_id' => $new_buyer->id,
            'amount' => $request->amount,
            'sales_cost' => $request->sale_cost,
            'fund_floating_balance' => $new_fund->balance,
            'buyer_floating_balance' => $new_buyer->balance,
            'charge' => $charge,
            'note' => $request->note ?? null,
        ]);

        if ($sale->transactional) {
            $sale->transactional->update([
                'charge' => $charge,
                'amount' => $request->amount,
            ]);
        }

        $notify[] = ['success', 'تم تعديل عملية البيع بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}
