<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>
        @if ($general)
            {{ $general->sitename . '-' }}
        @endif
        {{ $pageTitle }}
    </title>
    <link rel="shortcut icon" type="image/png" href="{{ getFile('icon', $general->favicon, true) }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('asset/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/font-awsome.min.css') }}">
    @csrf

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('asset/admin/css/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/component-custom-switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/izitoast.min.css') }}">
    @stack('style-plugin')
    <link rel="stylesheet" href="{{ asset('asset/admin/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('asset/admin/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('asset/admin/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/iconpicker.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/ui.css') }}">
    @stack('style')
</head>
<body>
    <div id="app">
        <div class="main-wrapper">
            <div id="overlay">
                <div class="cv-spinner">
                    <span class="spinner"></span>
                </div>
            </div>
            @include('backend.layout.navbar')
            @include('backend.layout.sidebar')
            @yield('content')
            @include('backend.layout.footer')
        </div>
    </div>

    @yield('script')

    <!-- General JS Scripts -->
    <script src="{{ asset('asset/admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/proper.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/feather.min.js') }}"></script>
    
    <script src="{{ asset('asset/admin/js/nicescroll.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('asset/admin/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('asset/admin/modules/moment.min.js') }}"></script>
    <script src="{{ asset('asset/admin/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
    <script src="{{ asset('asset/admin/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('asset/admin/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('asset/admin/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/stisla.js') }}"></script>
    <script src="{{ asset('asset/admin/js/scripts.js') }}"></script>
    <script src="{{ asset('asset/admin/js/izitoast.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/iconpicker.js') }}"></script>
    <script src="{{ asset('asset/admin/js/toggle.min.js') }}"></script>
    <script src="{{ asset('asset/admin/js/ui.js') }}"></script>

    <script src="{{ asset('asset/admin/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    @stack('script-plugin')
    <script src="{{ asset('asset/admin/js/sortable.min.js') }}"></script>
    @stack('script')

    @if (Session::has('success'))
        <script>
            "use strict";
            iziToast.success({
                message: "{{ session('success') }}",
                position: 'topLeft'
            });
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
                message: '{{ __($error) }}',
                position: "topLeft"
                });
            @endforeach
        </script>
    @endif

    <script>
        'use strict'
        var url = "{{ route('admin.changeLang') }}";

        $(".changeLang").change(function() {
            if ($(this).val() == '') {
                return false;
            }
            window.location.href = url + "?lang=" + $(this).val();
        });
    </script>
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
</body>

</html>