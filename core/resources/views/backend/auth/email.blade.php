@extends('backend.auth.master')
@section('content')
    <section class="login-page">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="admin-login-wrapper">
                        <h3 class="text-dark text-center mb-4">إرسال رمز إعادة التعيين</h3>
                        <form action="{{ route('admin.password.reset') }}" method="POST" class="cmn-form mt-30">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="text-white">البريد الألكتروني</label>
                                <input type="email" name="email" class="form-control b-radius--capsule" id="username"
                                    value="{{ old('email') }}" placeholder="ادخل البريد الألكتروني">
                                <i class="las la-user input-icon"></i>
                            </div>
                            <div class="form-group text-right">
                                <a href="{{ route('admin.login') }}" class="text--small"><i
                                        class="fas fa-lock mr-2"></i>تسجيل الدخول من هنا</a>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="login-button text-white w-100" tabindex="4">
                                    إرسال رمز إعادة التعيين
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="simple-footer text-white">
                        @if ($general->copyright)
                            {{ $general->copyright }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
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