@extends(template() . 'layout.master')

@section('content')
    @php
        $login = content('login.content');
    @endphp
    <div class="account-page">
        <div class="content-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{ getFile('logo', $general->logo, true) }}" alt="شعار"></a>
            </div>
            <div class="content">
                <h2 class="title"></h2>
            </div>
        </div>
        <div class="form-wrapper">
            <div class="inner-wrapper">
                <h2 class="title text-center">{{ $login->data->title }}</h2>
                <form action="{{ route('user.reset.password') }}" method="POST" class="account-form">

                    @csrf
                    <div class="row justify-content-center">

                        <input type="hidden" name="email" value="{{ $session['email'] }}">

                        <div class="form-group col-md-12">
                            <label for="" class="text-secondary mt-2 mb-2">كلمة المرور الجديدة</label>
                            <input type="password" name="password" class="form-control" placeholder="كلمة المرور الجديدة">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="" class="text-secondary mb-2 mt-2">أعد كتابة كلمة المرور الجديدة</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="أعد كتابة كلمة المرور الجديدة">
                        </div>

                        @if ($general->allow_recaptcha == 1)
                            <div class="col-md-12 my-3">
                                <script src="https://www.google.com/recaptcha/api.js"></script>
                                <div class="g-recaptcha" data-sitekey="{{ $general->recaptcha_key }}"
                                    data-callback="verifyCaptcha"></div>
                                <div id="g-recaptcha-error"></div>
                            </div>
                        @endif

                        <div class="d-flex flex-wrap align-items-center mt-4">
                            <button type="submit" id="recaptcha" class="btn main-btn">إعادة تعيين كلمة المرور</button>
                            <span class="px-3">أو</span>
                            <a href="{{ route('user.login') }}" class="site-color">تسجيل الدخول</a>
                        </div>
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
