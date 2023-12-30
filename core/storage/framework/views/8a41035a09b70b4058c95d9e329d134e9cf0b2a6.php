

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>جوجل ريكابتشا (التأكد من ان المستخدم ليس روبوت عند تسجيل الدخول)</h1>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Recaptcha Key</label>
                                        <input type="text" name="recaptcha_key" class="form-control" placeholder="Recaptcha Key"
                                            value="<?php echo e($recaptcha->recaptcha_key); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Recaptcha Secret</label>
                                        <input type="text" name="recaptcha_secret" class="form-control" placeholder="Recaptcha Secret"
                                            value="<?php echo e($recaptcha->recaptcha_secret); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">السماح بجوجل ريكابتشا</label>
                                        <select name="allow_recaptcha" id="" class="form-control">
                                            <option value="1" <?php echo e($recaptcha->allow_recaptcha==1 ? 'selected' : ''); ?>>
                                                نعم</option>
                                            <option value="0" <?php echo e($recaptcha->allow_recaptcha==0 ? 'selected' : ''); ?>>
                                                لا</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary float-right">تحديث ريكابتشا</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
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
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/backend/setting/recaptcha.blade.php ENDPATH**/ ?>