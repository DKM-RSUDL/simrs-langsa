@extends('layouts.auth.app')

@section('content')
        <div class="row justify-content-sm-center h-100 align-items-center">
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
                                <input id="email" type="email" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <span class="input-group-text rounded-end" role="alert">&nbsp<i class="fa fa-envelope"></i>&nbsp</span>

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
                                <input id="password" type="password" placeholder="Your password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <span class="input-group-text rounded-end password cursor-pointer">&nbsp<i class="fa fa-eye"></i>&nbsp</span>

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
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
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
    </div>
@endsection
