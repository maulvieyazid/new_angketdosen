<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>
        Aplikasi Angket Dosen | @yield('html_title')
    </title>

    <!-- CSS files -->
    <link href="{{ asset('assets/css/tabler.min.css') }}" rel="stylesheet" />

    <style>
        /* @import url('https://rsms.me/inter/inter.css'); */
        @import url("{{ asset('assets/css/inter.css') }}");

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>

    @stack('css')


</head>

<body>
    <div class="page">

        <!-- Navbar -->
        @include('layouts.navbar')

        <!-- Content -->
        @yield('content')

        <!-- Footer -->
        @include('layouts.footer')

    </div>


    <!-- Tabler Core -->
    <script src="{{ asset('assets/js/tabler.min.js') }}" defer></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2@11.7.32.min.js') }}" defer></script>

    <!-- Jquery -->
    <script src="{{ asset('assets/libs/jquery/jquery-3.7.1.min.js') }}"></script>


    @stack('js')

</body>

</html>
