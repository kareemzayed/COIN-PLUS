@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>قائمة بلاغات المعاملات</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-form">
                                <form method="GET" action="">
                                    <div class="input-group">
                                        <input type="text" name="utr" class="form-control" placeholder="رقم البلاغ"
                                            value="{{ isset($search['utr']) ? $search['utr'] : '' }}">
                                        <input type="date" name="date" class="form-control" placeholder="تاريخ البلاغ"
                                            value="{{ isset($search['date']) ? $search['date'] : '' }}">
                                        <select class="form-control" name="status">
                                            <option disabled selected>حالة البلاغ</option>
                                            <option value="">عرض الكل</option>
                                            <option value="0"
                                                {{ isset($search['status']) && $search['status'] == '0' ? 'selected' : '' }}>
                                                قيد الأنتظار</option>
                                            <option value="1"
                                                {{ isset($search['status']) && $search['status'] == '1' ? 'selected' : '' }}>
                                                تم الرد</option>
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
                                            <th>رقم البلاغ</th>
                                            <th>العميل</th>
                                            <th>رقم المعاملة</th>
                                            <th>نوع المعاملة</th>
                                            <th>سبب البلاغ</th>
                                            <th>رد الأدمن</th>
                                            <th>حالة البلاغ</th>
                                            <th>تم الأنشاء في</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reports as $report)
                                            <tr>
                                                <td scope="row"><b>{{ $report->utr }}</b></td>
                                                <td>{{ $report->user->fullname }}</td>
                                                <td>{{ $report->transaction->transactional->utr }}</td>
                                                <td>
                                                    @if ($report->transaction->transactional_type == 'App\Models\UpdateUsersBalance')
                                                        <a href="{{ checkPermission(58) ? route('admin.deposits.withdraws.index', ['utr' => $report->transaction->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            @if ($report->transaction->transactional->type == 'add')
                                                                إيداع إداري الي مستخدم
                                                            @elseif($report->transaction->transactional->type == 'minus')
                                                                سحب إداري من مستخدم
                                                            @endif
                                                        </a>
                                                    @elseif($report->transaction->transactional_type == 'App\Models\Purchase')
                                                        <a href="{{ checkPermission(18) ? route('admin.purchase.index', ['utr' => $report->transaction->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            شراء من وسيط الي عميل
                                                        </a>
                                                    @elseif($report->transaction->transactional_type == 'App\Models\Sale')
                                                        <a href="{{ checkPermission(22) ? route('admin.sales.index', ['utr' => $report->transaction->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            بيع مباشر الي عميل
                                                        </a>
                                                    @elseif($report->transaction->transactional_type == 'App\Models\DirectPurchase')
                                                        <a href="{{ checkPermission(73) ? route('admin.direct.purchase.index', ['utr' => $report->transaction->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            شراء مباشر
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>{{ $report->reason ?? 'N/A' }}</td>
                                                <td>{{ $report->admin_reply ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($report->replied == 0)
                                                        <span class="badge badge-warning"> قيد الأنتظار </span>
                                                    @endif
                                                    @if ($report->replied == 1)
                                                        <span class="badge badge-success"> تم الرد</span>
                                                    @endif
                                                </td>

                                                <td>{{ $report->created_at->format('m/d/Y h:i A') }}</td>
                                                <td>
                                                    @if (checkPermission(8))
                                                        @if ($report->replied == 0)
                                                            <button
                                                                data-href="{{ route('admin.transactions.reports.reply', $report->id) }}"
                                                                data-report="{{ $report }}"
                                                                class="btn btn-md btn-info reply">
                                                                <i class="fas fa-reply"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">لم يتم العثور علي اي بلاغات</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($reports->hasPages())
                            <div class="card-footer">
                                {{ $reports->links('backend.partial.paginate') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
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
                                <label for="reply">ردك علي البلاغ <span class="text-danger">*</span></label>
                                <textarea name="reply" id="reply" class="form-control" rows="3" required></textarea>
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
        'use strict'

        $('.reply').on('click', function() {
            const modal = $('#replyModelId');
            modal.find('.modal-title').text("رد علي البلاغ رقم" + ' ' + ($(this)
                .data('report').utr || ''));
            modal.find('textarea[name=reply]').val('')
            modal.find('form').attr('action', $(this).data('href'));
            modal.find('#submit').show();
            modal.modal('show');
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
