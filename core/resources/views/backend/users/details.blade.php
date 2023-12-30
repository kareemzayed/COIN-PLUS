@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>تفاصيل المستخدم</h1>
            </div>
            @if (checkPermission(48))
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="card card-statistic-1 mb-0">
                                    <div class="card-icon bg-primary">
                                        <i class="far fa-user"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>رصيد المستخدم</h4>
                                        </div>
                                        <div class="card-body">
                                            {{ number_format($user->balance, 2) . ' ' . $general->site_currency }}
                                        </div>
                                    </div>
                                </div>
                                <p style="float: right">إيداع او سحب إداري من هذا المستخدم</p>
                                <form action="{{ route('admin.user.balance.update', $user->id) }}" method="post">
                                    @csrf

                                    <!-- action input -->
                                    <input type="hidden" id="clickedButtonValue" name="action" value="">

                                    <input type="hidden" class="form-control" name="user_id" value="{{ $user->id }}">
                                    <input type="number" step="any" class="form-control mb-2 specialInput"
                                        name="balance" placeholder="المبلغ">
                                    <input type="text" class="form-control mb-2 specialInput" name="note"
                                        placeholder="ملاحظة">
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary ml-2" type="submit" name="action" value="add">
                                            <i class="fa fa-plus"></i> إيداع
                                        </button>
                                        <button class="btn btn-danger" type="submit" name="action" value="minus">
                                            <i class="fa fa-minus"></i> سحب
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ getFile('user', $user->image, true) }}" class="w-100">
                            <div class="container my-3">
                                <h4>{{ $user->fullname }}</h4>
                                <p class="title">{{ $user->designation }}</p>
                                <p class="title">{{ $user->email }}</p>
                                @if (checkPermission(49))
                                    <a href="" class="btn btn-primary sendMail">إرسال بريد الكتروني الي المستخدم</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>الأسم الأول</label>
                                        <input type="text" name="fname" class="form-control"
                                            value="{{ $user->fname }}">
                                    </div>
                                    <div class="col-md-6 mb-3">

                                        <label>الأسم الأخير</label>
                                        <input type="text" name="lname" class="form-control"
                                            value="{{ $user->lname }}">
                                    </div>

                                    <div class="form-group col-md-6 mb-3 ">
                                        <label>رقم الهاتف</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ $user->phone }}">
                                    </div>
                                    <div class="form-group col-md-6 mb-3 ">
                                        <label>البلد</label>
                                        <input type="text" name="country" class="form-control"
                                            value="{{ optional($user->address)->country ?? '' }}">
                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <label>المدينة</label>
                                        <input type="text" name="city" class="form-control form_control"
                                            value="{{ optional($user->address)->city ?? '' }}">
                                    </div>

                                    <div class="col-md-6 mb-3">

                                        <label>الرمز البريدي</label>
                                        <input type="text" name="zip" class="form-control form_control"
                                            value="{{ optional($user->address)->zip ?? '' }}">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label>الولاية</label>
                                        <input type="text" name="state" class="form-control form_control"
                                            value="{{ optional($user->address)->state ?? '' }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>حالة الحساب</label>
                                        <select name="status" id="" class="form-control">

                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>
                                                نشط</option>
                                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>
                                                غير نشط</option>
                                        </select>
                                    </div>
                                </div>
                                @if (checkPermission(4))
                                    <div class="col-md-12 mt-4">
                                        <button type="submit" class="btn btn-primary w-100">تحديث المستخدم</button>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="mail">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.user.mail', $user->id) }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إرسال بريد الكتروني الي المستخدم</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">الموضوع</label>
                            <input type="text" name="subject" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">الرسالة</label>
                            <textarea name="message" id="" cols="30" rows="10" class="form-control summernote"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">إرسال</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict'
        $(function() {
            $('.sendMail').on('click', function(e) {
                e.preventDefault();
                const modal = $('#mail');
                modal.modal('show');
            })
        })
    </script>
    <script>
        $(function() {
            'use strict';

            $('form').on('submit', function() {
                const clickedButton = $(document.activeElement);
                if (clickedButton.is(':submit')) {
                    $('#clickedButtonValue').val(clickedButton.val());
                    clickedButton.prop('disabled', true).html(
                        'جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
@endpush