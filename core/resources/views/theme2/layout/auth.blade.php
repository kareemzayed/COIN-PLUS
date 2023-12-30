<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/png" href="{{ getFile('icon',  $general->favicon, true) }}">

    <title>
        @if ($general)
            {{ $general->sitename . '-' }}
        @endif
        {{ $pageTitle }}
    </title>

    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lib/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/theme2/css/all.min.css') }}">
    <!-- lineawesome font -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/line-awesome.min.css') }}">
    <!-- lightcase css -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lightcase.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lib/countrySelect.css') }}">
    <!-- slick slider css -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/lib/slick.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/theme2/css/izitoast.min.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/theme2/css/custom.css') }}">


    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('asset/theme2/css/main.css') }}">
    @stack('style')

    <link rel="stylesheet"
        href="{{ asset('asset/theme2/css/color.php?primary_color=' . str_replace('#', '', $general->primary_color_theme2)) }}">
</head>


<body>

    <div class="back-to-top">
        <i class="las la-arrow-up"></i>
    </div>
    @if ($general->preloader_status)
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


    @yield('content')

    {{-- back to to btn jobas --}}


    <!-- jQuery library -->

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

    <!-- main js -->
    <script src="{{ asset('asset/theme2/js/app.js') }}"></script>

    @stack('script')
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
                    url: "{{ route('subscribe') }}",
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
