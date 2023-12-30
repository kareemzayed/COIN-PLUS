@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة المعاملات الخارجية</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        @if (checkPermission(55))
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إنشاء معاملة خارجية جديدة</button>
                        @endif
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="{{ route('admin.external.transactions.search') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم المعاملة" name="utr"
                                    value="{{ isset($search['utr']) ? $search['utr'] : '' }}">
                                <input type="text" class="form-control" placeholder="اسم العميل" name="customar_name"
                                    value="{{ isset($search['customar_name']) ? $search['customar_name'] : '' }}">
                                <input type="date" class="form-control" placeholder="تاريخ المعاملة" name="date"
                                    value="{{ isset($search['date']) ? $search['date'] : '' }}">
                                <select class="form-control" name="trans_type">
                                    <option disabled selected>نوع المعاملة</option>
                                    <option value="">عرض الكل</option>
                                    <option value="1"
                                        {{ isset($search['trans_type']) && $search['trans_type'] == '1' ? 'selected' : '' }}>
                                        شراء</option>
                                    <option value="2"
                                        {{ isset($search['trans_type']) && $search['trans_type'] == '2' ? 'selected' : '' }}>
                                        بيع</option>
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
                                    <th>نوع المعاملة</th>
                                    <th>اسم العميل</th>
                                    <th>تفاصيل المعاملة</th>
                                    <th>المبلغ</th>
                                    <th>صافي الربح</th>
                                    <th>رقم المعاملة</th>
                                    <th>في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($external_transactions as $key => $value)
                                    <tr>
                                        <td>{{ $key + $external_transactions->firstItem() }}</td>
                                        <td>
                                            @if ($value->trans_type == 1)
                                                <span class="text-success">معاملة شراء</span>
                                            @elseif($value->trans_type == 2)
                                                <span class="text-danger">معاملة بيع</span>
                                            @endif
                                        </td>
                                        <td>{{ $value->customar_name }}</td>
                                        <td>{{ $value->details }}</td>
                                        <td>
                                            {{ number_format($value->amount, 2) . ' ' . $general->site_currency }}
                                        </td>
                                        <td>
                                            {{ number_format($value->charge, 2) . ' ' . $general->site_currency }}
                                        </td>
                                        <td>{{ $value->utr }}</td>
                                        <td>
                                            {{ $value->created_at->format('m/d/Y h:i A') }}
                                        </td>
                                        <td style="width:12%">
                                            @if (checkPermission(57))
                                                <button
                                                    data-href="{{ route('admin.external.transaction.update', $value->id) }}"
                                                    data-transaction="{{ $value }}"
                                                    class="btn btn-md btn-info update"><i class="fa fa-pen"></i></button>
                                            @endif
                                            @if (checkPermission(56))
                                                <button
                                                    data-href="{{ route('admin.external.transaction.delete', $value->id) }}"
                                                    data-transaction="{{ $value }}"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي معاملات خارجية</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($external_transactions->hasPages())
                        <div class="card-footer">
                            {{ $external_transactions->links('backend.partial.paginate') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Model -->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                @csrf
                {{ method_field('DELETE') }}

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row col-md-12">
                            <p>هل أنت متأكد أنك تريد حذف هذه المعاملة؟ سيؤدي حذفها إلى استرجاع الأموال وإلغاء المعاملة بشكل
                                كامل.
                            </p>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-danger" type="submit">حذف</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!------------------>

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
                                <label for="trans_type">نوع المعاملة <span class="text-danger">*</span> </label>
                                <select class="form-control" name="trans_type" id="trans_type">
                                    <option disabled selected value="0">نوع المعاملة</option>
                                    <option value="1">شراء</option>
                                    <option value="2">بيع</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="customar_name">اسم العميل <span class="text-danger">*</span> </label>
                                <input type="text" id="customar_name" name="customar_name" class="form-control"
                                    required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount">مبلغ المعاملة <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->site_currency }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="charge">صافي الربح من هذه المعاملة <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="charge" id="charge" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->site_currency }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="details">تفاصيل المعاملة</label>
                                <textarea name="details" id="details" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" id="submit" class="btn btn-primary">حفظ</button>
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
                modal.find('.modal-title').text("إنشاء معاملة خارجية جديدة")
                modal.find('select[name=trans_type]').val("0")
                modal.find('input[name=customar_name]').val('')
                modal.find('input[name=amount]').val('')
                modal.find('input[name=charge]').val('')
                modal.find('textarea[name=details]').text('')
                modal.find('form').attr('action', '{{ route('admin.external.transaction.create') }}');
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                const form = modal.find('form');
                form[0].reset();
                modal.find('.modal-title').text("تعديل المعاملة الخارجية رقم" + ' ' + ($(this)
                    .data('transaction').utr || ''));
                modal.find('select[name=trans_type]').val($(this).data('transaction').trans_type)
                modal.find('input[name=customar_name]').val($(this).data('transaction').customar_name)
                modal.find('input[name=amount]').val($(this).data('transaction').amount)
                modal.find('input[name=charge]').val($(this).data('transaction').charge)
                modal.find('textarea[name=details]').text($(this).data('transaction').details)
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف المعاملة الخارجية رقم" + ' ' + ($(this)
                    .data('transaction').utr || ''));
                modal.find('form').attr('action', $(this).data('href'))
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
