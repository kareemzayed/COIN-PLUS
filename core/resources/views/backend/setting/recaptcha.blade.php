@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>جوجل ريكابتشا (التأكد من ان المستخدم ليس روبوت عند تسجيل الدخول)</h1>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Recaptcha Key</label>
                                        <input type="text" name="recaptcha_key" class="form-control" placeholder="Recaptcha Key"
                                            value="{{ $recaptcha->recaptcha_key }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Recaptcha Secret</label>
                                        <input type="text" name="recaptcha_secret" class="form-control" placeholder="Recaptcha Secret"
                                            value="{{ $recaptcha->recaptcha_secret }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">السماح بجوجل ريكابتشا</label>
                                        <select name="allow_recaptcha" id="" class="form-control">
                                            <option value="1" {{ $recaptcha->allow_recaptcha==1 ? 'selected' : '' }}>
                                                نعم</option>
                                            <option value="0" {{ $recaptcha->allow_recaptcha==0 ? 'selected' : '' }}>
                                                لا</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary float-right">تحديث ريكابتشا</button>
                                    </div>
                                </div>
                            </form>
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