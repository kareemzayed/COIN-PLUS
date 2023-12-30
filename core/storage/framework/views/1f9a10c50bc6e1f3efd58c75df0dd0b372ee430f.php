
<?php $__env->startSection('content'); ?>
    <?php
        $login = content('login.content');
    ?>
    <div class="account-page">
        <div class="content-wrapper">
            <div class="logo">
                <a href="<?php echo e(route('home')); ?>"><img src="<?php echo e(getFile('logo', $general->logo, true)); ?>" alt="شعار"></a>
            </div>
            <div class="content">
                <h2 class="title">مرحبًا بك في <?php echo e($general->sitename); ?></h2>
            </div>
        </div>
        <div class="form-wrapper">
            <div class="inner-wrapper">
                <div class="text-center">
                    <h2 class="title">مرحبًا بك في <?php echo e($general->sitename); ?></h2>
                    <p class="mt-2">هل انت جديد في <?php echo e($general->sitename); ?> ؟ <a href="<?php echo e(route('user.register')); ?>" class="site-color">إنشاء حساب</a></p>
                </div>
                <form class="account-form" action="" method="POST">
                    <?php echo csrf_field(); ?>
                    <label>البريد الإلكتروني</label>
                    <div class="custom-icon-field mb-3">
                        <input type="email" name="email" class="form-control" placeholder="البريد الإلكتروني">
                        <i class="las la-envelope"></i>
                    </div>
                    <label>كلمة المرور</label>
                    <div class="custom-icon-field mb-3">
                        <input type="password" name="password" class="form-control" placeholder="كلمة المرور">
                        <i class="las la-lock"></i>
                    </div>

                    <?php if($general->allow_recaptcha == 1): ?>
                        <div class="col-md-12 my-3">
                            <script src="https://www.google.com/recaptcha/api.js"></script>
                            <div class="g-recaptcha" data-sitekey="<?php echo e($general->recaptcha_key); ?>"
                                data-callback="verifyCaptcha"></div>
                            <div id="g-recaptcha-error"></div>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="form-check custom-checkbox mb-2">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label mb-0" for="flexCheckDefault">
                                تذكرني
                            </label>
                        </div>
                        <a href="<?php echo e(route('user.forgot.password')); ?>"
                            class="mb-2 site-color">نسيت كلمة المرور</a>
                    </div>
                    <button class="btn main-btn w-100 mt-4" type="submit">تسجيل الدخول</button>
                </form>
            </div>
            <div class="copy-right-text">
                <p>
                    <?php if($general->copyright): ?>
                        <?php echo e($general->copyright); ?>

                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML =
                    "<span class='text-danger'>حقل التحقق (Captcha) مطلوب</span>";
                return false;
            }
            return true;
        }

        function verifyCaptcha() {
            document.getElementById('g-recaptcha-error').innerHTML = '';
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(template().'layout.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/theme2/user/auth/login.blade.php ENDPATH**/ ?>