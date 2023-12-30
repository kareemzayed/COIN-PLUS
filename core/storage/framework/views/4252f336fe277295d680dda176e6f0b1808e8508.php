

<?php $__env->startSection('content'); ?>
    <section class="login-page">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="admin-login-wrapper">
                        <h3 class="text-dark text-center mb-2">تسجيل الدخول</h3>
                        <h3 class="text-dark text-center mb-4">منطقة إدارة COIN+</h3>
                        <form method="POST" class="p-2" action="<?php echo e(route('admin.login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="email">البريد الألكتروني</label>
                                <input id="email" type="email" class="form-control" name="email"
                                    value="<?php echo e(old('email')); ?>" tabindex="1" placeholder="ادخل البريد الألكتروني" required>
                            </div>
                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label ">كلمة المرور</label>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" tabindex="2"
                                    placeholder="ادخل كلمة المرور" required>
                            </div>
                            <div class="d-flex justify-content-between form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                        id="remember-me">
                                    <label class="custom-control-label text-dark"
                                        for="remember-me">تذكرني</label>
                                </div>
                                <a href="<?php echo e(route('admin.password.reset')); ?>" class="text-small ">
                                    نسيت كلمة المرور ؟
                                </a>
                            </div>
                            <button type="submit" class="login-button w-100" tabindex="4">
                                تسجيل الدخول
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
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
<?php echo $__env->make('backend.auth.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/backend/auth/login.blade.php ENDPATH**/ ?>