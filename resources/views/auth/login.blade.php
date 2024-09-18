@extends('layouts.auth.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .login__container {
            max-width: 100%;
            margin: 10px auto;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
        }

        .login__left {
            background-color: #ebf5ff;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            padding: 40px;
            flex: 1 1 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login__left h1 {
            color: #0066cc;
            font-size: 28px;
            font-weight: bold;
        }

        .login__left .row {
            margin-top: 20px;
        }

        .login__left img {
            width: 100%;
            margin-bottom: 15px;
        }

        .login__right {
            padding: 40px;
            flex: 1 1 50%;
            background-image: url("{{ asset('assets/img/background.png') }}");
            background-size: cover;
            background-position: center;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login__right img {
            width: 100px;
            margin: 0 auto 20px auto;
        }

        .btn__custom {
            background: linear-gradient(90.04deg, #1C9D41 2.03%, #B6D427 132%);
            color: white;
            border: none;
            transition: background 0.3s ease;
        }

        .btn__custom:hover {
            background: linear-gradient(90.04deg, #B6D427 2.03%, #1C9D41 132%);
            color: white;
        }


        .form-control {
            height: 45px;
            border-radius: 10px;
            background-color: #2B5775;
            color: white;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #80bdff;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-radius: 10px 0 0 10px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {

            .login__left,
            .login__right {
                flex: 1 1 100%;
                border-radius: 15px;
            }

            .login__left {
                text-align: center;
            }

            .login__left h1 {
                font-size: 24px;
            }

            .login__right img {
                width: 80px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container login__container">
        <!-- Left Side -->
        <div class="login__left">
            <h1>
                Selamat Datang...<br />Di Rekam Medis Elektronik<br />RSUD Langsa
            </h1>
            <div class="row mt-5">
                <div class="col-6">
                    <img src="{{ asset('assets/img/auth1.png') }}" alt="Medical Illustration" class="img-fluid" />
                </div>
                <div class="col-6">
                    <img src="{{ asset('assets/img/auth2.png') }}" alt="Medical Illustration" class="img-fluid" />
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="login__right">
            <div class="row justify-content-center align-items-center">
                <!-- Gambar Logo dan Ilustrasi -->
                <div class="col-md-4 text-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="img-fluid"
                        style="max-width: 120px;">
                    <br><br>
                    <img src="{{ asset('assets/img/auth3.png') }}" alt="Medical Illustration" class="img-fluid"
                        style="max-width: 150px;">
                </div>

                <!-- Form Login -->
                <div class="col-md-8">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h1 class="text-primary fw-bold text-center">{{ __('Login') }}</h1>
                        <div class="mb-4">
                            <label for="email" class="form-label text-center">{{ __('Email Address') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill-add"></i></span>
                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label text-center">{{ __('Password') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan password" required autocomplete="current-password">

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn__custom btn-lg"> {{ __('Login') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row justify-content-sm-center h-100 align-items-center">
        <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-sm-8">
            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <h1 class="fs-4 text-center fw-bold mb-4">{{ __('Login') }}</h1>
                    <h1 class="fs-6 mb-3">Please enter your email and password to log in.</h1>

                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                        @csrf

                        <div class="mb-3">
                            <label class="mb-2 text-muted" for="email">{{ __('Email Address') }}</label>
                            <div class="input-group input-group-join mb-3">
                                <input id="email" type="email" placeholder="Enter Email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <span class="input-group-text rounded-end" role="alert">&nbsp<i
                                        class="fa fa-envelope"></i>&nbsp</span>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="mb-2 w-100">
                                <label class="text-muted" for="password">{{ __('Password') }}</label>
                            </div>
                            <div class="input-group input-group-join mb-3">
                                <input id="password" type="password" placeholder="Your password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                <span class="input-group-text rounded-end password cursor-pointer">&nbsp<i
                                        class="fa fa-eye"></i>&nbsp</span>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-primary ms-auto">
                                {{ __('Login') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-5 text-muted">
                Copyright &copy; 2024 &mdash; SIMRS Langsa
            </div>
        </div>
    </div> --}}

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
@endsection
@endsection
