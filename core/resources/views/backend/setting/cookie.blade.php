@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>تعديل الكوكيز</h1>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">السماح بنموذج الكوكيز</label>
                                        <select name="allow_modal" class="form-control">
                                            <option value="1" {{ $cookie->allow_modal == 1 ? 'selected' : '' }}>
                                                نعم</option>
                                            <option value="0" {{ $cookie->allow_modal == 0 ? 'selected' : '' }}>
                                                لا</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">نص زر الكوكيز</label>
                                        <input type="text" name="button_text" class="form-control"
                                            placeholder="نص زر الكوكيز" value="{{ $cookie->button_text }}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">نص الكوكيز</label>
                                        <textarea name="cookie_text" cols="30" rows="10" class="form-control">{{ __(clean($cookie->cookie_text)) }}</textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary float-right">تعديل الكوكيز</button>
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