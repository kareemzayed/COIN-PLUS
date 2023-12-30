<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        $pageTitle = 'نسيت كلمة المرور';
        return view(template() . 'user.auth.forgot_password', compact('pageTitle'));
    }

    public function sendVerification(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate([
            'email' => 'required|email',
            'g-recaptcha-response' => Rule::requiredIf($general->allow_recaptcha == 1),
        ], [
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صالحًا.',
            'g-recaptcha-response.required' => 'يجب عليك ملء خانة التحقق (reCAPTCHA).',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $notify[] = ['error', 'يرجى توفير عنوان بريد إلكتروني صالح'];
            return back()->withNotify($notify);
        }

        $code = random_int(100000, 999999);
        $user->verification_code = $code;
        $user->save();

        sendMail('PASSWORD_RESET', ['code' => $code],  $user);
        session()->put('email', $user->email);

        $notify[] = ['success', ' تم إرسال رمز التحقق إلى بريدك الإلكتروني'];
        return redirect()->route('user.auth.verify')->withNotify($notify);
    }

    public function verify()
    {
        $email = session('email');
        $pageTitle = 'التحقق من الرمز';
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('user.forgot.password');
        }
        return view(template() . 'user.auth.verify', compact('pageTitle', 'email'));
    }

    public function verifyCode(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate([
            'code' => 'required',
            'email' => 'required|email|exists:users,email',
            'g-recaptcha-response' => Rule::requiredIf($general->allow_recaptcha == 1)
        ], [
            'code.required' => 'حقل الرمز مطلوب.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى تقديم عنوان بريد إلكتروني صحيح.',
            'email.exists' => 'البريد الإلكتروني المقدم غير مسجل في النظام.',
            'g-recaptcha-response.required' => 'يجب عليك ملء خانة التحقق (reCAPTCHA).',
        ]);

        $user = User::where('email', $request->email)->first();
        $token = $user->verification_code;

        if ($user->verification_code != $request->code) {
            $user->verification_code = null;
            $user->save();
            $notify[] = ['error', 'الرمز غير صحيح'];
            return back()->withNotify($notify);
        }

        $user->verification_code = null;
        $user->save();

        session()->put('identification', [
            "token" => $token,
            "email" => $user->email
        ]);
        return redirect()->route('user.reset.password');
    }

    public function reset()
    {
        $session = session('identification');
        if (!$session) {
            return redirect()->route('user.login');
        }
        $pageTitle = 'إعادة تعيين كلمة المرور';
        return view(template() . 'user.auth.reset', compact('pageTitle', 'session'));
    }

    public function resetPassword(Request $request)
    {
        $general = GeneralSetting::first();
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|confirmed',
                'g-recaptcha-response' => Rule::requiredIf($general->allow_recaptcha == 1)
            ],
            [
                'email.required' => 'حقل البريد الإلكتروني مطلوب.',
                'email.email' => 'يرجى تقديم عنوان بريد إلكتروني صحيح.',
                'email.exists' => 'البريد الإلكتروني المقدم غير مسجل في النظام.',
                'password.required' => 'حقل كلمة المرور مطلوب.',
                'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
                'g-recaptcha-response.required' => 'يجب عليك ملء خانة التحقق (reCAPTCHA).',
            ]
        );

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        $notify[] = ['success', 'تم إعادة تعيين كلمة المرور بنجاح'];
        return redirect()->route('user.login')->withNotify($notify);
    }


    public function verifyAuth()
    {
        if (auth()->user()->ev && auth()->user()->sv) {
            return redirect()->route('user.transaction.log');
        }

        $pageTitle = 'التحقق من الحساب';
        return view(template() . 'user.auth.email_sms_verify', compact('pageTitle'));
    }

    public function verifyEmailAuth(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'code' => 'required',
        ], [
            'code.required' => 'يرجى إدخال رمز التحقق.',
        ]);        

        if ($user->verification_code != $request->code) {
            return redirect()->back()->with('error', 'رمز التحقق غير صحيح');
        }

        $user->verification_code = null;
        $user->ev = 1;
        $user->save();

        return redirect()->route('user.transaction.log');
    }

    public function verifySmsAuth(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'code' => 'required',
        ], [
            'code.required' => 'يرجى إدخال رمز التحقق.',
        ]);       

        if ($user->sms_verification_code != $request->code) {
            return redirect()->back()->with('error', 'رمز التحقق غير صحيح');
        }
        $user->sms_verification_code = null;
        $user->sv = 1;
        $user->save();

        return redirect()->route('user.transaction.log');
    }
}
