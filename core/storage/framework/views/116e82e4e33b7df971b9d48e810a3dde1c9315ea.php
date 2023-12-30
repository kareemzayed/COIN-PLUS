<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <title>تفاصيل المعاملة</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(getFile('icon', $general->favicon, true)); ?>">
</head>

<body style="background-color: #efefef;">
    <div class="main-content" style="width: 95%; margin: auto">
        <section class="section">
            <div class="section-header pb-4 pt-2 text-center">
                <h1><?php echo e('تفاصيل المعاملة رقم' . ' ' . $transaction->transactional->utr); ?></h1>
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
                                        <?php if($transaction->transactional_type == 'App\Models\Purchase'): ?>
                                            شراء من وسيط الي عميل
                                        <?php elseif($transaction->transactional_type == 'App\Models\Sale'): ?>
                                            بيع مباشر
                                        <?php elseif($transaction->transactional_type == 'App\Models\DirectPurchase'): ?>
                                            شراء مباشر
                                        <?php elseif($transaction->transactional_type == 'App\Models\ReceiptVoucher'): ?>
                                            سند قبض
                                        <?php elseif($transaction->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                            سند صرف
                                        <?php elseif($transaction->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                            <?php if(optional($transaction->transactional)->type == 'add'): ?>
                                                إيداع إداري الي مستخدم
                                            <?php elseif(optional($transaction->transactional)->type == 'minus'): ?>
                                                سحب إداري من مستخدم
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($transaction->transactional_type == 'App\Models\Purchase'): ?>
                                            <?php echo e(optional(optional($transaction->transactional)->seller)->fname . ' ' . optional(optional($transaction->transactional)->seller)->lname ?? 'N/A'); ?>

                                        <?php elseif($transaction->transactional_type == 'App\Models\Sale'): ?>
                                            <?php echo e(optional(optional($transaction->transactional)->fund)->name ?? 'N/A'); ?>

                                        <?php elseif($transaction->transactional_type == 'App\Models\DirectPurchase'): ?>
                                            <?php if($transaction->transactional->seller): ?>
                                                <?php echo e(optional(optional($transaction->transactional)->seller)->fullname ?? 'N/A'); ?>

                                            <?php else: ?>
                                                <?php echo e($transaction->transactional->seller_on_way_name . ' (ONWAY)'); ?>

                                            <?php endif; ?>
                                        <?php elseif($transaction->transactional_type == 'App\Models\ReceiptVoucher'): ?>
                                            <?php echo e(optional($transaction->transactional)->customar_name ?? 'N/A'); ?>

                                        <?php elseif($transaction->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                            <?php echo e('N/A'); ?>

                                        <?php elseif($transaction->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                            <?php if(optional($transaction->transactional)->type == 'add'): ?>
                                                <?php echo e('N/A'); ?>

                                            <?php elseif(optional($transaction->transactional)->type == 'minus'): ?>
                                                <?php echo e(optional(optional($transaction->transactional)->user)->fname . ' ' . optional(optional($transaction->transactional)->user)->lname ?? 'N/A'); ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($transaction->transactional_type == 'App\Models\Purchase' || $transaction->transactional_type == 'App\Models\Sale'): ?>
                                            <?php echo e(optional(optional($transaction->transactional)->buyer)->fname . ' ' . optional(optional($transaction->transactional)->buyer)->lname ?? 'N/A'); ?>

                                        <?php elseif($transaction->transactional_type == 'App\Models\DirectPurchase'): ?>
                                            <?php echo e(optional(optional($transaction->transactional)->fund)->name ?? 'N/A'); ?>

                                        <?php elseif($transaction->transactional_type == 'App\Models\ReceiptVoucher'): ?>
                                            <?php echo e('N/A'); ?>

                                        <?php elseif($transaction->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                            <?php echo e(optional($transaction->transactional)->customar_name ?? 'N/A'); ?>

                                        <?php elseif($transaction->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                            <?php if(optional($transaction->transactional)->type == 'add'): ?>
                                                <?php echo e(optional(optional($transaction->transactional)->user)->fname . ' ' . optional(optional($transaction->transactional)->user)->lname ?? 'N/A'); ?>

                                            <?php elseif(optional($transaction->transactional)->type == 'minus'): ?>
                                                <?php echo e('N/A'); ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($transaction->transactional_type == 'App\Models\Purchase' || $transaction->transactional_type == 'App\Models\Sale'
                                        || $transaction->transactional_type == 'App\Models\DirectPurchase'): ?>
                                            <?php echo e(optional($transaction->transactional)->item_name ?? 'N/A'); ?>

                                        <?php elseif(
                                            $transaction->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                $transaction->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                            سند
                                        <?php elseif($transaction->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                            <?php echo e('N/A'); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e(number_format($transaction->amount, 2) . ' ' . $general->site_currency); ?>

                                    </td>
                                    <td>
                                        <?php echo e(number_format($transaction->charge, 2) . ' ' . $general->site_currency); ?>

                                    </td>
                                    <td>
                                        <?php echo e($transaction->transactional->note ?? 'N/A'); ?>

                                    </td>
                                    <td>
                                        <?php if(
                                            $transaction->transactional_type == 'App\Models\Purchase' ||
                                                $transaction->transactional_type == 'App\Models\Sale' ||
                                                $transaction->transactional_type == 'App\Models\UpdateUsersBalance'
                                                || $transaction->transactional_type == 'App\Models\DirectPurchase'): ?>
                                            <?php echo e(optional($transaction->transactional)->utr ?? 'N/A'); ?>

                                        <?php elseif(
                                            $transaction->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                $transaction->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                            <?php echo e(optional($transaction->transactional)->receipt_num ?? 'N/A'); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($transaction->created_at->format('Y-m-d')); ?></td>
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
<?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/backend/users/transaction_details.blade.php ENDPATH**/ ?>