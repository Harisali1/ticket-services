<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | Divine Travel</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/sweet_alert/sweetalert2.min.css') }}" rel="stylesheet"/>

    <style>
        html, body {
            height: 100%;
            overflow: hidden;
            background: #f8fafc;
        }

        /* LEFT PANEL */
        .left-panel {
            background: linear-gradient(180deg, #0f172a, #1e293b);
            color: #fff;
        }

        .brand-btn {
            background: #fff;
            color: #0f172a;
            font-weight: 700;
            padding: 8px 30px;
            border-radius: 30px;
            border: none;
        }

        .left-content {
            max-width: 380px;
        }

        .left-content img {
            max-width: 240px;
        }

        /* RIGHT PANEL */
        .register-box {
            background: #fff;
            border-radius: 18px;
            padding: 28px 32px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 520px;
        }

        .register-box h3 {
            font-weight: 700;
            color: #0f172a;
            font-size: 22px;
        }

        .form-control {
            height: 40px;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: none;
        }

        .signup-btn {
            height: 44px;
            border-radius: 10px;
            font-weight: 600;
            background: #2563eb;
            border: none;
            font-size: 15px;
        }

        .signup-btn:hover {
            background: #1d4ed8;
        }

        @media(max-width: 991px) {
            html, body {
                overflow-y: auto;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid h-100">
    <div class="row h-100">

        <!-- LEFT -->
        <div class="col-md-6 d-flex flex-column justify-content-between align-items-center py-5 left-panel">

            <button class="brand-btn mt-3">Divine Travel</button>

            <div class="text-center px-4">
                <img src="{{ asset('images/register.png') }}" class="img-fluid travel-image mb-4" alt="Travel">
                <h5 class="fw-semibold">{{ __('messages.your_journey_start_here')}}</h5>
                <p class="small text-light opacity-75">
                    Reset your password to access your account.
                </p>
            </div>

            <div class="d-flex gap-4 left-links">
                <a href="{{ route('login')}}">{{ __('messages.sign_in')}}</a>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-6 d-flex align-items-center justify-content-center px-3">

            <div class="register-box">
                <div class="d-flex justify-content-end mb-2 lang-switch">
                    <a href="{{ route('language.switch', 'en') }}" class="language-flag" title="English">
                        <img src="https://flagcdn.com/w20/gb.png" alt="English">
                    </a> &nbsp; | &nbsp; 
                    <a href="{{ route('language.switch', 'it') }}" class="language-flag" title="Italian">
                        <img src="https://flagcdn.com/w20/it.png" alt="Italian">
                    </a> &nbsp; | &nbsp;
                    <a href="{{ route('language.switch', 'fr') }}" class="language-flag" title="French">
                        <img src="https://flagcdn.com/w20/fr.png" alt="French">
                    </a>
                </div>

                <div class="col-md-12 text-center mb-3">
                    <img 
                        src="{{ asset('images/logo.jpg') }}"
                        alt="Logo"
                        style="width:80px;height:80px;"
                        class="rounded border"
                    >
                </div>

                <h3 class="text-center mb-3">{{ __('Reset Password') }}</h3>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <input 
                            id="email" 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email" 
                            autofocus
                            placeholder="{{ __('messages.email') }}"
                        >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn signup-btn w-100">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/sweet_alert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
