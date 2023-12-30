<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Validation\Rule;
use App\Models\SystemTransaction;
use App\Models\UpdateUsersBalance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function index()
    {
        $pageTitle = 'التسجيل';
        return view(template() . 'user.auth.register', compact('pageTitle'));
    }

    public function register(Request $request)
    {
        $general = GeneralSetting::first();
        $signupBonus = $general->signup_bonus;
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required|unique:users',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'g-recaptcha-response' => Rule::requiredIf($general->allow_recaptcha == 1)
        ], [
            'fname.required' => 'حقل الاسم الأول مطلوب.',
            'lname.required' => 'حقل اسم الأخير مطلوب.',
            'username.required' => 'حقل اسم المستخدم مطلوب.',
            'username.unique' => 'اسم المستخدم مستخدم من قبل.',
            'phone.required' => 'حقل الهاتف مطلوب.',
            'phone.unique' => 'رقم الهاتف مستخدم من قبل.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صالحًا.',
            'email.unique' => 'البريد الإلكتروني مستخدم من قبل.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'g-recaptcha-response.required' => 'يجب عليك ملء خانة التحقق (reCAPTCHA).',
        ]);

        event(new Registered($user = $this->create($request, $signupBonus)));
        Auth::login($user);
        $notify[] = ['success', 'تم التسجيل بنجاح'];
        return redirect()->route('user.transaction.log')->withNotify($notify);
    }

    public function dashboard()
    {
        if (auth()->check()) {
            return redirect()->route('user.transaction.log');
        }
        return redirect()->route('user.login')->withSuccess('غير مسموح لك بالوصول');
    }

    public function create($request, $signupBonus)
    {
        $user = User::create([
            'fname' => $request->fname,
            'balance' => $signupBonus,
            'lname' => $request->lname,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => 1,
            'password' => bcrypt($request->password)
        ]);

        $user->account_number = generateAccountNumber($user->id);
        $user->save();

        if ($signupBonus > 0) {
            $updated_balance = UpdateUsersBalance::create([
                'user_id' => $user->id,
                'type' => 'add',
                'amount' => $signupBonus,
                'floating_balance' => $user->balance,
                'note' => 'Opening Balance',
                'utr' => mt_rand(1000000000, 9999999999),
            ]);

            $transaction = new SystemTransaction();
            $transaction->amount = $updated_balance->amount;
            $transaction->charge = 0;
            $updated_balance->transactional()->save($transaction);
        }

        return $user;
    }

    public function signOut()
    {
        Auth::logout();
        session()->forget('google2fa');
        return Redirect()->route('user.login');
    }
}
