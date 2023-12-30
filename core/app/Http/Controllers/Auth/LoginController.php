<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    public function index()
    {
        $pageTitle = 'صفحة تسجيل الدخول';
        return view(template() . 'user.auth.login', compact('pageTitle'));
    }

    public function login(Request $request)
    {
        $general  = GeneralSetting::first();
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
                'g-recaptcha-response' => Rule::requiredIf($general->allow_recaptcha == 1)
            ],
            [
                'email.required' => 'حقل البريد الإلكتروني مطلوب.',
                'password.required' => 'حقل كلمة المرور مطلوب.',
                'g-recaptcha-response.required' => 'يجب عليك ملء خانة التحقق (reCAPTCHA).',
            ]
        );
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $notify[] = ['error', 'لم يتم العثور على مستخدم مرتبط بهذا البريد الإلكتروني.'];
            return redirect()->route('user.login')->withNotify($notify);
        }
        if (Auth::attempt($request->except('g-recaptcha-response', '_token'))) {
            $notify[] = ['success', 'تم تسجيل الدخول بنجاح'];
            if (session('intended')) {
                return redirect()->to(session()->get('intended'))
                    ->withNotify($notify);
            }
            return redirect()->route('user.transaction.log')
                ->withNotify($notify);
        }

        $notify[] = ['error', 'بيانات اعتماد غير صحيحة'];
        return redirect()->route('user.login')->withNotify($notify);
    }


    public function emailVerify()
    {
        $pageTitle = "التحقق من البريد الإلكتروني";
        return view(template() . 'user.auth.email', compact('pageTitle'));
    }

    public function emailVerifyConfirm(Request $request)
    {
        $request->validate([
            'code' => 'required',
        ], [
            'code.required' => 'حقل الكود مطلوب.',
        ]);
        
        $user = User::findOrFail(session('user'));
        if ($request->code == $user->verification_code) {
            $user->verification_code = null;
            $user->email_verified_at = now();
            $user->status = 1;
            $user->last_login = now();
            $user->save();
            Auth::login($user);

            $notify[] = ['success', 'تم التحقق من حسابك بنجاح'];
            return redirect()->route('user.transaction.log')->withNotify($notify);
        }

        $notify[] = ['error', 'الرمز غير صحيح'];
        return back()->withNotify($notify);
    }
}
