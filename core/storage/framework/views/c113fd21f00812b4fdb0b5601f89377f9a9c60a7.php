
<?php $__env->startSection('content'); ?>
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
                        <form method="GET" action="<?php echo e(route('admin.deposits.withdraws.search')); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم المعاملة" name="utr"
                                    value="<?php echo e(isset($search['utr']) ? $search['utr'] : ''); ?>">
                                <input type="date" class="form-control" placeholder="تاريخ المعاملة" name="date"
                                    value="<?php echo e(isset($search['date']) ? $search['date'] : ''); ?>">
                                <select name="type" class="form-select form-control">
                                    <option disabled selected value="">نوع المعاملة</option>
                                    <option value="minus"
                                        <?php echo e(isset($search['type']) && $search['type'] == 'minus' ? 'selected' : ''); ?>>سحب
                                        إداري</option>
                                    <option value="add"
                                        <?php echo e(isset($search['type']) && $search['type'] == 'add' ? 'selected' : ''); ?>>إيداع
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
                                <?php $__empty_1 = true; $__currentLoopData = $update_users_balance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + $update_users_balance->firstItem()); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.user.details', $value->user->id)); ?>"
                                                style="text-decoration: none; font-size: 14px">
                                                <?php echo e(optional($value->user)->fullname); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <?php if($value->type == 'minus'): ?>
                                                <span class="text-danger">سحب إداري</span>
                                            <?php elseif($value->type == 'add'): ?>
                                                <span class="text-success"> إيداع إداري</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e(number_format($value->amount, 2) . ' ' . $general->site_currency); ?>

                                        </td>
                                        <td>
                                            <?php echo e(number_format($value->floating_balance, 2) . ' ' . $general->site_currency); ?>

                                        </td>
                                        <td><?php echo e($value->note ?? 'N/A'); ?></td>
                                        <td><?php echo e($value->utr); ?></td>
                                        <td>
                                            <?php echo e($value->created_at->format('m/d/Y h:i A')); ?>

                                        </td>
                                        <td style="width:12%">
                                            <?php if(checkPermission(59)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.deposits.withdraws.update', $value->id)); ?>"
                                                    data-trans="<?php echo e($value); ?>" class="btn btn-md btn-info update"><i
                                                        class="fa fa-pen"></i></button>
                                            <?php endif; ?>

                                            <?php if(checkPermission(60)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.deposits.withdraws.delete', $value->id)); ?>"
                                                    data-trans="<?php echo e($value); ?>"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي معاملات إيداع او سحب
                                            إداري</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($update_users_balance->hasPages()): ?>
                        <div class="card-footer">
                            <?php echo e($update_users_balance->links('backend.partial.paginate')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Model -->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo e(method_field('DELETE')); ?>


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
                                <label for="amount">المبلغ <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
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
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/update_users_balance/index.blade.php ENDPATH**/ ?>