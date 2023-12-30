
<?php $__env->startSection('content'); ?>
    <section class="login-page">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="admin-login-wrapper">
                        <h3 class="text-dark text-center mb-4">إرسال رمز إعادة التعيين</h3>
                        <form action="<?php echo e(route('admin.password.reset')); ?>" method="POST" class="cmn-form mt-30">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="email" class="text-white">البريد الألكتروني</label>
                                <input type="email" name="email" class="form-control b-radius--capsule" id="username"
                                    value="<?php echo e(old('email')); ?>" placeholder="ادخل البريد الألكتروني">
                                <i class="las la-user input-icon"></i>
                            </div>
                            <div class="form-group text-right">
                                <a href="<?php echo e(route('admin.login')); ?>" class="text--small"><i
                                        class="fas fa-lock mr-2"></i>تسجيل الدخول من هنا</a>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="login-button text-white w-100" tabindex="4">
                                    إرسال رمز إعادة التعيين
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="simple-footer text-white">
                        <?php if($general->copyright): ?>
                            <?php echo e($general->copyright); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(function() {
            'use strict';

            $('form').on('submit', function() {
                const clickedButton = $(document.activeElement);
                if (clickedButton.is(':submit')) {
                    clickedButton.prop('disabled', true).html('جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.auth.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/backend/auth/email.blade.php ENDPATH**/ ?>