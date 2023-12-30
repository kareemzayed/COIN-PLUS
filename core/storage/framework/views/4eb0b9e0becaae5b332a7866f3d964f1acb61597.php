

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>قائمة التذاكر</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-form">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" name="support_id" class="form-control"
                                            placeholder="رقم الدعم"
                                            value="<?php echo e(isset($search['support_id']) ? $search['support_id'] : ''); ?>">
                                        <select class="form-control" name="status">
                                            <option selected value="" disabled>حالة التذكرة</option>
                                            <option value="2"
                                                <?php echo e(isset($search['status']) && $search['status'] == '2' ? 'selected' : ''); ?>>
                                                قيد الأنتظار
                                            </option>
                                            <option value="1"
                                                <?php echo e(isset($search['status']) && $search['status'] == '1' ? 'selected' : ''); ?>>
                                                مغلقة
                                            </option>
                                            <option value="3"
                                                <?php echo e(isset($search['status']) && $search['status'] == '3' ? 'selected' : ''); ?>>
                                                تم الرد
                                            </option>
                                        </select>
                                        <input type="date" name="date" class="form-control" placeholder="تاريخ التذكرة"
                                            value="<?php echo e(isset($search['date']) ? $search['support_id'] : ''); ?>">
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
                                            <th>رقم الدعم</th>
                                            <th>العميل</th>
                                            <th>الموضوع</th>
                                            <th>حالة التذكرة</th>
                                            <th>تم الأنشاء في</th>
                                            <th>إجراء</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td scope="row"><b><?php echo e($ticket->support_id); ?></b></td>
                                                <td><?php echo e($ticket->user->fullname); ?></td>
                                                <td><?php echo e($ticket->subject); ?></td>
                                                <td>
                                                    <?php if($ticket->status == 1): ?>
                                                        <span class="badge badge-danger"> مغلقة </span>
                                                    <?php endif; ?>
                                                    <?php if($ticket->status == 2): ?>
                                                        <span class="badge badge-warning"> قيد الأنتظار </span>
                                                    <?php endif; ?>
                                                    <?php if($ticket->status == 3): ?>
                                                        <span class="badge badge-success"> تم الرد </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td><?php echo e($ticket->created_at); ?></td>
                                                <td>
                                                    <?php if(checkPermission(9)): ?>
                                                        <a class="btn btn-md btn-primary btn-action"
                                                            href="<?php echo e(route('admin.ticket.show', $ticket->id)); ?>">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if(checkPermission(10)): ?>
                                                        <button
                                                            data-href="<?php echo e(route('admin.ticket.destroy', $ticket->id)); ?>"
                                                            class="btn btn-md btn-danger delete_confirm">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">لم يتم العثور علي اي تذاكر</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php if($tickets->hasPages()): ?>
                            <div class="card-footer">
                                <?php echo e($tickets->links('backend.partial.paginate')); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Start:: Delete Modal-->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo e(method_field('DELETE')); ?>


                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row col-md-12">
                            <p>هل انت متأكد من حذف هذه التذكرة ؟</p>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-danger" type="submit">حذف</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End:: Delete Modal-->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        'use strict'
        $('.delete_confirm').on('click', function() {
            const modal = $('#delete_modal')
            modal.find('form').attr('action', $(this).data('href'))
            modal.modal('show');
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/ticket/list.blade.php ENDPATH**/ ?>