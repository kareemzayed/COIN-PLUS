@extends(template().'layout.auth')
@php

$content = content('breadcrumb.content');

$login = content('login.content');

@endphp

@section('content')
    @push('seo')
        <meta name='description' content="{{ $general->seo_description }}">
    @endpush

    <div class="account-page">
        <div class="content-wrapper"
            style="background-image: url('{{ getFile('frontendlogin', $general->frontend_login_image, true) }}')">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="{{ getFile('logo', $general->logo, true) }}" alt="image"></a>
            </div>
            <div class="content">
                <h2 class="title"></h2>
            </div>
        </div>
        <div class="form-wrapper">
            <div class="inner-wrapper">
                <h2 class="title">{{ __('Request For Reset Password') }}</h2>

                <form class="reg-form" action="" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="formGroupExampleInput"> {{ __('Verification Code') }}</label>
                        <input type="text" name="code" class="form-control"
                            placeholder="{{ __('Enter Verification Code') }}">
                    </div>
                    @if ($general->allow_recaptcha)
                        <div class="mb-3">
                            <script src="https://www.google.com/recaptcha/api.js"></script>
                            <div class="g-recaptcha" data-sitekey="{{ $general->recaptcha_key }}"
                                data-callback="verifyCaptcha"></div>
                            <div id="g-recaptcha-error"></div>
                        </div>
                    @endif
                    <button class="btn main-btn" type="submit"> {{ __('Verify Now') }} </button>
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
                    "<span class='text-danger'>{{__('Captcha field is required.')}}</span>";
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