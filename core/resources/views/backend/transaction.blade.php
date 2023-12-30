@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>سجل المعاملات</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <form action="" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="dates">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">بحث</button>
                                    </div>
                                </div>
                            </form>
                            @if (isset($dates[1]))
                                {{ $dates[0]->format('Y-m-d') . ' ' . 'الي' . ' ' . $dates[1]->format('Y-m-d') }}<br>
                            @endif
                            {{ 'الأرباح ' . number_format($totalCharge, 2) . ' ' . $general->site_currency }}
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>نوع المعاملة</th>
                                            <th>من (التاجر او الصندوق)</th>
                                            <th>الي (العميل)</th>
                                            <th>العنصر</th>
                                            <th>المبلغ</th>
                                            <th>صافي الربح</th>
                                            <th>ملاحظة</th>
                                            <th>رقم المعاملة</th>
                                            <th>في</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions as $key => $value)
                                            <tr>
                                                <td>{{ $key + $transactions->firstItem() }}</td>
                                                <td>
                                                    @if ($value->transactional_type == 'App\Models\Purchase')
                                                        <a href="{{ checkPermission(18) ? route('admin.purchase.index', ['utr' => $value->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            شراء من وسيط الي عميل
                                                        </a>
                                                    @elseif($value->transactional_type == 'App\Models\Sale')
                                                        <a href="{{ checkPermission(22) ? route('admin.sales.index', ['utr' => $value->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            بيع مباشر
                                                        </a>
                                                    @elseif($value->transactional_type == 'App\Models\DirectPurchase')
                                                        <a href="{{ checkPermission(73) ? route('admin.direct.purchase.index', ['utr' => $value->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            شراء مباشر
                                                        </a>
                                                    @elseif($value->transactional_type == 'App\Models\ReceiptVoucher')
                                                        <a href="{{ checkPermission(25) ? route('admin.receipt.vouchers.index', ['receipt_number' => $value->transactional->receipt_num]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            سند قبض
                                                        </a>
                                                    @elseif($value->transactional_type == 'App\Models\PaymentVoucher')
                                                        <a href="{{ checkPermission(29) ? route('admin.payment.vouchers.index', ['receipt_number' => $value->transactional->receipt_num]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            سند صرف
                                                        </a>
                                                    @elseif($value->transactional_type == 'App\Models\UpdateUsersBalance')
                                                        <a href="{{ checkPermission(58) ? route('admin.deposits.withdraws.index', ['utr' => $value->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            @if (optional($value->transactional)->type == 'add')
                                                                إيداع إداري الي مستخدم
                                                            @elseif(optional($value->transactional)->type == 'minus')
                                                                سحب إداري من مستخدم
                                                            @endif
                                                        </a>
                                                    @elseif($value->transactional_type == 'App\Models\TransactionWithCurrency')
                                                        <a href="{{ checkPermission(69) ? route('admin.trans.with.currency.index', ['utr' => $value->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            @if (optional($value->transactional)->trans_type == '1')
                                                                معاملة شراء بعملات متعددة
                                                            @elseif(optional($value->transactional)->trans_type == '2')
                                                                معاملة بيع بعملات متعددة
                                                            @endif
                                                        </a>
                                                    @elseif($value->transactional_type == 'App\Models\FundsTransaction')
                                                        <a href="{{ checkPermission(38) ? route('admin.funds.transactions', ['utr' => $value->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            @if (optional($value->transactional)->type == 'add balance')
                                                                إيداع رصيد الي صندوق
                                                            @elseif(optional($value->transactional)->type == 'subtract balance')
                                                                سحب رصيد من صندوق
                                                            @endif
                                                        </a>
                                                    @elseif($value->transactional_type == 'App\Models\ExternalTransaction')
                                                        <a href="{{ checkPermission(54) ? route('admin.external.transactions.index', ['utr' => $value->transactional->utr]) : '#' }}"
                                                            style="text-decoration: none; font-size: 14px">
                                                            معاملة خارجية
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($value->transactional_type == 'App\Models\Purchase')
                                                        {{ optional(optional($value->transactional)->seller)->fname . ' ' . optional(optional($value->transactional)->seller)->lname ?? 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\Sale')
                                                        {{ optional(optional($value->transactional)->fund)->name ?? 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\DirectPurchase')
                                                        @if ($value->transactional->seller)
                                                            {{ optional(optional($value->transactional)->seller)->fullname ?? 'N/A' }}
                                                        @else
                                                            {{ $value->transactional->seller_on_way_name . ' (ONWAY)' }}
                                                        @endif
                                                    @elseif($value->transactional_type == 'App\Models\ReceiptVoucher')
                                                        {{ optional($value->transactional)->customar_name ?? 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\PaymentVoucher')
                                                        {{ 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\UpdateUsersBalance')
                                                        @if (optional($value->transactional)->type == 'add')
                                                            {{ 'N/A' }}
                                                        @elseif(optional($value->transactional)->type == 'minus')
                                                            {{ optional(optional($value->transactional)->user)->fname . ' ' . optional(optional($value->transactional)->user)->lname ?? 'N/A' }}
                                                        @endif
                                                    @elseif($value->transactional_type == 'App\Models\FundsTransaction')
                                                        @if (optional($value->transactional)->type == 'add balance')
                                                            {{ 'N/A' }}
                                                        @elseif(optional($value->transactional)->type == 'subtract balance')
                                                            {{ optional(optional($value->transactional)->fund)->name ?? 'N/A' }}
                                                        @endif
                                                    @elseif(
                                                        $value->transactional_type == 'App\Models\ExternalTransaction' ||
                                                            $value->transactional_type == 'App\Models\TransactionWithCurrency')
                                                        {{ 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($value->transactional_type == 'App\Models\Purchase' || $value->transactional_type == 'App\Models\Sale')
                                                        {{ optional(optional($value->transactional)->buyer)->fname . ' ' . optional(optional($value->transactional)->buyer)->lname ?? 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\DirectPurchase')
                                                        {{ optional(optional($value->transactional)->fund)->name ?? 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\ReceiptVoucher')
                                                        {{ 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\PaymentVoucher')
                                                        {{ optional($value->transactional)->customar_name ?? 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\UpdateUsersBalance')
                                                        @if (optional($value->transactional)->type == 'add')
                                                            {{ optional(optional($value->transactional)->user)->fname . ' ' . optional(optional($value->transactional)->user)->lname ?? 'N/A' }}
                                                        @elseif(optional($value->transactional)->type == 'minus')
                                                            {{ 'N/A' }}
                                                        @endif
                                                    @elseif($value->transactional_type == 'App\Models\FundsTransaction')
                                                        @if (optional($value->transactional)->type == 'add balance')
                                                            {{ optional(optional($value->transactional)->fund)->name ?? 'N/A' }}
                                                        @elseif(optional($value->transactional)->type == 'subtract balance')
                                                            {{ 'N/A' }}
                                                        @endif
                                                    @elseif($value->transactional_type == 'App\Models\ExternalTransaction')
                                                        {{ optional($value->transactional)->customar_name }}
                                                    @elseif($value->transactional_type == 'App\Models\TransactionWithCurrency')
                                                        {{ 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (
                                                        $value->transactional_type == 'App\Models\Purchase' ||
                                                            $value->transactional_type == 'App\Models\Sale' ||
                                                            $value->transactional_type == 'App\Models\DirectPurchase')
                                                        {{ optional($value->transactional)->item_name ?? 'N/A' }}
                                                    @elseif(
                                                        $value->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                            $value->transactional_type == 'App\Models\PaymentVoucher')
                                                        سند
                                                    @elseif(
                                                        $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
                                                            $value->transactional_type == 'App\Models\FundsTransaction' ||
                                                            $value->transactional_type == 'App\Models\ExternalTransaction')
                                                        {{ 'N/A' }}
                                                    @elseif($value->transactional_type == 'App\Models\TransactionWithCurrency')
                                                        {{ 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (
                                                        $value->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                            $value->transactional_type == 'App\Models\PaymentVoucher')
                                                        {{ number_format($value->amount, 2) . ' ' . optional(optional($value->transactional)->currency)->code }}
                                                    @else
                                                        {{ number_format($value->amount, 2) . ' ' . $general->site_currency }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($value->charge, 2) . ' ' . $general->site_currency }}
                                                </td>
                                                <td>
                                                    @if ($value->transactional_type == 'App\Models\ExternalTransaction')
                                                        {{ optional($value->transactional)->details ?? 'N/A' }}
                                                    @else
                                                        {{ optional($value->transactional)->note ?? 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (
                                                        $value->transactional_type == 'App\Models\Purchase' ||
                                                            $value->transactional_type == 'App\Models\Sale' ||
                                                            $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
                                                            $value->transactional_type == 'App\Models\FundsTransaction' ||
                                                            $value->transactional_type == 'App\Models\ExternalTransaction' ||
                                                            $value->transactional_type == 'App\Models\TransactionWithCurrency' ||
                                                            $value->transactional_type == 'App\Models\DirectPurchase')
                                                        {{ optional($value->transactional)->utr ?? 'N/A' }}
                                                    @elseif(
                                                        $value->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                            $value->transactional_type == 'App\Models\PaymentVoucher')
                                                        {{ optional($value->transactional)->receipt_num ?? 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>{{ $value->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="100%">
                                                    لم يتم العثور علي اي معاملات
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($transactions->hasPages())
                            <div class="card-footer">
                                {{ $transactions->links('backend.partial.paginate') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('style')
    <style>
        .card .card-header .form-control {
            border-radius: 0;
        }

        .card .card-header .btn:not(.note-btn) {
            border-radius: 0;
        }
    </style>
@endpush
@push('script')
    <script>
        $(function() {
            'use strict'
            $('input[name="dates"]').daterangepicker();
        })
    </script>
@endpush
