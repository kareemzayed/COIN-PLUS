<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{

    public function profile()
    {
        $pageTitle = 'الملف الشخصي';

        return view('backend.profile', compact('pageTitle'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'username' => 'required',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png'
        ], [
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'username.required' => 'حقل اسم المستخدم مطلوب.',
            'image.sometimes' => 'حقل الصورة مطلوب.',
            'image.image' => 'يجب أن يكون الملف المحدد صورة.',
            'image.mimes' => 'يجب أن يكون نوع الملف صورة من الأنواع التالية: jpg, jpeg, png.'
        ]);

        $admin = auth()->guard('admin')->user();

        if ($request->has('image')) {
            $path = filePath('admin', true);
            $size = '200x200';
            $filename = uploadImage($request->image, $path, $size, $admin->image);
            $admin->image = $filename;
        }

        $admin->email = $request->email;
        $admin->username = $request->username;
        $admin->save();

        $notify[] = ['success', 'تم تحديث الملف الشخصي بنجاح'];

        return redirect()->back()->withNotify($notify);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed'
        ], [
            'old_password.required' => 'حقل كلمة المرور القديمة مطلوب.',
            'password.required' => 'حقل كلمة المرور الجديدة مطلوب.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل على :min أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور الجديدة غير متطابق.'
        ]);

        $admin = auth()->guard('admin')->user();

        if (!Hash::check($request->old_password, $admin->password)) {
            $notify[] = ['error', 'كلمة المرور غير متطابقة'];

            return back()->withNotify($notify);
        }

        $admin->password = bcrypt($request->password);
        $admin->save();


        $notify[] = ['success', 'تم تغيير كلمة المرور بنجاح'];

        return back()->withNotify($notify);
    }
}
