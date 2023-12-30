
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة الأدوار</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                            إنشاء دور جديد</button>
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="اسم الدور" name="name"
                                    value="<?php echo e(isset($search['name']) ? $search['name'] : ''); ?>">
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
                                    <th>اسم الدور</th>
                                    <th>حالة الدور</th>
                                    <th>تم الإنشاء في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + $roles->firstItem()); ?></td>
                                        <td><?php echo e($role->name); ?></td>
                                        <td>
                                            <?php if($role->status): ?>
                                                <div class="badge badge-success">نشط</div>
                                            <?php else: ?>
                                                <div class="badge badge-danger">غير نشط</div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($role->created_at->format('m/d/Y h:i A')); ?>

                                        </td>
                                        <td>
                                            <button data-href="<?php echo e(route('admin.role.update', $role->id)); ?>"
                                                data-role="<?php echo e($role); ?>" class="btn btn-md btn-primary update"><i
                                                    class="fa fa-pen"></i></button>

                                            <button data-href="<?php echo e(route('admin.role.delete', $role->id)); ?>"
                                                data-role="<?php echo e($role); ?>" class="btn btn-md btn-danger delete"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي ادوار</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div id="add-modal" class="modal fade" aria-labelledby="exampleModalLabel" tabindex="-1" role="dialog"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="">اسم الدور</label>
                            <input type="text" class="form-control" name="name" placeholder="اسم الدور" />
                        </div>
                        <div class="col-md-12 my-3">
                            <label for="">حالة الدور</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">غير نشط</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="1" class="selectgroup-input">
                                    <span class="selectgroup-button">نشط</span>
                                </label>
                            </div>
                        </div>
                        <div class="card mb-4 card-primary shadow">
                            <div class="card-header">
                                <div class="title">
                                    <h5>إضافة صلاحيات لهذا الدور</h5>
                                </div>
                            </div>
                            <div class="card-body" dir="ltr">
                                <?php if(config('permissionList')): ?>
                                    <div class="row mt-3">
                                        <?php $__currentLoopData = config('permissionList'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="input-box col-md-6 mt-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="<?php echo e($item); ?>"
                                                        id="flexSwitchCheckDefault<?php echo e($item); ?>" />
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckDefault<?php echo e($item); ?>"><?php echo e($key); ?></label>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
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
                            <p>هل انت متأكد من حذف هذا الدور ؟
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(function() {
            'use strict'

            $('.add').on('click', function() {
                const modal = $('#add-modal');
                modal.find('form')[0].reset();
                modal.find('.modal-title').text("إنشاء دور جديد")
                modal.find('form').attr('action', '<?php echo e(route('admin.role.create')); ?>');
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#add-modal');
                modal.find('form')[0].reset();
                const role = $(this).data('role');
                modal.find('.modal-title').text("تعديل الدور" + ' ' + (role.name || ''));
                modal.find('input[name="name"]').val(role.name);
                modal.find('input[name="status"][value="' + role.status + '"]').prop('checked', true);
                role.permission.forEach(permission => {
                    modal.find('input[value="' + permission + '"]').prop('checked', true);
                });
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            });

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف الدور" + ' ' + ($(this)
                    .data('role').name || ''));
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show');
            })
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

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/backend/roles/index.blade.php ENDPATH**/ ?>