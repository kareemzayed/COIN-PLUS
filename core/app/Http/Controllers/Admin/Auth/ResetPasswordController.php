<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use App\Models\AdminPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;


class ResetPasswordController extends Controller
{

    public $redirectTo = '/admin/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    public function showResetForm(Request $request, $token)
    {
        $pageTitle = "استرداد الحساب";
        $resetToken = AdminPasswordReset::where('token', $token)->where('status', 0)->first();
        if (!$resetToken) {
            return redirect()->route('admin.password.reset')->with(['error', 'الرمز غير موجود!']);
        }
        $email = $resetToken->email;
        return view('backend.auth.reset', compact('pageTitle', 'email', 'token'));
    }


    public function reset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|confirmed|min:4',
        ], [
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحاً.',
            'token.required' => 'حقل الرمز مطلوب.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على الأقل على :min أحرف.',
        ]);

        $reset = AdminPasswordReset::where('token', $request->token)->orderBy('created_at', 'desc')->first();
        $user = Admin::where('email', $reset->email)->first();
        if ($reset->status == 1) {
            return redirect()->route('admin.login')->with(['error', 'رمز غير صحيح']);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        $reset->status = 1;
        $reset->save();

        $notify[] = ['success', 'تم تغيير كلمة المرور بنجاح'];
        return redirect()->route('admin.login')->withNotify($notify);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
