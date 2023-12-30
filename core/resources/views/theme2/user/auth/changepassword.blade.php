@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="card bg-second">
                    <div class="card-body">
                        <form action="{{ route('user.update.password') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="exampleInputEmail1"
                                    class=" mt-2 mb-2">كلمة المرور القديمة</label>
                                <input type="password" class="form-control" name="oldpassword"
                                    placeholder="كلمة المرور القديمة">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"
                                    class=" mt-2 mb-2">كلمة المرور الجديدة</label>
                                <input type="password" class="form-control" name="password"
                                    placeholder="كلمة المرور الجديدة">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"
                                    class=" mt-2 mb-2">أعد كتابة كلمة المرور الجديدة</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    placeholder="أعد كتابة كلمة المرور الجديدة">
                            </div>
                            <div class="row mt-4">
                                <div class="col-xs-12 d-grid gap-2">
                                    <button class="btn main-btn" type="submit">تحديث</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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