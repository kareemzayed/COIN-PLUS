
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>قائمة المستخدمين</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <?php if(checkPermission(6)): ?>
                                    <a href="<?php echo e(route('user.register')); ?>" target="_blank" class="btn btn-primary"><i
                                            class="fa fa-plus"></i>
                                        إنشاء مستخدم جديد</a>
                                <?php endif; ?>
                            </h4>
                            <div class="card-header-form">
                                <form method="GET" action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="رقم الحساب"
                                            name="account_number"
                                            value="<?php echo e(isset($search['account_number']) ? $search['account_number'] : ''); ?>">
                                        <input type="text" class="form-control" placeholder="اسم المستخدم"
                                            name="user_name"
                                            value="<?php echo e(isset($search['user_name']) ? $search['user_name'] : ''); ?>">
                                        <select class="form-control" name="status">
                                            <option disabled selected>حالة المستخدم</option>
                                            <option value="1"
                                                <?php echo e(isset($search['status']) && $search['status'] == '1' ? 'selected' : ''); ?>>
                                                نشط</option>
                                            <option value="0"
                                                <?php echo e(isset($search['status']) && $search['status'] == '0' ? 'selected' : ''); ?>>
                                                غير نشط</option>
                                        </select>
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table" id="example">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>رقم الحساب</th>
                                                <th>الأسم بالكامل</th>
                                                <th>رقم الهاتف</th>
                                                <th>البريد الألكتروني</th>
                                                <th>الرصيد الحالي</th>
                                                <th>حالة الحساب</th>
                                                <th>إجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></td>
                                                    <td><?php echo e($user->account_number); ?></td>
                                                    <td><?php echo e($user->fullname); ?></td>
                                                    <td><?php echo e($user->phone); ?></td>
                                                    <td><?php echo e($user->email); ?></td>
                                                    <td class="<?php echo e($user->balance > 0 ? 'text-success' : 'text-danger'); ?>">
                                                        <?php echo e(number_format($user->balance, 2) . ' ' . $general->site_currency); ?>

                                                    </td>
                                                    <td>
                                                        <?php if($user->status): ?>
                                                            <span class='badge badge-success'>نشط</span>
                                                        <?php else: ?>
                                                            <span class='badge badge-danger'>غير نشط</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="width: 17%">
                                                        <?php if(checkPermission(3)): ?>
                                                            <a href="<?php echo e(route('admin.user.account.statement', $user)); ?>"
                                                                class="btn btn-md btn-primary">كشف حساب</a>
                                                        <?php endif; ?>

                                                        <?php if(checkPermission(47)): ?>
                                                            <a href="<?php echo e(route('admin.user.details', $user)); ?>"
                                                                class="btn btn-md btn-primary"><i class="fa fa-pen"></i></a>
                                                        <?php endif; ?>

                                                        <?php if(checkPermission(5)): ?>
                                                            <a href="<?php echo e(route('admin.login.user', $user)); ?>"
                                                                target="_blank" class="btn btn-info btn-sm"><i
                                                                    class="fas fa-sign-in-alt"></i></a>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <tr>
                                                    <td class="text-center" colspan="100%">لم يتم العثور علي مستخدمين</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php if($users->hasPages()): ?>
                                <div class="card-footer">
                                    <?php echo e($users->links()); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/backend/users/index.blade.php ENDPATH**/ ?>