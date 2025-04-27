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
            color: #000;
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
                Selamat Datang...<br />Di Electronic Medical Record Information System (EMRIS)<br />RSUD Langsa
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

                <div class="col-md-8 text-center">
                    <a href="{{ route('home') }}" class="btn btn__custom btn-lg">{{ __('Login') }}</a>
                </div>
            </div>
        </div>
    </div>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
@endsection
@endsection
