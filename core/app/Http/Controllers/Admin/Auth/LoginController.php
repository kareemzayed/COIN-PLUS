<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminPasswordReset;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    }

    public function loginPage()
    {
        $pageTitle = 'صفحة تسجيل دخول الأدمن';

        AdminPasswordReset::truncate();

        return view('backend.auth.login', compact('pageTitle'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحاً.',
            'password.required' => 'حقل كلمة المرور مطلوب.'
        ]);
        $remember = $request->remember == 'on' ? true : false;

        if (auth()->guard('admin')->attempt($data, $remember)) {
            return redirect()->route('admin.home')->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return redirect()->route('admin.login')->with('error', 'بيانات اعتماد غير صحيحة');
    }

    public function logout()
    {
        auth()->guard('admin')->logout();

        return redirect()->route('admin.login')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
