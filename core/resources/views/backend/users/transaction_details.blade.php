<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>تفاصيل المعاملة</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ getFile('icon', $general->favicon, true) }}">
</head>

<body style="background-color: #efefef;">
    <div class="main-content" style="width: 95%; margin: auto">
        <section class="section">
            <div class="section-header pb-4 pt-2 text-center">
                <h1>{{ 'تفاصيل المعاملة رقم' . ' ' . $transaction->transactional->utr }}</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-container mx-3">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr class="text-center">
                                    <th>نوع المعاملة</th>
                                    <th>من (التاجر او الصندوق)</th>
                                    <th>الي (العميل او الصندوق)</th>
                                    <th>العنصر</th>
                                    <th>المبلغ</th>
                                    <th>الرسوم</th>
                                    <th>ملاحظة</th>
                                    <th>رقم المعاملة</th>
                                    <th>في</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>
                                        @if ($transaction->transactional_type == 'App\Models\Purchase')
                                            شراء من وسيط الي عميل
                                        @elseif($transaction->transactional_type == 'App\Models\Sale')
                                            بيع مباشر
                                        @elseif($transaction->transactional_type == 'App\Models\DirectPurchase')
                                            شراء مباشر
                                        @elseif($transaction->transactional_type == 'App\Models\ReceiptVoucher')
                                            سند قبض
                                        @elseif($transaction->transactional_type == 'App\Models\PaymentVoucher')
                                            سند صرف
                                        @elseif($transaction->transactional_type == 'App\Models\UpdateUsersBalance')
                                            @if (optional($transaction->transactional)->type == 'add')
                                                إيداع إداري الي مستخدم
                                            @elseif(optional($transaction->transactional)->type == 'minus')
                                                سحب إداري من مستخدم
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->transactional_type == 'App\Models\Purchase')
                                            {{ optional(optional($transaction->transactional)->seller)->fname . ' ' . optional(optional($transaction->transactional)->seller)->lname ?? 'N/A' }}
                                        @elseif($transaction->transactional_type == 'App\Models\Sale')
                                            {{ optional(optional($transaction->transactional)->fund)->name ?? 'N/A' }}
                                        @elseif($transaction->transactional_type == 'App\Models\DirectPurchase')
                                            @if ($transaction->transactional->seller)
                                                {{ optional(optional($transaction->transactional)->seller)->fullname ?? 'N/A' }}
                                            @else
                                                {{ $transaction->transactional->seller_on_way_name . ' (ONWAY)' }}
                                            @endif
                                        @elseif($transaction->transactional_type == 'App\Models\ReceiptVoucher')
                                            {{ optional($transaction->transactional)->customar_name ?? 'N/A' }}
                                        @elseif($transaction->transactional_type == 'App\Models\PaymentVoucher')
                                            {{ 'N/A' }}
                                        @elseif($transaction->transactional_type == 'App\Models\UpdateUsersBalance')
                                            @if (optional($transaction->transactional)->type == 'add')
                                                {{ 'N/A' }}
                                            @elseif(optional($transaction->transactional)->type == 'minus')
                                                {{ optional(optional($transaction->transactional)->user)->fname . ' ' . optional(optional($transaction->transactional)->user)->lname ?? 'N/A' }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->transactional_type == 'App\Models\Purchase' || $transaction->transactional_type == 'App\Models\Sale')
                                            {{ optional(optional($transaction->transactional)->buyer)->fname . ' ' . optional(optional($transaction->transactional)->buyer)->lname ?? 'N/A' }}
                                        @elseif($transaction->transactional_type == 'App\Models\DirectPurchase')
                                            {{ optional(optional($transaction->transactional)->fund)->name ?? 'N/A' }}
                                        @elseif($transaction->transactional_type == 'App\Models\ReceiptVoucher')
                                            {{ 'N/A' }}
                                        @elseif($transaction->transactional_type == 'App\Models\PaymentVoucher')
                                            {{ optional($transaction->transactional)->customar_name ?? 'N/A' }}
                                        @elseif($transaction->transactional_type == 'App\Models\UpdateUsersBalance')
                                            @if (optional($transaction->transactional)->type == 'add')
                                                {{ optional(optional($transaction->transactional)->user)->fname . ' ' . optional(optional($transaction->transactional)->user)->lname ?? 'N/A' }}
                                            @elseif(optional($transaction->transactional)->type == 'minus')
                                                {{ 'N/A' }}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->transactional_type == 'App\Models\Purchase' || $transaction->transactional_type == 'App\Models\Sale'
                                        || $transaction->transactional_type == 'App\Models\DirectPurchase')
                                            {{ optional($transaction->transactional)->item_name ?? 'N/A' }}
                                        @elseif(
                                            $transaction->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                $transaction->transactional_type == 'App\Models\PaymentVoucher')
                                            سند
                                        @elseif($transaction->transactional_type == 'App\Models\UpdateUsersBalance')
                                            {{ 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ number_format($transaction->amount, 2) . ' ' . $general->site_currency }}
                                    </td>
                                    <td>
                                        {{ number_format($transaction->charge, 2) . ' ' . $general->site_currency }}
                                    </td>
                                    <td>
                                        {{ $transaction->transactional->note ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @if (
                                            $transaction->transactional_type == 'App\Models\Purchase' ||
                                                $transaction->transactional_type == 'App\Models\Sale' ||
                                                $transaction->transactional_type == 'App\Models\UpdateUsersBalance'
                                                || $transaction->transactional_type == 'App\Models\DirectPurchase')
                                            {{ optional($transaction->transactional)->utr ?? 'N/A' }}
                                        @elseif(
                                            $transaction->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                $transaction->transactional_type == 'App\Models\PaymentVoucher')
                                            {{ optional($transaction->transactional)->receipt_num ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
