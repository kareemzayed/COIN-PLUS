<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" href="{{ getFile('icon', $general->favicon, true) }}">

    <title>
        @if ($general)
            {{ __($general->sitename) . '-' }}
        @endif
        {{ __($pageTitle) }}
    </title>


    <!-- bootstrap 5  -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lib/bootstrap.min.css') }}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/all.min.css') }}">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/custom.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/theme2/css/line-awesome.min.css') }}">
    <!-- lightcase css -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lightcase.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lib/countrySelect.css') }}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/izitoast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lib/select2.min.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/main.css') }}">

    @stack('style')

    <link rel="stylesheet"
        href="{{ asset('asset/theme2/css/color.php?primary_color=' . str_replace('#', '', $general->primary_color_theme2)) }}">
</head>


<body>

    <!-- back-to-top start -->
    <div class="back-to-top">
        <i class="las la-arrow-up"></i>
    </div>
    <!-- back-to-top end -->



    @if ($general->preloader_status)
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
    @endif


    @if ($general->allow_modal)
        @include('cookieConsent::index')
    @endif


    @if ($general->analytics_status)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $general->analytics_key }}"></script>
        <script>
            'use strict'
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());
            gtag("config", "{{ $general->analytics_key }}");
        </script>
    @endif

    @include(template() . 'layout.header')
    <main class="main-wrapper">

        @yield('content')

    </main>

    @include(template() . 'layout.footer')


    <script src="{{ asset('asset/theme2/js/lib/jquery-3.6.0.min.js') }}"></script>
    <!-- bootstrap 5 js -->
    <script src="{{ asset('asset/theme2/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- slick  slider js -->
    <script src="{{ asset('asset/theme2/js/lib/slick.min.js') }}"></script>

    <script src="{{ asset('asset/theme2/js/lib/lightcase.js') }}"></script>

    <script src="{{ asset('asset/theme2/js/lib/countrySelect.js') }}"></script>
    <!-- wow js  -->
    <script src="{{ asset('asset/theme2/js/lib/wow.min.js') }}"></script>
    <script src="{{ asset('asset/theme2/js/izitoast.min.js') }}"></script>
    <script src="{{ asset('asset/theme2/js/lib/select2.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('asset/theme2/js/app.js') }}"></script>

    @stack('script')

    <script>
        'use strict'

        $("#country_selector").countrySelect({
            defaultCountry: "bd",
            onlyCountries: ['us', 'bd', 'ca']
        });

        $("#country_selector2").countrySelect({
            defaultCountry: "us",
            onlyCountries: ['us', 'bd', 'ca']
        });
    </script>


    @if ($general->twak_allow)
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = "https://embed.tawk.to/{{ $general->twak_key }}";
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    @endif



    @if (Session::has('error'))
        <script>
            "use strict";
            iziToast.error({
                message: "{{ session('error') }}",
                position: 'topLeft'
            });
        </script>
    @endif

    @if (Session::has('success'))
        <script>
            "use strict";
            iziToast.success({
                message: "{{ session('success') }}",
                position: 'topLeft'
            });
        </script>
    @endif

    @if (session()->has('notify'))
        @foreach (session('notify') as $msg)
            <script>
                "use strict";
                iziToast.{{ $msg[0] }}({
                    message: "{{ trans($msg[1]) }}",
                    position: "topLeft"
                });
            </script>
        @endforeach
    @endif

    @if ($errors->any())
        <script>
            "use strict";
            @foreach ($errors->all() as $error)
                iziToast.error({
                    message: "{{ __($error) }}",
                    position: "topLeft"
                });
            @endforeach
        </script>
    @endif

    <script>
        function formatDecimalAmount(amount, fraction) {
            const parsedAmount = parseFloat(amount);
            if (!isNaN(parsedAmount) && Number.isInteger(fraction) && fraction >= 0) {
                const formattedAmount = parsedAmount.toFixed(fraction);
                return formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } else {
                return "Invalid input";
            }
        }
    </script>
    <script>
        'use strict'
        $(document).on('submit', '#subscribe', function(e) {
            e.preventDefault();
            const email = $('.subscribe-email').val();
            var url = "{{ route('subscribe') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    email: email,
                },
                success: (data) => {
                    iziToast.success({
                        message: data.message,
                        position: 'topLeft',
                    });
                    $('.subscribe-email').val('');

                },
                error: (error) => {
                    if (typeof(error.responseJSON.errors.email) !== "undefined") {
                        iziToast.error({
                            message: error.responseJSON.errors.email,
                            position: 'topLeft',
                        });
                    }
                }
            })
        });

        var url = "{{ route('user.changeLang') }}";
        $(".changeLang").change(function() {
            if ($(this).val() == '') {
                return false;
            }
            window.location.href = url + "?lang=" + $(this).val();
        });
    </script>
</body>

</html>
