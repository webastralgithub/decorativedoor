@extends('admin.layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center customform" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4 custom_form_content">
            <div class="bg-light rounded p-4 p-sm-3 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{ route('dashboard') }}" class="">
                        <img src="{{asset('frontend/img/logo.png')}}" class="img" />
                    </a>
                    <h6 class="mb-0">Sign Up</h6>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="jhondoe">
                        <label for="floatingText">{{ __('Name') }}</label>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com">
                        <label for="floatingInput">{{ __('Email Address') }}</label>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                        <label for="floatingPassword">{{ __('Password') }}</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password_confirmation" name="password_confirmation" class="form-control" placeholder="Password">
                        <label for="floatingPassword">{{ __('Confirm Password') }}</label>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1"> {{ __('Remember Me') }}</label>
                        </div>
                        <a href="{{ route('password.request') }}">Forgot Password</a>
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4"> {{ __('Register') }}</button>
                    <p class="text-center mb-0">Already have an Account? <a href="{{route('login')}}">Sign In</a></p>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Sign Up End -->
@endsection