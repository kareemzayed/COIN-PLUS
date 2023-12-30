@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة الإيداعات والسحوبات الإدارية</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="{{ route('admin.deposits.withdraws.search') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم المعاملة" name="utr"
                                    value="{{ isset($search['utr']) ? $search['utr'] : '' }}">
                                <input type="date" class="form-control" placeholder="تاريخ المعاملة" name="date"
                                    value="{{ isset($search['date']) ? $search['date'] : '' }}">
                                <select name="type" class="form-select form-control">
                                    <option disabled selected>نوع المعاملة</option>
                                    <option value="">عرض الكل</option>
                                    <option value="minus"
                                        {{ isset($search['type']) && $search['type'] == 'minus' ? 'selected' : '' }}>سحب
                                        إداري</option>
                                    <option value="add"
                                        {{ isset($search['type']) && $search['type'] == 'add' ? 'selected' : '' }}>إيداع
                                        إداري</option>
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
                                    <th>المستخدم</th>
                                    <th>نوع المعاملة</th>
                                    <th>المبلغ</th>
                                    <th>رصيد المستخدم المتحرك</th>
                                    <th>ملاحظة</th>
                                    <th>رقم المعاملة</th>
                                    <th>في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($update_users_balance as $key => $value)
                                    <tr>
                                        <td>{{ $key + $update_users_balance->firstItem() }}</td>
                                        <td>
                                            <a href="{{ route('admin.user.details', $value->user->id) }}"
                                                style="text-decoration: none; font-size: 14px">
                                                {{ optional($value->user)->fullname }}
                                            </a>
                                        </td>
                                        <td>
                                            @if ($value->type == 'minus')
                                                <span class="text-danger">سحب إداري</span>
                                            @elseif($value->type == 'add')
                                                <span class="text-success"> إيداع إداري</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ number_format($value->amount, 2) . ' ' . $general->site_currency }}
                                        </td>
                                        <td>
                                            {{ number_format($value->floating_balance, 2) . ' ' . $general->site_currency }}
                                        </td>
                                        <td>{{ $value->note ?? 'N/A' }}</td>
                                        <td>{{ $value->utr }}</td>
                                        <td>
                                            {{ $value->created_at->format('m/d/Y h:i A') }}
                                        </td>
                                        <td style="width:12%">
                                            @if (checkPermission(59))
                                                <button
                                                    data-href="{{ route('admin.deposits.withdraws.update', $value->id) }}"
                                                    data-trans="{{ $value }}" class="btn btn-md btn-info update"><i
                                                        class="fa fa-pen"></i></button>
                                            @endif

                                            @if (checkPermission(60))
                                                <button
                                                    data-href="{{ route('admin.deposits.withdraws.delete', $value->id) }}"
                                                    data-trans="{{ $value }}"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي معاملات إيداع او سحب
                                            إداري</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($update_users_balance->hasPages())
                        <div class="card-footer">
                            {{ $update_users_balance->links('backend.partial.paginate') }}
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
                            <div class="form-group col-md-12 col-12">
                                <label for="amount">المبلغ <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->site_currency }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="note">ملاحظة</label>
                                <textarea name="note" id="note" class="form-control" rows="3"></textarea>
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

            $('.update').on('click', function() {
                const modal = $('#modelId');
                const form = modal.find('form');
                form[0].reset();
                modal.find('.modal-title').text("تعديل المعاملة رقم" + ' ' + ($(this)
                    .data('trans').utr || ''));
                modal.find('input[name=amount]').val($(this).data('trans').amount)
                modal.find('textarea[name=note]').text($(this).data('trans').note)
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف المعاملة رقم" + ' ' + ($(this)
                    .data('trans').utr || ''));
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