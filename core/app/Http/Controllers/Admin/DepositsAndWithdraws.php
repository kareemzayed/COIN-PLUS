<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UpdateUsersBalance;
use Illuminate\Http\Request;

class DepositsAndWithdraws extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة الإيداعات والسحوبات الإدارية';

        $search['utr'] = $request->utr;
        $search['type'] = $request->type;
        $search['date'] = $request->date;

        $data['update_users_balance'] = UpdateUsersBalance::when($search['utr'], function ($q) use ($search) {
            $q->where('utr', 'LIKE', '%' . $search['utr'] . '%');
        })
            ->when($search['type'], function ($q) use ($search) {
                $q->where('type', $search['type']);
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
        return view('backend.update_users_balance.index', compact('search'))->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'note' => 'nullable|string'
        ], [
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
        ]);

        $trans = UpdateUsersBalance::with('user', 'transactional')->findOrFail($id);
        $user = $trans->user;
        if ($trans->type == 'minus') {
            $user->balance += $trans->amount;
            $user->save();
            $user->balance -= $request->amount;
            $user->save();
        } elseif ($trans->type == 'add') {
            $user->balance -= $trans->amount;
            $user->save();
            $user->balance += $request->amount;
            $user->save();
        }

        $trans->update([
            'amount' => $request->amount,
            'note' => $request->note,
            'floating_balance' => $user->balance,
        ]);

        if ($trans->transactional) {
            $trans->transactional->update([
                'charge' => 0,
                'amount' => $trans->amount,
            ]);
        }

        $notify[] = ['success', 'تم تعديل المعاملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $trans = UpdateUsersBalance::with('user', 'transactional')->findOrFail($id);
        $user = $trans->user;

        if ($trans->type == 'minus') {
            $user->balance += $trans->amount;
            $user->save();
        } elseif ($trans->type == 'add') {
            $user->balance -= $trans->amount;
            $user->save();
        }

        if ($trans->transactional) {
            $trans->transactional->delete();
        }

        $trans->delete();
        $notify[] = ['success', 'تم حذف المعاملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}