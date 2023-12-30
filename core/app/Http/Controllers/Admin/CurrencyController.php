<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $data['pageTitle'] = 'إدارة العملات';

        $search['name'] = $request->name;
        $search['code'] = $request->code;

        $data['currencies'] = Currency::when($search['name'], function ($q) use ($search) {
            $q->where('name', 'LIKE', '%' . $search['name'] . '%');
        })
            ->when($search['code'], function ($q) use ($search) {
                $q->where('code', 'LIKE', '%' . $search['code'] . '%');
            })
            ->latest()->paginate();

        return view('backend.currency.index', compact('search'))->with($data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:currencies,name',
            'code' => 'required|string|max:255|unique:currencies,code',
            'rate' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'الاسم لا يجب أن يتجاوز 255 حرفًا.',
            'name.unique' => 'الاسم مُستخدم بالفعل.',
            'code.required' => 'حقل الكود مطلوب.',
            'code.string' => 'يجب أن يكون الكود نصًا.',
            'code.max' => 'الكود لا يجب أن يتجاوز 255 حرفًا.',
            'code.unique' => 'الكود مُستخدم بالفعل.',
            'rate.required' => 'حقل السعر مطلوب.',
            'rate.numeric' => 'يجب أن يكون السعر رقمًا.',
            'image.image' => 'يجب أن يكون الملف الصوري صورة.',
            'image.mimes' => 'يجب أن يكون الملف الصوري من النوع: jpg, png, jpeg.',
        ]);


        if ($request->hasFile('image')) {
            $filename = uploadImage($request->image, filePath('currency', true));
        }

        Currency::create([
            'name' => $request->name,
            'code' => $request->code,
            'rate' => $request->rate,
            'image' => $filename ?? '',
            'status' => isset($request->status) && $request->status == 'on' ? 1 : 0
        ]);

        $notify[] = ['success', 'تم اضافة العملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:currencies,name,' . $currency->id,
            'code' => 'required|string|max:255|unique:currencies,code,' . $currency->id,
            'rate' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'الاسم لا يجب أن يتجاوز 255 حرفًا.',
            'name.unique' => 'الاسم مُستخدم بالفعل.',
            'code.required' => 'حقل الكود مطلوب.',
            'code.string' => 'يجب أن يكون الكود نصًا.',
            'code.max' => 'الكود لا يجب أن يتجاوز 255 حرفًا.',
            'code.unique' => 'الكود مُستخدم بالفعل.',
            'rate.required' => 'حقل السعر مطلوب.',
            'rate.numeric' => 'يجب أن يكون السعر رقمًا.',
            'image.image' => 'يجب أن يكون الملف الصوري صورة.',
            'image.mimes' => 'يجب أن يكون الملف الصوري من النوع: jpg, png, jpeg.',
        ]);

        $currency->update([
            'name' => $request->name,
            'code' => $request->code,
            'rate' => $request->rate,
            'image' => $request->hasFile('image') ? uploadImage($request->image, filePath('currency', true), '', $currency->image) : $currency->image,
            'status' => isset($request->status) && $request->status == 'on' ? 1 : 0
        ]);

        $notify[] = ['success', 'تم تعديل العملة بنجاح'];
        return redirect()->back()->withNotify($notify);
    }
}
