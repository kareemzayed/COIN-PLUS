
<?php $__env->startSection('content2'); ?>
    <div class="dashboard-body-part">
        <div class="card">
            <div class="card-header">
                <div class="col-xxl-12">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control w-md-auto w-100" placeholder="رقم المعاملة"
                                name="utr" style="border-radius: 0 12px 12px 0">
                            <input type="date" class="form-control w-md-auto w-100 mt-md-0 mt-3" name="date">
                            <select name="transactional_type" class="select w-md-auto w-100">
                                <option disabled value="" selected>نوع المعاملة</option>
                                <option value="App\Models\Purchase">معاملة مع تاجر</option>
                                <option value="App\Models\Sale">بيع مباشر</option>
                                <option value="App\Models\UpdateUsersBalance">إيداع أو سحب إداري</option>
                            </select>
                            <button type="submit" class="btn main-btn w-md-auto w-100 mt-md-0 mt-3"
                                style="border-radius: 12px 0 0 12px; z-index: 1"> <i class="fa fa-search"></i> بحث</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table site-table text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم المعاملة</th>
                                <th>العنصر</th>
                                <th>نوع المعاملة</th>
                                <th>تاريخ المعاملة</th>
                                <th>إيداع</th>
                                <th>سحب</th>
                                <th>الرصيد</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($key + $transactions->firstItem()); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.transaction.details', $value->id)); ?>"
                                            style="text-decoration: none; color: #ffffff" target="_blank">
                                            <?php if(
                                                $value->transactional_type == 'App\Models\Purchase' ||
                                                    $value->transactional_type == 'App\Models\Sale' ||
                                                    $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
                                                    $value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                                <?php echo e(optional($value->transactional)->utr ?? 'N/A'); ?>

                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if(
                                            $value->transactional_type == 'App\Models\Purchase' ||
                                                $value->transactional_type == 'App\Models\Sale' ||
                                                $value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                            <?php echo e(optional($value->transactional)->item_name ?? 'N/A'); ?>

                                        <?php elseif(
                                            $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
                                                $value->transactional_type == 'App\Models\FundsTransaction' ||
                                                $value->transactional_type == 'App\Models\ExternalTransaction'): ?>
                                            <?php echo e('N/A'); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($value->transactional_type == 'App\Models\Purchase' && $value->transactional->buyer == auth()->user()): ?>
                                            شراء من تاجر
                                        <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->seller == auth()->user()): ?>
                                            بيع الي تاجر
                                        <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                                            بيع مباشر الي عميل
                                        <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                            شراء مباشر
                                        <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                            <?php if(optional($value->transactional)->type == 'add'): ?>
                                                إيداع إداري
                                            <?php elseif(optional($value->transactional)->type == 'minus'): ?>
                                                سحب إداري
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($value->created_at->format('Y-m-d')); ?></td>

                                    <?php if($value->transactional_type == 'App\Models\UpdateUsersBalance' && $value->transactional->type == 'add'): ?>
                                        <td class="trans-amount text-success"><?php echo e(number_format($value->amount, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                        <td></td>
                                    <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance' && $value->transactional->type == 'minus'): ?>
                                        <td></td>
                                        <td class="trans-amount text-danger"><?php echo e(number_format($value->amount, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                    <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->buyer == auth()->user()): ?>
                                        <td></td>
                                        <td class="trans-amount text-danger">
                                            <?php echo e(number_format($value->transactional->sales_cost, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                    <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->seller == auth()->user()): ?>
                                        <td class="trans-amount text-success">
                                            <?php echo e(number_format($value->transactional->purchase_cost, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                        <td></td>
                                    <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                                        <td></td>
                                        <td class="trans-amount text-danger">
                                            <?php echo e(number_format($value->transactional->sales_cost, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                    <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                        <td class="trans-amount text-success">
                                            <?php echo e(number_format($value->transactional->purchase_cost, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                        <td></td>
                                    <?php endif; ?>

                                    <?php if($value->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                                        <td><?php echo e(number_format($value->transactional->floating_balance, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                    <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->buyer == auth()->user()): ?>
                                        <td><?php echo e(number_format($value->transactional->buyer_floating_balance, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                    <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->seller == auth()->user()): ?>
                                        <td><?php echo e(number_format($value->transactional->seller_floating_balance, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                    <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                                        <td><?php echo e(number_format($value->transactional->buyer_floating_balance, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                    <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                                        <td><?php echo e(number_format($value->transactional->seller_floating_balance, 2)); ?>

                                            <?php echo e($general->site_currency); ?></td>
                                    <?php endif; ?>
                                    <td class="text-center">
                                        <?php if($value->report && optional($value->report)->replied == 0): ?>
                                            <span class="text-success" style="font-size: 11px">تم تقديم شكوي</span>
                                        <?php elseif($value->report && optional($value->report)->replied == 1): ?>
                                            <span class="text-success" style="font-size: 10px;">
                                                <button data-transaction = "<?php echo e($value); ?>"
                                                    class="view-btn-success reply-modal"
                                                    title="تم الرد علي الشكوي, اضغط هنا لرؤية رد الأدارة">رد الأدارة علي
                                                    الشكوي</button>
                                            </span>
                                        <?php else: ?>
                                            <button data-route="<?php echo e(route('user.report.transaction', $value->id)); ?>"
                                                data-transaction = "<?php echo e($value); ?>"
                                                class="view-btn view-btn-danger report-modal"
                                                title="الإبلاغ عن هذه المعاملة">
                                                <i class="fas fa-exclamation-circle"></i>
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td class="text-center" colspan="100%">
                                        لم يتم العثور على بيانات
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php if($transactions->hasPages()): ?>
                        <?php echo e($transactions->links()); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="report_model" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" enctype="multipart/form-data" method="post">
                <?php echo csrf_field(); ?>

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white"></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="row align-items-center mt-2">
                                <div class="col-lg-12">
                                    <p class="mb-2 text-danger">اذا كان لديك سجل معاملة غير صحيح, يمكنك التبليغ عن المعاملة
                                        هنا للأدارة لمراجعتها</p>
                                    <div class="form-group ticket-comment-box">
                                        <label for="exampleFormControlTextarea1">سبب الإبلاغ</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" cols="30" name="reason"
                                            placeholder="سبب الإبلاغ" required><?php echo e(old('reason')); ?></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-sm main-btn">إبلاغ</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade " id="reply_model" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="post">
                <?php echo csrf_field(); ?>

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white"></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="row align-items-center mt-2">
                                <div class="col-lg-12">
                                    <p class="mb-2 text-danger modal_discribtion"></p>
                                    <div class="form-group ticket-comment-box">
                                        <label for="exampleFormControlTextarea1">رد الأدارة</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" cols="30" name="admin_reply"
                                            readonly disabled></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <p class="mb-2 text-danger modal_discribtion"></p>
                                    <div class="form-group ticket-comment-box">
                                        <label>المبلغ قبل التعديل</label>
                                        <input class="form-control" name="amount_before" readonly disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <p class="mb-2 text-danger modal_discribtion"></p>
                                    <div class="form-group ticket-comment-box">
                                        <label>المبلغ بعد التعديل</label>
                                        <input class="form-control" name="amount_after" readonly disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        $('.report-modal').on('click', function(e) {
            e.preventDefault();
            const modal = $('#report_model');
            modal.find('.modal-title').text("إبلاغ عن المعاملة رقم " + ($(this).data(
                'transaction').transactional.utr || ''));
            modal.find('.transaction_utr_clas').val($(this).data('transaction').transactional.utr);
            modal.find('form').attr('action', $(this).data('route'));
            modal.find('textarea[name=reason]').val('')
            modal.modal('show');
        })

        $('.reply-modal').on('click', function(e) {
            e.preventDefault();
            const modal = $('#reply_model');
            modal.find('.modal-title').text("رد الأدارة علي شكوتك بخصوص المعاملة رقم" + " " + ($(this).data(
                'transaction').transactional.utr || ''));
            modal.find('form').attr('action', '#');
            modal.find('textarea[name=admin_reply]').val($(this).data(
                'transaction').report.admin_reply)
            modal.find('input[name=amount_before]').val(formatDecimalAmount($(this).data(
                'transaction').report.amount_before, 2) + " " + "<?php echo e($general->site_currency); ?>")
            modal.find('input[name=amount_after]').val(formatDecimalAmount($(this).data(
                'transaction').report.amount_after, 2) + " " + "<?php echo e($general->site_currency); ?>")
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make(template() . 'layout.master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/theme2/user/transaction.blade.php ENDPATH**/ ?>