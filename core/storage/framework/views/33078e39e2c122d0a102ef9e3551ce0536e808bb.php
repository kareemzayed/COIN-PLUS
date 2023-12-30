

<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>إدارة SEO</h1>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="">وصف SEO</label>
                                        <textarea name="seo_description" id="" cols="30" rows="10"
                                            class="form-control"><?php echo e(__(clean($general->seo_description))); ?></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary float-right">تحديث</button>
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
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/setting/seo.blade.php ENDPATH**/ ?>