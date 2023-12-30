
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><?php echo e($user->fullname . ' ' . 'كشف حساب'); ?></h1>
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
                            <?php if($pass_dates): ?>
                                <div>
                                    <h5><?php echo e($pass_dates); ?></h5>
                                </div>
                            <?php endif; ?>
                            <h4>
                                <a href="<?php echo e(route('admin.account.statement.pdf', ['user' => $user, 'dates' => str_replace('/', '+', $pass_dates)])); ?>"
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
                                        <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($key + $transactions->firstItem()); ?></td>
                                                <td>
                                                    <?php if($value->transactional_type == 'App\Models\Purchase'): ?>
                                                        شراء من وسيط الي عميل
                                                    <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                                                        بيع مباشر
                                                    <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                                        شراء مباشر
                                                    <?php elseif($value->transactional_type == 'App\Models\ReceiptVoucher'): ?>
                                                        سند قبض
                                                    <?php elseif($value->transactional_type == 'App\Models\PaymentVoucher'): ?>
                                                        سند صرف
                                                    <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                                        <?php if(optional($value->transactional)->type == 'add'): ?>
                                                            إيداع رصيد
                                                        <?php elseif(optional($value->transactional)->type == 'minus'): ?>
                                                            سحب رصيد
                                                        <?php endif; ?>
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
                                                        <?php echo e(__('Voucher')); ?>

                                                    <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                                        <?php echo e('N/A'); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo e(number_format($value->amount, 2) . ' ' . $general->site_currency); ?>

                                                </td>
                                                <td>
                                                    <?php echo e(number_format($value->charge, 2) . ' ' . $general->site_currency); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($value->transactional->note ?? 'N/A'); ?>

                                                </td>
                                                <td>
                                                    <?php if(
                                                        $value->transactional_type == 'App\Models\Purchase' ||
                                                            $value->transactional_type == 'App\Models\Sale' ||
                                                            $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
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

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/backend/users/account_statement.blade.php ENDPATH**/ ?>