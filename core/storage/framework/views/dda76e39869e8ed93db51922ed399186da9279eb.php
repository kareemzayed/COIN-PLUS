<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo e(route('admin.home')); ?>"><?php echo e($general->sitename); ?></a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item dropdown <?php echo e(menuActive('admin.home')); ?>">
                <a href="<?php echo e(route('admin.home')); ?>" class="nav-link">
                    <i data-feather="home" style="margin-left: 10px; margin-right: 0px"></i><span>لوحة التحكم</span></a>
            </li>

            <?php if(checkPermission(2)): ?>
                <li class="sidebar-menu-caption">إدارة المستخدمين</li>
                <li
                    class="nav-item dropdown <?php echo e(menuActive(['admin.user', 'admin.user.details', 'admin.user.update', 'admin.user.balance.update', 'admin.user.mail', 'admin.user.search', 'admin.user.disabled', 'admin.user.filter', 'admin.user.account.statement'])); ?>">
                    <a href="<?php echo e(route('admin.user')); ?>" class="nav-link "><i data-feather="users"
                            style="margin-left: 10px; margin-right: 0px"></i>
                        <span>قائمة المستخدمين</span></a>
                </li>
            <?php endif; ?>

            <?php if(checkPermission(7) || checkPermission(9)): ?>
                <li class="sidebar-menu-caption">الدعم الفني</li>
                <?php if(checkPermission(7)): ?>
                    <li class="nav-item dropdown <?php echo e(menuActive(['admin.transactions.reports.index'])); ?>">
                        <a href="<?php echo e(route('admin.transactions.reports.index')); ?>" class="nav-link "><i
                                data-feather="alert-circle" style="margin-left: 10px; margin-right: 0px"></i>
                            <span>بلاغات المعاملات</span>
                            <?php if($pendingReports > 0): ?>
                                <span class="badge badge-danger mr-2"><?php echo e($pendingReports ?? 0); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(checkPermission(9)): ?>
                    <li class="nav-item dropdown <?php echo e(menuActive('admin.ticket.index')); ?>">
                        <a href="<?php echo e(route('admin.ticket.index')); ?>" class="nav-link ">
                            <i data-feather="inbox" style="margin-left: 10px; margin-right: 0px"></i><span>الدعم
                                الفني</span>
                            <?php if($numOfPendingTickets > 0): ?>
                                <span class="badge badge-danger mr-2"><?php echo e($numOfPendingTickets ?? 0); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(checkPermission(12) || checkPermission(11)): ?>
                <li class="sidebar-menu-caption">تقارير</li>
                <?php if(checkPermission(11)): ?>
                    <li class="nav-item dropdown <?php echo e(menuActive(['admin.vouchers.fund'])); ?>">
                        <a href="<?php echo e(route('admin.vouchers.fund')); ?>" class="nav-link ">
                            <i data-feather="archive" style="margin-left: 10px; margin-right: 0px"></i><span>صندوق
                                السندات</span></a>
                    </li>
                <?php endif; ?>
                <?php if(checkPermission(12)): ?>
                    <li class="nav-item dropdown <?php echo e(menuActive(['admin.profits'])); ?>">
                        <a href="<?php echo e(route('admin.profits')); ?>" class="nav-link ">
                            <i data-feather="gift"
                                style="margin-left: 10px; margin-right: 0px"></i><span>الأرباح</span></a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php if(checkPermission(13)): ?>
                <li class="sidebar-menu-caption">إدارة الشيكات</li>
                <li
                    class="nav-item dropdown <?php echo e(menuActive(['admin.checks.index', 'admin.checks.create', 'admin.checks.update', 'admin.checks.delete'])); ?>">
                    <a href="<?php echo e(route('admin.checks.index')); ?>" class="nav-link "><i data-feather="file-text"
                            style="margin-left: 10px; margin-right: 0px"></i>
                        <span>قائمة الشيكات</span></a>
                </li>
            <?php endif; ?>

            <?php if(checkPermission(17)): ?>
                <li class="sidebar-menu-caption">إعدادات النظام</li>
                <li class="nav-item dropdown <?php echo e($navGeneralSettingsActiveClass ?? ''); ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="settings" style="margin-left: 10px; margin-right: 0px"></i>
                        <span>إعدادات عامة</span></a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo e($subNavGeneralSettingsActiveClass ?? ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('admin.general.setting')); ?>">إعدادات عامة</a>
                        </li>
                        <li class="<?php echo e($subNavCookieActiveClass ?? ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('admin.general.cookie')); ?>">موافقة الكوكيز</a>
                        </li>
                        <li class="<?php echo e($subNavRecaptchaActiveClass ?? ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('admin.general.recaptcha')); ?>">المستخدم ليس روبوت</a>
                        </li>
                        <li class="<?php echo e($subNavSEOManagerActiveClass ?? ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('admin.general.seo')); ?>">مدير SEO العالمي</a>
                        </li>
                        <li>
                            <a class="nav-link" href="<?php echo e(route('admin.general.cacheclear')); ?>">مسح ذاكرة التخزين
                                المؤقت</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown <?php echo e($permissionsActiveClass ?? ''); ?>">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="lock" style="margin-left: 10px; margin-right: 0px"></i>
                        <span>الصلاحيات</span></a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo e($availavleRolesActiveClass ?? ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('admin.availble.roles')); ?>">الأدوار المتاحة</a>
                        </li>
                        <li class="<?php echo e($manageStaffsActiveClass ?? ''); ?>"><a class="nav-link"
                                href="<?php echo e(route('admin.staffs.list')); ?>">إدارة فريق العمل</a>
                        </li>
                    </ul>
                </li>
            <?php endif; ?>

            

            

            

            

            

            

        </ul>
    </aside>
</div>
<?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/layout/sidebar.blade.php ENDPATH**/ ?>