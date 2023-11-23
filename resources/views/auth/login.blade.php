<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>
        Aplikasi Evaluasi Beasiswa | Login
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
</head>

<body class=" d-flex flex-column">

    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <h1>Aplikasi Evaluasi Beasiswa</h1>
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login</h2>

                    @include('layouts.alert')

                    <form action="{{ route('login') }}" method="POST">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">
                                PIN
                            </label>
                            <div class="input-group input-group-flat">
                                <input type="password" class="form-control" name="pin" id="pin" required>
                                <span class="input-group-text">
                                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="top"
                                        onclick="let psw_input = document.getElementById('pin'); psw_input.type = (psw_input.type === 'password') ? 'text' : 'password';">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabler Core -->
    <script src="{{ asset('assets/js/tabler.min.js') }}" defer></script>
</body>

</html>
