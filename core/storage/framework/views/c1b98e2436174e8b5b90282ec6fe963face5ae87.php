
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="card-header-form">
                    <form method="GET" action="">
                        <div class="input-group">
                            <label
                                style="font-size: 18px; margin: 15px 15px 20px 15px; font-weight: 700">شهر:</label>
                            <input type="month" class="form-control" placeholder="date" name="date"
                                value="<?php echo e(isset($search['date']) ? $search['date'] : ''); ?>">
                            <div class="input-group-btn">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="section-header pl-0">
                <h1 class="pl-0">صندوق السندات</h1>
            </div>
            <div class="row">
                <div class="custom-xxxl-12 custom-xxl-12 col-md-12 col-sm-12 col-12 mb-4">
                    <div class="card-stat gr-bg-5">
                        <div class="icon">
                            <i class="fas fa-archive"></i>
                        </div>
                        <div class="content">
                            <p class="caption" style="font-size: 15px">صندوق السندات (القبض - الصرف)
                            </p>
                            <h4 class="card-stat-amount">
                                <?php echo e(number_format($results->totalAmount, 2) . ' ' . $general->site_currency); ?><br />
                                <?php echo e($results->count . ' ' . 'سندات'); ?>

                            </h4>
                        </div>
                    </div>
                </div>

                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="<?php echo e(checkPermission(25) ? route('admin.receipt.vouchers.index', $search['date']) : '#'); ?>"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-1">
                            <div class="icon">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div class="content" style="font-size: 15px">
                                <p class="caption">الإيداعات (سندات القبض)</p>
                                <h4 class="card-stat-amount">
                                    <?php echo e(number_format($deposits->totalAmount, 2) . ' ' . $general->site_currency); ?><br />
                                    <?php echo e($deposits->count . ' ' . 'سندات'); ?>

                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="<?php echo e(checkPermission(29) ? route('admin.payment.vouchers.index', $search['date']) : '#'); ?>"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-2">
                            <div class="icon">
                                <i class="far fa-credit-card"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">السحوبات (سندات الصرف)</p>
                                <h4 class="card-stat-amount">
                                    <?php echo e(number_format($withdrawlas->totalAmount, 2) . ' ' . $general->site_currency); ?><br />
                                    <?php echo e($withdrawlas->count . ' ' . 'سندات'); ?>

                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/vouchers_fund/index.blade.php ENDPATH**/ ?>