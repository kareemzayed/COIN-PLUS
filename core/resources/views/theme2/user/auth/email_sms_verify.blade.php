@extends(template() . 'layout.auth')

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
                <h2 class="title">{{ __('Email/SMS Verification') }}</h2>
            </div>
        </div>
        <div class="form-wrapper">
            <div class="inner-wrapper">
                <h2 class="title text-center"></h2>

                @if ($general->is_email_verification_on && !auth()->user()->ev)
                    <form class="account-form" action="{{ route('user.authentication.verify.email') }}" method="POST">
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
                @elseif($general->is_sms_verification_on && !auth()->user()->sv)
                    <form method="POST" action="{{ route('user.authentication.verify.sms') }}" class="account-form">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">{{ __('Sms Verify Code') }}</label>
                            <input type="text" name="code" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn main-btn">{{ __('Verify Now') }}</button>

                    </form>
                @endif
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