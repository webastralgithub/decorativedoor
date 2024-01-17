@extends('admin.layouts.app')
@section('content')
<!-- Sign In Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center customform" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 custom_form_content">
            <div class="bg-light rounded p-4 p-sm-3 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ route('dashboard') }}" class="">
                        <img src="{{asset('frontend/img/logo.png')}}" class="img" />
                    </a>
                    <h6 class="mb-0">Login</h6>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <label for="floatingInput">{{ __('Email Address') }}</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input " id="exampleCheck1 {{ old('remember') ? 'checked' : '' }}">
                            <label class="form-check-label" for="exampleCheck1">
                                {{ __('Remember me') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"> Forgot your password</a>
                        @endif
                    </div>
                    <button type="submit" class="login-screen-btn btn btn-primary py-3 w-100 mb-4">
                        {{ __('Login') }}
                    </button>

                </form>
                <p class="text-center mb-0">Create a Account <a href="{{route('register')}}">Sign Up</a></p>
            </div>
        </div>
    </div>
</div>
<!-- Sign In End -->
@endsection