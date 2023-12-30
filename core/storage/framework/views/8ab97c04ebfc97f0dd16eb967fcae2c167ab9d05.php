
<?php $__env->startSection('content'); ?>
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
                            <?php if(isset($dates[1])): ?>
                                <?php echo e($dates[0]->format('Y-m-d') . ' ' . 'الي' . ' ' . $dates[1]->format('Y-m-d')); ?><br>
                            <?php endif; ?>
                            <?php echo e('الأرباح ' . number_format($totalCharge, 2) . ' ' . $general->site_currency); ?>

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
                                        <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($key + $transactions->firstItem()); ?></td>
                                                <td>
                                                    <?php if($value->transactional_type == 'App\Models\Purchase'): ?>
                                                        <a href="<?php echo e(checkPermission(18) ? route('admin.purchase.index', ['utr' => $value->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            شراء من وسيط الي عميل
                                                        </a>
                                                    <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                                                        <a href="<?php echo e(checkPermission(22) ? route('admin.sales.index', ['utr' => $value->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            بيع مباشر
                                                        </a>
                                                    <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                                        <a href="<?php echo e(checkPermission(73) ? route('admin.direct.purchase.index', ['utr' => $value->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            شراء مباشر
                                                        </a>
                                                    <?php elseif($value->transactional_type == 'App\Models\ReceiptVoucher'): ?>
                                                        <a href="<?php echo e(checkPermission(25) ? route('admin.receipt.vouchers.index', ['receipt_number' => $value->transactional->receipt_num]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            سند قبض
                                                        </a>
                                                    <?php elseif($value->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                                        <a href="<?php echo e(checkPermission(29) ? route('admin.payment.vouchers.index', ['receipt_number' => $value->transactional->receipt_num]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            سند صرف
                                                        </a>
                                                    <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                                        <a href="<?php echo e(checkPermission(58) ? route('admin.deposits.withdraws.index', ['utr' => $value->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            <?php if(optional($value->transactional)->type == 'add'): ?>
                                                                إيداع إداري الي مستخدم
                                                            <?php elseif(optional($value->transactional)->type == 'minus'): ?>
                                                                سحب إداري من مستخدم
                                                            <?php endif; ?>
                                                        </a>
                                                    <?php elseif($value->transactional_type == 'App\Models\TransactionWithCurrency'): ?>
                                                        <a href="<?php echo e(checkPermission(69) ? route('admin.trans.with.currency.index', ['utr' => $value->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            <?php if(optional($value->transactional)->trans_type == '1'): ?>
                                                                معاملة شراء بعملات متعددة
                                                            <?php elseif(optional($value->transactional)->trans_type == '2'): ?>
                                                                معاملة بيع بعملات متعددة
                                                            <?php endif; ?>
                                                        </a>
                                                    <?php elseif($value->transactional_type == 'App\Models\FundsTransaction'): ?>
                                                        <a href="<?php echo e(checkPermission(38) ? route('admin.funds.transactions', ['utr' => $value->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            <?php if(optional($value->transactional)->type == 'add balance'): ?>
                                                                إيداع رصيد الي صندوق
                                                            <?php elseif(optional($value->transactional)->type == 'subtract balance'): ?>
                                                                سحب رصيد من صندوق
                                                            <?php endif; ?>
                                                        </a>
                                                    <?php elseif($value->transactional_type == 'App\Models\ExternalTransaction'): ?>
                                                        <a href="<?php echo e(checkPermission(54) ? route('admin.external.transactions.index', ['utr' => $value->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            معاملة خارجية
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($value->transactional_type == 'App\Models\Purchase'): ?>
                                                        <?php echo e(optional(optional($value->transactional)->seller)->fname . ' ' . optional(optional($value->transactional)->seller)->lname ?? 'N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                                                        <?php echo e(optional(optional($value->transactional)->fund)->name ?? 'N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                                        <?php if($value->transactional->seller): ?>
                                                            <?php echo e(optional(optional($value->transactional)->seller)->fullname ?? 'N/A'); ?>

                                                        <?php else: ?>
                                                            <?php echo e($value->transactional->seller_on_way_name . ' (ONWAY)'); ?>

                                                        <?php endif; ?>
                                                    <?php elseif($value->transactional_type == 'App\Models\ReceiptVoucher'): ?>
                                                        <?php echo e(optional($value->transactional)->customar_name ?? 'N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                                        <?php echo e('N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                                        <?php if(optional($value->transactional)->type == 'add'): ?>
                                                            <?php echo e('N/A'); ?>

                                                        <?php elseif(optional($value->transactional)->type == 'minus'): ?>
                                                            <?php echo e(optional(optional($value->transactional)->user)->fname . ' ' . optional(optional($value->transactional)->user)->lname ?? 'N/A'); ?>

                                                        <?php endif; ?>
                                                    <?php elseif($value->transactional_type == 'App\Models\FundsTransaction'): ?>
                                                        <?php if(optional($value->transactional)->type == 'add balance'): ?>
                                                            <?php echo e('N/A'); ?>

                                                        <?php elseif(optional($value->transactional)->type == 'subtract balance'): ?>
                                                            <?php echo e(optional(optional($value->transactional)->fund)->name ?? 'N/A'); ?>

                                                        <?php endif; ?>
                                                    <?php elseif(
                                                        $value->transactional_type == 'App\Models\ExternalTransaction' ||
                                                            $value->transactional_type == 'App\Models\TransactionWithCurrency'): ?>
                                                        <?php echo e('N/A'); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($value->transactional_type == 'App\Models\Purchase' || $value->transactional_type == 'App\Models\Sale'): ?>
                                                        <?php echo e(optional(optional($value->transactional)->buyer)->fname . ' ' . optional(optional($value->transactional)->buyer)->lname ?? 'N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                                        <?php echo e(optional(optional($value->transactional)->fund)->name ?? 'N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\ReceiptVoucher'): ?>
                                                        <?php echo e('N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                                        <?php echo e(optional($value->transactional)->customar_name ?? 'N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                                        <?php if(optional($value->transactional)->type == 'add'): ?>
                                                            <?php echo e(optional(optional($value->transactional)->user)->fname . ' ' . optional(optional($value->transactional)->user)->lname ?? 'N/A'); ?>

                                                        <?php elseif(optional($value->transactional)->type == 'minus'): ?>
                                                            <?php echo e('N/A'); ?>

                                                        <?php endif; ?>
                                                    <?php elseif($value->transactional_type == 'App\Models\FundsTransaction'): ?>
                                                        <?php if(optional($value->transactional)->type == 'add balance'): ?>
                                                            <?php echo e(optional(optional($value->transactional)->fund)->name ?? 'N/A'); ?>

                                                        <?php elseif(optional($value->transactional)->type == 'subtract balance'): ?>
                                                            <?php echo e('N/A'); ?>

                                                        <?php endif; ?>
                                                    <?php elseif($value->transactional_type == 'App\Models\ExternalTransaction'): ?>
                                                        <?php echo e(optional($value->transactional)->customar_name); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\TransactionWithCurrency'): ?>
                                                        <?php echo e('N/A'); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if(
                                                        $value->transactional_type == 'App\Models\Purchase' ||
                                                            $value->transactional_type == 'App\Models\Sale' ||
                                                            $value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                                        <?php echo e(optional($value->transactional)->item_name ?? 'N/A'); ?>

                                                    <?php elseif(
                                                        $value->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                            $value->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                                        سند
                                                    <?php elseif(
                                                        $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
                                                            $value->transactional_type == 'App\Models\FundsTransaction' ||
                                                            $value->transactional_type == 'App\Models\ExternalTransaction'): ?>
                                                        <?php echo e('N/A'); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\TransactionWithCurrency'): ?>
                                                        <?php echo e('N/A'); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if(
                                                        $value->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                            $value->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                                        <?php echo e(number_format($value->amount, 2) . ' ' . optional(optional($value->transactional)->currency)->code); ?>

                                                    <?php else: ?>
                                                        <?php echo e(number_format($value->amount, 2) . ' ' . $general->site_currency); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo e(number_format($value->charge, 2) . ' ' . $general->site_currency); ?>

                                                </td>
                                                <td>
                                                    <?php if($value->transactional_type == 'App\Models\ExternalTransaction'): ?>
                                                        <?php echo e(optional($value->transactional)->details ?? 'N/A'); ?>

                                                    <?php else: ?>
                                                        <?php echo e(optional($value->transactional)->note ?? 'N/A'); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if(
                                                        $value->transactional_type == 'App\Models\Purchase' ||
                                                            $value->transactional_type == 'App\Models\Sale' ||
                                                            $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
                                                            $value->transactional_type == 'App\Models\FundsTransaction' ||
                                                            $value->transactional_type == 'App\Models\ExternalTransaction' ||
                                                            $value->transactional_type == 'App\Models\TransactionWithCurrency' ||
                                                            $value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                                        <?php echo e(optional($value->transactional)->utr ?? 'N/A'); ?>

                                                    <?php elseif(
                                                        $value->transactional_type == 'App\Models\ReceiptVoucher' ||
                                                            $value->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                                        <?php echo e(optional($value->transactional)->receipt_num ?? 'N/A'); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($value->created_at->format('Y-m-d')); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td class="text-center" colspan="100%">
                                                    لم يتم العثور علي اي معاملات
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if($transactions->hasPages()): ?>
                            <div class="card-footer">
                                <?php echo e($transactions->links('backend.partial.paginate')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <style>
        .card .card-header .form-control {
            border-radius: 0;
        }

        .card .card-header .btn:not(.note-btn) {
            border-radius: 0;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        $(function() {
            'use strict'
            $('input[name="dates"]').daterangepicker();
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/backend/transaction.blade.php ENDPATH**/ ?>