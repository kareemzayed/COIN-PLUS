<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="shortcut icon" type="image/png" href="<?php echo e(getFile('icon',  $general->favicon, true)); ?>">

    <title>
        <?php if($general): ?>
            <?php echo e($general->sitename . '-'); ?>

        <?php endif; ?>
        <?php echo e($pageTitle); ?>

    </title>

    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/lib/bootstrap.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/all.min.css')); ?>">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/line-awesome.min.css')); ?>">
    <!-- lightcase css -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/lightcase.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/lib/countrySelect.css')); ?>">
    <!-- slick slider css -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/lib/slick.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/izitoast.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/custom.css')); ?>">


    <!-- main css -->
    <link rel="stylesheet" href="<?php echo e(asset('asset/theme2/css/main.css')); ?>">
    <?php echo $__env->yieldPushContent('style'); ?>

    <link rel="stylesheet"
        href="<?php echo e(asset('asset/theme2/css/color.php?primary_color=' . str_replace('#', '', $general->primary_color_theme2))); ?>">
</head>


<body>

    <div class="back-to-top">
        <i class="las la-arrow-up"></i>
    </div>
    <?php if($general->preloader_status): ?>
        <!-- back-to-top start -->
        <!-- back-to-top end -->

        <div class="preloader-holder">
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
    <?php endif; ?>


    <?php if($general->allow_modal): ?>
        <?php echo $__env->make('cookieConsent::index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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


    <?php echo $__env->yieldContent('content'); ?>

    


    <!-- jQuery library -->

    <script src="<?php echo e(asset('asset/theme2/js/lib/jquery-3.6.0.min.js')); ?>"></script>

    <!-- bootstrap 5 js -->
    <script src="<?php echo e(asset('asset/theme2/js/lib/bootstrap.bundle.min.js')); ?>"></script>
    <!-- slick  slider js -->
    <script src="<?php echo e(asset('asset/theme2/js/lib/slick.min.js')); ?>"></script>

    <script src="<?php echo e(asset('asset/theme2/js/lib/lightcase.js')); ?>"></script>

    <script src="<?php echo e(asset('asset/theme2/js/lib/countrySelect.js')); ?>"></script>
    <!-- wow js  -->
    <script src="<?php echo e(asset('asset/theme2/js/lib/wow.min.js')); ?>"></script>

    <script src="<?php echo e(asset('asset/theme2/js/izitoast.min.js')); ?>"></script>

    <!-- main js -->
    <script src="<?php echo e(asset('asset/theme2/js/app.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('script'); ?>
    <?php if($general->twak_allow): ?>
        <script type="text/javascript">
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
                    message: "<?php echo e(__($error)); ?>",
                    position: "topLeft"
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </script>
    <?php endif; ?>
    <script>
        'use strict';
        $(document).ready(function() {
            $('#trial_subscribe').on('click', function(e) {

                e.preventDefault();
                var email = $('#trial_email').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: 'POST',
                    url: "<?php echo e(route('subscribe')); ?>",
                    data: {
                        email: email
                    },
                    success: function(response) {

                        if (response.fails) {
                            notify('error', response.errorMsg.email)

                        }

                        if (response.success) {
                            $('#email').val('');
                            notify('success', response.successMsg)

                        }
                    }
                });
            })
        });
    </script>
    <script>
        'use strict'
        var url = "<?php echo e(route('user.changeLang')); ?>";

        $(".changeLang").change(function() {
            if ($(this).val() == '') {
                return false;
            }
            window.location.href = url + "?lang=" + $(this).val();
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/theme2/layout/auth.blade.php ENDPATH**/ ?>