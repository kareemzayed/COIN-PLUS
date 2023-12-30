<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Check;
use Illuminate\Http\Request;

class ChecksManagementController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'قائمة الشيكات';
        $search['check_num'] = $request->check_num;
        $search['status'] = $request->status;
        $search['issuance_date'] = $request->issuance_date;
        $search['beneficiary_name'] = $request->beneficiary_name;

        $checks = Check::when($search['check_num'], function ($q) use ($search) {
            $q->where('check_num', 'LIKE', '%' . $search['check_num'] . '%');
        })
            ->when($search['beneficiary_name'], function ($q) use ($search) {
                $q->where('beneficiary_name', 'LIKE', '%' . $search['beneficiary_name'] . '%');
            })
            ->when($search['status'], function ($q) use ($search) {
                $q->where('status', $search['status']);
            })
            ->when($search['issuance_date'], function ($q) use ($search) {
                $q->whereDate('issuance_date', $search['issuance_date']);
            })->latest()->paginate(10);

        return view('backend.checks.index', compact('search', 'checks'))->with($data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'check_num' => 'required|string|max:255|unique:checks,check_num',
            'issuance_date' => 'required|date',
            'due_date' => 'required|date',
            'beneficiary_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'status' => 'required|numeric',
            'note' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,gif,jpeg,pdf',
        ], [
            'check_num.required' => 'حقل رقم الشيك مطلوب.',
            'check_num.string' => 'يجب أن يكون رقم الشيك نصًا.',
            'check_num.max' => 'يجب أن لا يتجاوز رقم الشيك :max حرفًا.',
            'check_num.unique' => 'رقم الشيك موجود بالفعل في السجلات.',
            'issuance_date.required' => 'حقل تاريخ الإصدار مطلوب.',
            'issuance_date.date' => 'يجب أن يكون تاريخ الإصدار صحيحًا.',
            'due_date.required' => 'حقل تاريخ الاستحقاق مطلوب.',
            'due_date.date' => 'يجب أن يكون تاريخ الاستحقاق صحيحًا.',
            'beneficiary_name.required' => 'حقل اسم المستفيد مطلوب.',
            'beneficiary_name.string' => 'يجب أن يكون اسم المستفيد نصًا.',
            'beneficiary_name.max' => 'يجب أن لا يتجاوز اسم المستفيد :max حرفًا.',
            'bank_name.required' => 'حقل اسم البنك مطلوب.',
            'bank_name.string' => 'يجب أن يكون اسم البنك نصًا.',
            'bank_name.max' => 'يجب أن لا يتجاوز اسم البنك :max حرفًا.',
            'currency.required' => 'حقل العملة مطلوب.',
            'currency.string' => 'يجب أن تكون العملة نصًا.',
            'currency.max' => 'يجب أن لا تتجاوز العملة :max حرفًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.numeric' => 'يجب أن تكون الحالة رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
            'image.image' => 'يجب أن يكون الملف المحدد صورة.',
            'image.mimes' => 'يجب أن يكون نوع الملف صورة أو PDF.'
        ]);

        $filename = null;
        if ($request->has('image')) {
            $path = filePath('checks', true);
            $filename = uploadImage($request->image, $path);
        }

        Check::create([
            'check_num' => $request->check_num,
            'issuance_date' => $request->issuance_date,
            'due_date' => $request->due_date,
            'beneficiary_name' => $request->beneficiary_name,
            'bank_name' => $request->bank_name,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'status' => $request->status,
            'note' => $request->note ?? null,
            'image' => $filename,
        ]);

        $notify[] = ['success', 'تم إنشاء الشيك بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'check_num' => 'required|string|max:255|unique:checks,check_num,' . $id,
            'issuance_date' => 'required|date',
            'due_date' => 'required|date',
            'beneficiary_name' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'status' => 'required|numeric',
            'note' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,gif,jpeg,pdf',
        ], [
            'check_num.required' => 'حقل رقم الشيك مطلوب.',
            'check_num.string' => 'يجب أن يكون رقم الشيك نصًا.',
            'check_num.max' => 'يجب أن لا يتجاوز رقم الشيك :max حرفًا.',
            'check_num.unique' => 'رقم الشيك موجود بالفعل في السجلات. رقم الهوية: :id',
            'issuance_date.required' => 'حقل تاريخ الإصدار مطلوب.',
            'issuance_date.date' => 'يجب أن يكون تاريخ الإصدار صحيحًا.',
            'due_date.required' => 'حقل تاريخ الاستحقاق مطلوب.',
            'due_date.date' => 'يجب أن يكون تاريخ الاستحقاق صحيحًا.',
            'beneficiary_name.required' => 'حقل اسم المستفيد مطلوب.',
            'beneficiary_name.string' => 'يجب أن يكون اسم المستفيد نصًا.',
            'beneficiary_name.max' => 'يجب أن لا يتجاوز اسم المستفيد :max حرفًا.',
            'bank_name.required' => 'حقل اسم البنك مطلوب.',
            'bank_name.string' => 'يجب أن يكون اسم البنك نصًا.',
            'bank_name.max' => 'يجب أن لا يتجاوز اسم البنك :max حرفًا.',
            'currency.required' => 'حقل العملة مطلوب.',
            'currency.string' => 'يجب أن تكون العملة نصًا.',
            'currency.max' => 'يجب أن لا تتجاوز العملة :max حرفًا.',
            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'status.required' => 'حقل الحالة مطلوب.',
            'status.numeric' => 'يجب أن تكون الحالة رقمًا.',
            'note.string' => 'يجب أن تكون الملاحظة نصًا.',
            'image.image' => 'يجب أن يكون الملف المحدد صورة.',
            'image.mimes' => 'يجب أن يكون نوع الملف صورة أو PDF.'
        ]);

        $check = Check::findOrFail($id);
        $old_check_img = $check->image;

        $filename = null;
        if ($request->has('image')) {
            $path = filePath('checks', true);
            $filename = uploadImage($request->image, $path, null, $old_check_img);
        }

        $check->update([
            'check_num' => $request->check_num,
            'issuance_date' => $request->issuance_date,
            'due_date' => $request->due_date,
            'beneficiary_name' => $request->beneficiary_name,
            'bank_name' => $request->bank_name,
            'currency' => $request->currency,
            'amount' => $request->amount,
            'status' => $request->status,
            'note' => $request->note ?? null,
            'image' => $filename ?? $old_check_img,
        ]);

        $notify[] = ['success', 'تم تعديل الشيك بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete($id)
    {
        $check = Check::findOrFail($id);
        if ($check->image) {
            $path = filePath('checks', true);
            removeFile($path . '/' . $check->image);
        }
        $check->delete();
        $notify[] = ['success', 'تم حذف الشيك بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}
