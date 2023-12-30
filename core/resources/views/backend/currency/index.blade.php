@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>قائمة العملات</h1>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                @if (checkPermission(68))
                                    <button class="btn btn-primary add"><i class="fa fa-plus"></i> اضافة عملة جديدة</button>
                                @endif
                            </h4>
                            <div class="card-header-form">
                                <form method="GET" action="{{ route('admin.currency.search') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="اسم العملة" name="name"
                                            value="{{ isset($search['name']) ? $search['name'] : '' }}">
                                        <input type="text" class="form-control" placeholder="رمز العملة" name="code"
                                            value="{{ isset($search['code']) ? $search['code'] : '' }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th>اسم العملة</th>
                                            <th>رمز العملة</th>
                                            <th>سعر الصرف</th>
                                            <th>الحالة</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($currencies as $currency)
                                            <tr>
                                                <td><img src='{{ getFile('currency', $currency->image, true) }}'
                                                        class="flagadmin"> {{ $currency->name }}
                                                </td>
                                                <td>{{ $currency->code }}</td>
                                                <td dir="ltr">
                                                    {{ '1 ' . $general->site_currency . ' = ' . number_format($currency->rate, 2) . ' ' . $currency->code }}
                                                </td>
                                                <td>
                                                    @if ($currency->status)
                                                        <span class="badge badge-success">نشط</span>
                                                    @else
                                                        <span class="badge badge-danger">غير نشط</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (checkPermission(66))
                                                        <button
                                                            data-href="{{ route('admin.currency.update', $currency->id) }}"
                                                            data-currency="{{ $currency }}"
                                                            class="btn btn-md btn-info update"><i
                                                                class="fa fa-pen"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="100%">لم يتم العثور علي اي عملات</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($currencies->hasPages())
                            <div class="card-footer">
                                {{ $currencies->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="post" enctype="multipart/form-data">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label for="name">اسم العملة <span class="text-danger">*</span> </label>
                                    <input type="text" id="name" name="name" class="form-control" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="code">رمز العملة <span class="text-danger">*</span> </label>
                                    <input type="text" name="code" class="form-control" required id="currency">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>سعر صرف العملة <span class="text-danger">*</span> </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                1 {{ $general->site_currency }} =
                                            </div>
                                        </div>
                                        <input type="number" step="any" class="form-control" name="rate">
                                        <div class="input-group-append">
                                            <div class="input-group-text currency">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">حالة العملة <span class="text-danger">*</span> </label>
                                    <input type="checkbox" data-toggle="toggle" data-on="نشط" data-off="غير نشط"
                                        data-onstyle="success" data-offstyle="danger" name="status">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">صورة العملة</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .toggle {
            width: 100% !important;
        }

        .flagadmin {
            max-width: 50px;
            margin-left: 10px;
        }
    </style>
@endpush

@push('script')
    <script>
        $(function() {
            'use strict'

            $('#currency').on('keyup', function() {
                $('.currency').text($(this).val())
            })

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("اضافة عملة جديدة")
                modal.find('input[name=name]').val('')
                modal.find('input[name=code]').val('')
                modal.find('input[name=rate]').val('')
                modal.find('input[name=image]').val('')
                modal.find('input[name=status]').bootstrapToggle('off');
                $('.currency').text('')
                modal.find('form').attr('action', '{{ route('admin.currency.add') }}');
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                const form = modal.find('form');
                form[0].reset();
                modal.find('.modal-title').text("تعديل عملة" + ' ' + ($(this)
                    .data('currency').name || ''));
                modal.find('input[name=name]').val($(this).data('currency').name)
                modal.find('input[name=code]').val($(this).data('currency').code)
                modal.find('input[name=rate]').val(parseFloat($(this).data('currency').rate).toFixed(2))
                $('.currency').text($(this).data('currency').code)
                if ($(this).data('currency').status) {
                    modal.find('input[name=status]').bootstrapToggle('on');
                } else {
                    modal.find('input[name=status]').bootstrapToggle('off');
                }
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show')
            })
        })
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