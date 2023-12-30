@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة صناديق الشركة</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        @if (checkPermission(41))
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إضافة صندوق جديد</button>
                        @endif
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="اسم الصندوق" name="name"
                                    value="{{ isset($search['name']) ? $search['name'] : '' }}">
                                <input type="date" class="form-control" placeholder="تاريخ إنشاء الصندوق" name="date"
                                    value="{{ isset($search['date']) ? $search['date'] : '' }}">
                                <select class="form-control" name="status">
                                    <option disabled selected>حالة الصندوق</option>
                                    <option value="">عرض الكل</option>
                                    <option value="1"
                                        {{ isset($search['status']) && $search['status'] == '1' ? 'selected' : '' }}>
                                        نشط</option>
                                    <option value="2"
                                        {{ isset($search['status']) && $search['status'] == '2' ? 'selected' : '' }}>
                                        غير نشط</option>
                                </select>
                                <div class="input-group-btn">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الصندوق</th>
                                    <th>الرصيد المتاح</th>
                                    <th>حالة الصندوق</th>
                                    <th>تم الإنشاء في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($funds as $key => $fund)
                                    <tr>
                                        <td>{{ $key + $funds->firstItem() }}</td>
                                        <td>
                                            <a href="{{ checkPermission(38) ? route('admin.fund.transactions', $fund->id) : '#' }}"
                                                style="font-size: 15px; text-decoration: none;">
                                                {{ $fund->name }}
                                            </a>
                                        </td>
                                        <td class="{{ $fund->balance > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($fund->balance, 2) . ' ' . $general->site_currency }}
                                        </td>
                                        <td>
                                            @if ($fund->status == 1)
                                                <div class="badge badge-success">نشط</div>
                                            @elseif($fund->status == 2)
                                                <div class="badge badge-danger">غير نشط</div>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $fund->created_at->format('m/d/Y h:i A') }}
                                        </td>
                                        <td>
                                            @if (checkPermission(35))
                                                <button data-href="{{ route('admin.fund.update', $fund) }}"
                                                    data-fund="{{ $fund }}"
                                                    class="btn btn-md btn-primary update"><i class="fa fa-pen"></i></button>
                                            @endif

                                            @if (checkPermission(36))
                                                <button data-href="{{ route('admin.fund.add.balance', $fund) }}"
                                                    data-fund="{{ $fund }}"
                                                    class="btn btn-md btn-success addBalance"><i
                                                        class="fa fa-plus"></i></button>
                                            @endif

                                            @if (checkPermission(37))
                                                <button data-href="{{ route('admin.fund.subtract.balance', $fund) }}"
                                                    data-fund="{{ $fund }}"
                                                    class="btn btn-md btn-danger subtructBalance"><i
                                                        class="fa fa-minus"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي صناديق</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($funds->hasPages())
                        <div class="card-footer">
                            {{ $funds->links('backend.partial.paginate') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Create And Update Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label for="">اسم الصندوق <span class="text-danger">*</span> </label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="">حالة الصندوق</label>
                                <select name="status" class="form-control">
                                    <option value="1">نشط</option>
                                    <option value="2">غير نشط</option>
                                </select>
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

    <!-- Add Balance Modal -->
    <div class="modal fade" id="addBalanceModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="post">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label for="">المبلغ <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="text" name="amount" placeholder="0.00" class="form-control"
                                        required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->site_currency }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="">ملاحظة</label>
                                <textarea name="note" class="form-control"></textarea>
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
    <!-- Sub Balance Modal -->
    <div class="modal fade" id="subBalanceModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="post">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label for="">المبلغ <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="text" name="amount" placeholder="0.00" class="form-control"
                                        required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->site_currency }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="">ملاحظة</label>
                                <textarea name="note" class="form-control"></textarea>
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
@push('script')
    <script>
        $(function() {
            'use strict'

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("إنشاء صندوق جديد")
                modal.find('input[name=name]').val('')
                modal.find('form').attr('action', '{{ route('admin.fund.create') }}');
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("تعديل الصندوق")
                modal.find('input[name=name]').val($(this).data('fund').name)
                modal.find('select[name=status]').val($(this).data('fund').status)
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            })

            $('.addBalance').on('click', function() {
                const modal = $('#addBalanceModel');
                modal.find('.modal-title').text("إيداع رصيد في صندوق" + ' ' + ($(this)
                    .data('fund').name || ''));
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            })

            $('.subtructBalance').on('click', function() {
                const modal = $('#subBalanceModel');
                modal.find('.modal-title').text("سحب رصيد من صندوق" + ' ' + ($(this)
                    .data('fund').name || ''));
                modal.find('form').attr('action', $(this).data('href'));
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
                    clickedButton.prop('disabled', true).html('جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
@endpush