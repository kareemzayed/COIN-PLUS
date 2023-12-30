@extends('backend.auth.master')

@section('content')
    <div id="app">
        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card card-primary login">
                            <div class="card-header">
                                <h4 class="text-white">إعادة تعيين كلمة المرور</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.password.change') }}" method="POST" class="cmn-form mt-30">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ isset($email) ? $email : '' }}">
                                    <input type="hidden" name="token" value="{{ isset($token) ? $token : '' }}">
                                    <div class="form-group">
                                        <label for="pass" class="text-white">كلمة المرور الجديدة</label>
                                        <input type="password" name="password" class="form-control b-radius--capsule"
                                            id="password" placeholder="كلمة المرور الجديدة">
                                        <i class="las la-lock input-icon"></i>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass" class="text-white">أعد كتابة كلمة المرور الجديدة</label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control b-radius--capsule" id="password_confirmation"
                                            placeholder="أعد كتابة كلمة المرور الجديدة">
                                        <i class="las la-lock input-icon"></i>
                                    </div>
                                    <div class="form-group">
                                        <a href="{{ route('admin.login') }}" class="text-white text--small"><i
                                                class="las la-lock"></i>تسجيل الدخول من هنا</a>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="login-button text-white" tabindex="4">
                                            إعادة تعيين كلمة المرور
                                        </button>
                                    </div>
                                </form>
                            </div>
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