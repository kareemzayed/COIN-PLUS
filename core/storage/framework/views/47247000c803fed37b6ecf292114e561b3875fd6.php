
<?php $__env->startSection('content'); ?>
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
                                            value="<?php echo e(isset($search['utr']) ? $search['utr'] : ''); ?>">
                                        <input type="date" name="date" class="form-control" placeholder="تاريخ البلاغ"
                                            value="<?php echo e(isset($search['date']) ? $search['date'] : ''); ?>">
                                        <select class="form-control" name="status">
                                            <option disabled selected>حالة البلاغ</option>
                                            <option value="0"
                                                <?php echo e(isset($search['status']) && $search['status'] == '0' ? 'selected' : ''); ?>>
                                                قيد الأنتظار</option>
                                            <option value="1"
                                                <?php echo e(isset($search['status']) && $search['status'] == '1' ? 'selected' : ''); ?>>
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
                                        <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td scope="row"><b><?php echo e($report->utr); ?></b></td>
                                                <td><?php echo e($report->user->fullname); ?></td>
                                                <td><?php echo e($report->transaction->transactional->utr); ?></td>
                                                <td>
                                                    <?php if($report->transaction->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                                        <a href="<?php echo e(checkPermission(58) ? route('admin.deposits.withdraws.index', ['utr' => $report->transaction->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            <?php if($report->transaction->transactional->type == 'add'): ?>
                                                                إيداع إداري الي مستخدم
                                                            <?php elseif($report->transaction->transactional->type == 'minus'): ?>
                                                                سحب إداري من مستخدم
                                                            <?php endif; ?>
                                                        </a>
                                                    <?php elseif($report->transaction->transactional_type == 'App\Models\Purchase'): ?>
                                                        <a href="<?php echo e(checkPermission(18) ? route('admin.purchase.index', ['utr' => $report->transaction->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            شراء من وسيط الي عميل
                                                        </a>
                                                    <?php elseif($report->transaction->transactional_type == 'App\Models\Sale'): ?>
                                                        <a href="<?php echo e(checkPermission(22) ? route('admin.sales.index', ['utr' => $report->transaction->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            بيع مباشر الي عميل
                                                        </a>
                                                    <?php elseif($report->transaction->transactional_type == 'App\Models\DirectPurchase'): ?>
                                                        <a href="<?php echo e(checkPermission(73) ? route('admin.direct.purchase.index', ['utr' => $report->transaction->transactional->utr]) : '#'); ?>"
                                                            style="text-decoration: none; font-size: 14px">
                                                            شراء مباشر
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($report->reason ?? 'N/A'); ?></td>
                                                <td><?php echo e($report->admin_reply ?? 'N/A'); ?></td>
                                                <td>
                                                    <?php if($report->replied == 0): ?>
                                                        <span class="badge badge-warning"> قيد الأنتظار </span>
                                                    <?php endif; ?>
                                                    <?php if($report->replied == 1): ?>
                                                        <span class="badge badge-success"> تم الرد</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td><?php echo e($report->created_at->format('m/d/Y h:i A')); ?></td>
                                                <td>
                                                    <?php if(checkPermission(8)): ?>
                                                        <?php if($report->replied == 0): ?>
                                                            <button
                                                                data-href="<?php echo e(route('admin.transactions.reports.reply', $report->id)); ?>"
                                                                data-report="<?php echo e($report); ?>"
                                                                class="btn btn-md btn-info reply">
                                                                <i class="fas fa-reply"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">لم يتم العثور علي اي بلاغات</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if($reports->hasPages()): ?>
                            <div class="card-footer">
                                <?php echo e($reports->links('backend.partial.paginate')); ?>

                            </div>
                        <?php endif; ?>
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
                <?php echo csrf_field(); ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/backend/transaction_reports/index.blade.php ENDPATH**/ ?>