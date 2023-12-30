<!DOCTYPE html>
<html lang="ar"  dir="rtl">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(getFile('icon', $general->favicon, true)); ?>">
    <title>
        <?php if($general): ?>
            <?php echo e($general->sitename . '-'); ?>

        <?php endif; ?>
        <?php echo e($pageTitle); ?>

    </title>
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/cookie.css')); ?>">

    <!-- bootstrap 5  -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/lib/bootstrap.min.css')); ?>">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/all.min.css')); ?>">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/line-awesome.min.css')); ?>">
    <!-- lightcase css -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/lightcase.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/treant.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/lib/countrySelect.css')); ?>">
    <!-- slick slider css -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/lib/slick.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/izitoast.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/jquery-confirm.css')); ?>">
    <!-- main css -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/main.css')); ?>">

    <link rel="stylesheet"
        href="<?php echo e(asset('asset/theme2/css/color.php?primary_color=' . str_replace('#', '', $general->primary_color_theme2))); ?>">
    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body>
    <!-- back-to-top start -->
    <div class="back-to-top">
        <i class="las la-arrow-up"></i>
    </div>
    <!-- back-to-top end -->
    <?php if($general->preloader_status): ?>
        <div class="preloader-holder user-preloader">
            <div class="preloader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <!-- header-section start  -->
    <?php endif; ?>



    <?php if($general->analytics_status): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($general->analytics_key); ?>"></script>
        <script>
            'use strict'
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());
            gtag("config", "<?php echo e($general->analytics_key); ?>");
        </script>
    <?php endif; ?>

    <header class="header header-two">
        <div class="header-bottom">
            <div class="container-fluid">
                <nav class="navbar p-0 align-items-center">
                    <button type="button" class="sidebar-open-btn">
                        <i class="las la-chevron-left"></i>
                        <i class="las la-chevron-right"></i>
                    </button>
                    <a class="site-logo site-title" href="<?php echo e(route('home')); ?>">
                        <img src="<?php echo e(getFile('logo', $general->logo, true)); ?>" alt="شعار">
                    </a>
                    <ul class="nav navbar-nav main-menu">
                        <li
                            class="nav-item noti-item <?php echo e(auth()->user()->unreadNotifications()->count() > 0? 'has-noti': ''); ?>">
                            <a class="nav-link" href="<?php echo e(route('user.notifications')); ?>">
                                <i class="far fa-bell"></i>
                            </a>
                        </li>
                        <li class="nav-item h-user-item has_children">
                            <a href="#0">
                                <img src="<?php echo e(getFile('user', auth()->user()->image, true)); ?>" alt="image">
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item"><a class="nav-link"
                                        href="<?php echo e(route('user.ticket.index')); ?>">الدعم الفني</a>
                                </li>
                                <li class="nav-item"><a class="nav-link"
                                        href="<?php echo e(route('user.profile')); ?>">إعدادات الملف الشخصي</a>
                                </li>
                                <li class="nav-item"><a class="nav-link"
                                        href="<?php echo e(route('user.logout')); ?>">تسجيل الخروج</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div><!-- header__bottom end -->
    </header>
    <!-- header-section end  -->

    <main id="main" class="dashboard-main">
        <section class="dashboard-section">
            <?php echo $__env->make(template().'layout.user_sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('content2'); ?>
        </section>
    </main>

    <?php
        $content = content('contact.content');
        $contentlink = content('footer.content');
        $footersociallink = element('footer.element');
        $serviceElements = element('service.element');
    ?>

    <script src="<?php echo e(asset('asset/theme2/js/lib/jquery-3.6.0.min.js')); ?>"></script>

    <!-- bootstrap 5 js -->
    <script src="<?php echo e(asset('asset/theme2/js/lib/bootstrap.bundle.min.js')); ?>"></script>
    <!-- slick  slider js -->
    <script src="<?php echo e(asset('asset/theme2/js/lib/slick.min.js')); ?>"></script>

    <script src="<?php echo e(asset('asset/theme2/js/raphael.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/theme2/js/treant.js')); ?>"></script>

    <script src="<?php echo e(asset('asset/theme2/js/lib/lightcase.js')); ?>"></script>

    <script src="<?php echo e(asset('asset/theme2/js/lib/countrySelect.js')); ?>"></script>
    <!-- wow js  -->
    <script src="<?php echo e(asset('asset/theme2/js/lib/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/theme2/js/confirm.js')); ?>"></script>
    <!-- main js -->

    <script src="<?php echo e(asset('asset/theme2/js/izitoast.min.js')); ?>"></script>
    <script src="<?php echo e(asset('asset/theme2/js/app.js')); ?>"></script>


    <?php echo $__env->yieldPushContent('script'); ?>
    <?php if($general->twak_allow): ?>
        <script type="text/javascript">
            'use strict'
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = "https://embed.tawk.to/<?php echo e($general->twak_key); ?>";
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    <?php endif; ?>
    <?php if(Session::has('error')): ?>
        <script>
            "use strict";
            iziToast.error({
                message: "<?php echo e(session('error')); ?>",
                position: 'topLeft'
            });
        </script>
    <?php endif; ?>

    <?php if(Session::has('success')): ?>
        <script>
            "use strict";
            iziToast.success({
                message: "<?php echo e(session('success')); ?>",
                position: 'topLeft'
            });
        </script>
    <?php endif; ?>

    <?php if(session()->has('notify')): ?>
        <?php $__currentLoopData = session('notify'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <script>
                "use strict";
                iziToast.<?php echo e($msg[0]); ?>({
                    message: "<?php echo e(trans($msg[1])); ?>",
                    position: "topLeft"
                });
            </script>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <script>
            "use strict";
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                iziToast.error({
                    message: '<?php echo e($error); ?>',
                    position: "topLeft"
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php endif; ?>


    <script>
        'use strict'
        var url = "<?php echo e(route('user.changeLang')); ?>";

        $(".changeLang").change(function() {
            if ($(this).val() == '') {
                return false;
            }
            window.location.href = url + "?lang=" + $(this).val();
        });
        // responsive menu slideing
        $(".d-sidebar-menu>li>a").on("click", function() {
            var element = $(this).parent("li");
            if (element.hasClass("open")) {
                element.removeClass("open");
                element.find("li").removeClass("open");
                element.find("ul").slideUp(500, "linear");
            } else {
                element.addClass("open");
                element.children("ul").slideDown();
                element.siblings("li").children("ul").slideUp();
                element.siblings("li").removeClass("open");
                element.siblings("li").find("li").removeClass("open");
                element.siblings("li").find("ul").slideUp();
            }
        });

        $('.sidebar-open-btn').on('click', function() {
            $(this).toggleClass('active');
            $('.d-sidebar').toggleClass('active');
            $('.dashboard-body-part').toggleClass('active');
        });

        $('.d-main-card-expand').on('click', function(){
            $(this).toggleClass('active');
            $('.dashboard-main-card').toggleClass('active');
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/theme2/layout/master2.blade.php ENDPATH**/ ?>