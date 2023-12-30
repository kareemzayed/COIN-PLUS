
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="card-header-form">
                    <form method="GET" action="<?php echo e(route('admin.profits')); ?>">
                        <div class="input-group">
                            <label
                                style="font-size: 18px; margin: 15px 15px 20px 15px; font-weight: 700">الأرباح في شهر:</label>
                            <input type="month" class="form-control" placeholder="date" name="date"
                                value="<?php echo e($dateString); ?>">
                            <div class="input-group-btn">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="section-header pl-0">
                <h1 class="pl-0"><?php echo e('أرباح شهر' . ' ' . $dateString); ?></h1>
            </div>
            <div class="row">
                <div class="custom-xxxl-12 custom-xxl-12 col-md-12 col-sm-12 col-12 mb-4">
                    <div class="card-stat gr-bg-5">
                        <div class="icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="content">
                            <p class="caption" style="font-size: 15px">إجمالي الأرباح من جميع المعاملات</p>
                            <h4 class="card-stat-amount">
                                <?php echo e(number_format($totalProfits, 2) . ' ' . $general->site_currency); ?><br />
                                <?php echo e($totalTrans . ' ' . 'معاملة'); ?>

                            </h4>
                        </div>
                    </div>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="<?php echo e(checkPermission(18) ? route('admin.purchase.index', $dateString) : '#'); ?>"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-1">
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="content" style="font-size: 15px">
                                <p class="caption">إجمالي الأرباح من معاملات الشراء من وسيط الي عميل</p>
                                <h4 class="card-stat-amount">
                                    <?php if(isset($groupedProfits['App\Models\Purchase'])): ?>
                                        <?php echo e(number_format($groupedProfits['App\Models\Purchase']['totalProfits'], 2) . ' ' . $general->site_currency); ?><br />
                                        <?php echo e($groupedProfits['App\Models\Purchase']['transactionCount'] . ' ' . 'معاملة'); ?>

                                    <?php else: ?>
                                        0.00 <?php echo e($general->site_currency); ?><br />
                                        0 <?php echo e('معاملة'); ?>

                                    <?php endif; ?>
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="<?php echo e(checkPermission(22) ? route('admin.sales.index', $dateString) : '#'); ?>"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-2">
                            <div class="icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">إجمالي الأرباح من معاملات البيع المباشر
                                </p>
                                <h4 class="card-stat-amount">
                                    <?php if(isset($groupedProfits['App\Models\Sale'])): ?>
                                        <?php echo e(number_format($groupedProfits['App\Models\Sale']['totalProfits'], 2) . ' ' . $general->site_currency); ?><br />
                                        <?php echo e($groupedProfits['App\Models\Sale']['transactionCount'] . ' ' . 'معاملة'); ?>

                                    <?php else: ?>
                                        0.00 <?php echo e($general->site_currency); ?><br />
                                        0 <?php echo e('معاملة'); ?>

                                    <?php endif; ?>
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="<?php echo e(checkPermission(54) ? route('admin.external.transactions.index', $dateString) : '#'); ?>"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-3">
                            <div class="icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">إجمالي الأرباح من المعاملات الخارجية
                                </p>
                                <h4 class="card-stat-amount">
                                    <?php if(isset($groupedProfits['App\Models\ExternalTransaction'])): ?>
                                        <?php echo e(number_format($groupedProfits['App\Models\ExternalTransaction']['totalProfits'], 2) . ' ' . $general->site_currency); ?><br />
                                        <?php echo e($groupedProfits['App\Models\ExternalTransaction']['transactionCount'] . ' ' . 'معاملة'); ?>

                                    <?php else: ?>
                                        0.00 <?php echo e($general->site_currency); ?><br />
                                        0 <?php echo e('معاملة'); ?>

                                    <?php endif; ?>
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/profits/index.blade.php ENDPATH**/ ?>