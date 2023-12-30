
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>الملف الشخصي</h1>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <form method="post" action="<?php echo e(route('admin.change.password')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="card-header">
                                <h6>تغيير كلمة المرور</h6>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="form-group col-md-12 col-12">
                                        <label>كلمة المرور القديمة</label>
                                        <input type="password" class="form-control" name="old_password"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>كلمة المرور الجديدة</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>أعد كتابة كلمة المرور الجديدة</label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">تغيير كلمة المرور</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <form method="post" action="<?php echo e(route('admin.profile.update')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-8 mb-3">
                                        <label class="col-form-label">صورة الملف الشخصي</label>

                                        <div id="image-preview" class="image-preview"
                                            style="background-image:url(<?php echo e(getFile('admin',auth()->guard('admin')->user()->image,true
                                            )); ?>);">
                                            <label for="image-upload"
                                                id="image-label">اختر ملفًا</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>

                                    </div>

                                    <div class="form-group col-md-12 col-12">
                                        <label>البريد الألكتروني</label>
                                        <input type="email" class="form-control" name="email"
                                            value="<?php echo e(auth()->guard('admin')->user()->email); ?>" required>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label>اسم المستخدم</label>
                                        <input type="text" class="form-control" name="username"
                                            value="<?php echo e(auth()->guard('admin')->user()->username); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">تحديث الملف الشخصي</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        'use strict'

        $(function() {
            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "اختر ملفًا", // Default: Choose File
                label_selected: "تحميل صورة", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
            });
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
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/backend/profile.blade.php ENDPATH**/ ?>