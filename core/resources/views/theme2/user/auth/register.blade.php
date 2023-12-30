@extends(template() . 'layout.auth')
@section('content')
    @php
        $registration = content('registration.content');
    @endphp
    <div class="account-page registration-page">
        <div class="content-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{ getFile('logo', $general->logo, true) }}" alt="شعار"></a>
            </div>
            <div class="content">
                <h2 class="title">إنشاء حساب في {{ $general->sitename }}</h2>
            </div>
        </div>
        <div class="form-wrapper">
            <div class="inner-wrapper">
                <h2 class="title text-center">أنشئ حسابك في {{ $general->sitename }}</h2>
                <form class="account-form" method="POST" action="">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="formGroupExampleInput">الاسم الأول</label>
                            <div class="custom-icon-field mb-3">
                                <input type="text" class="form-control" name="fname" value="{{ old('fname') }}"
                                    id="first_name" placeholder="الاسم الأول">
                                <i class="las la-user-circle"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="formGroupExampleInput">الاسم الأخير</label>
                            <div class="custom-icon-field mb-3">
                                <input type="text" class="form-control" name="lname" value="{{ old('lname') }}"
                                    id="last_name" placeholder="الاسم الأخير">
                                <i class="las la-user-circle"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="username">اسم المستخدم</label>
                            <div class="custom-icon-field mb-3">
                                <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                                    id="username" placeholder="اسم المستخدم">
                                <i class="las la-user-circle"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="formGroupExampleInput">رقم هاتفك</label>
                            <div class="custom-icon-field mb-3">

                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}"
                                    id="email" placeholder="رقم هاتفك">
                                <i class="las la-phone"></i>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="formGroupExampleInput">البريد الإلكتروني</label>
                            <div class="custom-icon-field mb-3">
                                <input type="Email" class="form-control" name="email" value="{{ old('email') }}"
                                    id="email" placeholder="البريد الإلكتروني">
                                <i class="las la-envelope"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="formGroupExampleInput">أدخل كلمة المرور</label>
                            <div class="custom-icon-field mb-3">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="أدخل كلمة المرور">
                                <i class="las la-lock"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="formGroupExampleInput">أعد كتابة كلمة المرور</label>
                            <div class="custom-icon-field mb-3">
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation" placeholder="أعد كتابة كلمة المرور">
                                <i class="las la-lock"></i>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            @if ($general->allow_recaptcha == 1)
                                <script src="https://www.google.com/recaptcha/api.js"></script>
                                <div class="g-recaptcha" data-sitekey="{{ $general->recaptcha_key }}"
                                    data-callback="verifyCaptcha"></div>
                                <div id="g-recaptcha-error"></div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex flex-wrap align-items-center mt-4">
                        <button type="submit" class="btn main-btn">أنشئ حسابك</button>
                        <span class="px-3">أو</span>
                        <a href="{{ route('user.login') }}" class="site-color">تسجيل الدخول</a>
                    </div>
                </form>
            </div>
            <div class="copy-right-text">
                <p>
                    @if ($general->copyright)
                        {{ $general->copyright }}
                    @endif
                </p>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    "<span class='text-danger'>حقل التحقق (Captcha) مطلوب</span>";
                return false;
            }
            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
    <script>
        $(function() {
            'use strict';

            $('form').on('submit', function() {
                const clickedButton = $(document.activeElement);
                if (clickedButton.is(':submit')) {
                    clickedButton.prop('disabled', true).html(
                        'جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
@endpush