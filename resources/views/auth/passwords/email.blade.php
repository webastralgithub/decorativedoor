@extends('admin.layouts.app')
@section('content')
<!-- Reset Password -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <a href="{{route('dashboard')}}" class="">
                        <img src="{{asset('frontend/img/logo.png')}}" class="img" />
                    </a>
                    <h6>Reset my password</h6>
                </div>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-5">
                        <label for="email" class="col-md-6 col-form-label text-md-end">{{ __('Email Address') }}</label>

                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-4 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Send') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Reset Password End -->
@endsection