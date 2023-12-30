<div class="d-sidebar">
    <ul class="d-sidebar-menu">
        <li class="<?php echo e(singleMenu('user.transaction.log')); ?>"><a href="<?php echo e(route('user.transaction.log')); ?>"><i
                    class="fas fa-chart-bar"></i>سجل المعاملات</a></li>

        <li class="<?php echo e(singleMenu('user.notifications')); ?>"><a href="<?php echo e(route('user.notifications')); ?>"><i
                    class="fas fa-bell"></i>الإشعارات</a> </li>

        <li class="<?php echo e(singleMenu('user.ticket.index')); ?>"><a href="<?php echo e(route('user.ticket.index')); ?>"><i
                    class="fas fa-life-ring"></i>الدعم الفني</a> </li>
        <li class="pt-5">
            <p class="caption">الرصيد المتاح</p>
            <a href="<?php echo e(route('user.transaction.log')); ?>">
                <h3 class="acc-number fw-medium <?php echo e(auth()->user()->balance > 0 ? 'text-success' : 'text-danger'); ?>">
                    <?php echo e(number_format(auth()->user()->balance, 2) . ' ' . $general->site_currency); ?>

                </h3>
            </a>
        </li>
        <li>
            <label class="mt-5">رقم حسابي</label>
            <div class="input-group mb-3">
                <input type="text" id="refer-link" class="form-control referral-link-field copy-text"
                    value="<?php echo e(auth()->user()->account_number); ?>" readonly style="border-radius: 0 12px 12px 0">
                <button type="button" class="input-group-text copy main-btn" id="basic-addon2"
                    style="border-radius: 12px 0 0 12px">نسخ</button>
            </div>
        </li>
    </ul>
</div>

<!-- mobile bottom menu start -->
<div class="mobile-bottom-menu-wrapper">
    <ul class="mobile-bottom-menu">
        <li>
            <a href="<?php echo e(route('user.transaction.log')); ?>" class="<?php echo e(activeMenu(route('user.transaction.log'))); ?>">
                <i class="fas fa-chart-bar"></i>
                <span>المعاملات</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(route('user.notifications')); ?>" class="<?php echo e(activeMenu(route('user.notifications'))); ?>">
                <i class="fas fa-bell"></i>
                <span>الإشعارات</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(route('user.ticket.index')); ?>" class="<?php echo e(activeMenu(route('user.ticket.index'))); ?>">
                <i class="fas fa-life-ring"></i>
                <span>الدعم</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(route('user.profile')); ?>"
                class="<?php echo e(activeMenu([route('user.profile'), route('user.profileupdate'), route('user.change.password'), route('user.update.password')])); ?>">
                <i class="fas fa-user"></i>
                <span>ملفي الشخصي</span>
            </a>
        </li>
        <li class="sidebar-open-btn">
            <a href="#0" class="">
                <i class="fas fa-bars"></i>
                <span>القائمة</span>
            </a>
        </li>
    </ul>
</div>
<script>
    'use strict';
    var copyButton = document.querySelector('.copy');
    var copyInput = document.querySelector('.copy-text');

    copyButton.addEventListener('click', function(e) {
        e.preventDefault();
        var text = copyInput.select();
        document.execCommand('copy');
    });

    copyInput.addEventListener('click', function() {
        this.select();
    });
</script>
<!-- mobile bottom menu end -->
<?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/theme2/layout/user_sidebar.blade.php ENDPATH**/ ?>