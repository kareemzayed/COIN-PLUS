@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $user->fullname . ' ' . 'كشف حساب' }}</h1>
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
                            @if ($pass_dates)
                                <div>
                                    <h5>{{ $pass_dates }}</h5>
                                </div>
                            @endif
                            <h4>
                                <a href="{{ route('admin.account.statement.pdf', ['user' => $user, 'dates' => str_replace('/', '+', $pass_dates)]) }}"
                                    class="btn btn-danger text-white" target="_blank">
                                    <i class="fa fa-print"></i> تصدير الي ملف PDF
                                </a>
                            </h4>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>نوع المعاملة</th>
                                            <th>من (التاجر او الصندوق)</th>
                                            <th>الي (العميل او الصندوق)</th>
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
                                                        شراء من وسيط الي عميل
                                                    @elseif($value->transactional_type == 'App\Models\Sale')
                                                        بيع مباشر
                                                    @elseif($value->transactional_type == 'App\Models\DirectPurchase')
                                                        شراء مباشر
                                                    @elseif($value->transactional_type == 'App\Models\ReceiptVoucher')
                                                        سند قبض
                                                    @elseif($value->transactional_type == 'App\Models\PaymentVoucher')
                                                        سند صرف
                                                    @elseif($value->transactional_type == 'App\Models\UpdateUsersBalance')
                                                        @if (optional($value->transactional)->type == 'add')
                                                            إيداع رصيد
                                                        @elseif(optional($value->transactional)->type == 'minus')
                                                            سحب رصيد
                                                        @endif
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
                                                        {{ __('Voucher') }}
                                                    @elseif($value->transactional_type == 'App\Models\UpdateUsersBalance')
                                                        {{ 'N/A' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ number_format($value->amount, 2) . ' ' . $general->site_currency }}
                                                </td>
                                                <td>
                                                    {{ number_format($value->charge, 2) . ' ' . $general->site_currency }}
                                                </td>
                                                <td>
                                                    {{ $value->transactional->note ?? 'N/A' }}
                                                </td>
                                                <td>
                                                    @if (
                                                        $value->transactional_type == 'App\Models\Purchase' ||
                                                            $value->transactional_type == 'App\Models\Sale' ||
                                                            $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
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
