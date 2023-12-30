
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header pr-0">
                <h1>لوحة التحكم</h1>
            </div>
            <?php if(checkPermission(1)): ?>
                <div class="row">
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.user')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-3">
                                <div class="icon">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي المستخدمين</p>
                                    <h4 class="card-stat-amount"><?php echo e($totalUser); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.user', ['status' => 1])); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-4">
                                <div class="icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي الحسابات النشطة</p>
                                    <h4 class="card-stat-amount"><?php echo e($activeUser); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.user', ['status' => 0])); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-5">
                                <div class="icon">
                                    <i class="fas fa-user-times"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي الحسابات الغير نشطة</p>
                                    <h4 class="card-stat-amount"><?php echo e($deActiveUser); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.ticket.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-1">
                                <div class="icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي التذاكر</p>
                                    <h4 class="card-stat-amount"><?php echo e($totalTickets); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.transactions.reports.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-2">
                                <div class="icon">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي بلاغات المعاملات</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($totalTransReports); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.funds.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-7">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي صناديق الشركة</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($totalFunds); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.purchase.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-8">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي معاملات الشراء من وسيط الي عميل</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($purchasesTransactions); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.sales.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-9">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي معاملات البيع المباشر</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($salesTransactions); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.direct.purchase.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-5">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي معاملات الشراء المباشر</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($directPurchase); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.external.transactions.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-10">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي المعاملات الخارجية</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($externalTransactions); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.receipt.vouchers.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-11">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي سندات القبض</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($receiptVouchers); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.payment.vouchers.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-12">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي سندات الصرف</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($paymentVouchers); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.checks.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-13">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي الشيكات</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($checks); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="custom-xxxl-3 custom-xxl-3 col-md-6 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.trans.with.currency.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-1">
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="content">
                                    <p class="caption">إجمالي المعاملات بالعملات المتعددة</p>
                                    <h4 class="card-stat-amount">
                                        <?php echo e($transWithCurrencies); ?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <div class="section-header pr-0">
                <h1 class="pl-0">روابط سريعة</h1>
            </div>
            <div class="row" style="font-size: 15px;">
                <?php if(checkPermission(18)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.purchase.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">شراء من وسيط الي عميل</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(22)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.sales.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">بيع مباشر</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(73)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.direct.purchase.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">شراء مباشر</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(25)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.receipt.vouchers.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">سند قبض</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(29)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.payment.vouchers.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">سند صرف</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(34)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.funds.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">صناديق الشركة</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(58)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.deposits.withdraws.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">سجل الإداعات والسحوبات الإدارية</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(54)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.external.transactions.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">معاملة خارجية</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(69)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.trans.with.currency.index')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">معاملات بعملات متعددة</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(checkPermission(39)): ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="<?php echo e(route('admin.transaction')); ?>" style="text-decoration: none">
                            <div class="card-stat gr-bg-6">
                                <p class="caption">سجل المعاملات</p>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/backend/dashboard.blade.php ENDPATH**/ ?>