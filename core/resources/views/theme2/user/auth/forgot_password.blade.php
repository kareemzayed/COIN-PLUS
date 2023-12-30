@extends(template().'layout.auth')

@section('content')
    @php
    $login = content('login.content');
    @endphp
    <div class="account-page">
        <div class="content-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{ getFile('logo', $general->logo, true) }}" alt="image"></a>
            </div>
            <div class="content">
            </div>
        </div>
        <div class="form-wrapper">
            <div class="inner-wrapper">
                <h2 class="title text-center">إعادة تعيين كلمة المرور</h2>

                <form action="{{ route('user.forgot.password') }}" method="POST" class="account-form">
                    @csrf
                    <div class="mb-3">
                        <label>البريد الإلكتروني<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="أدخل البريد الإلكتروني">
                    </div>

                    @if ($general->allow_recaptcha == 1)
                        <div class="mb-3">
                            <script src="https://www.google.com/recaptcha/api.js"></script>
                            <div class="g-recaptcha" data-sitekey="{{ $general->recaptcha_key }}"
                                data-callback="verifyCaptcha"></div>
                            <div id="g-recaptcha-error"></div>
                        </div>
                    @endif

                    <div class="d-flex flex-wrap align-items-center mt-4">
                        <button type="submit" id="recaptcha"
                        class="btn main-btn">إرسال رمز إعادة تعيين كلمة المرور</button>
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