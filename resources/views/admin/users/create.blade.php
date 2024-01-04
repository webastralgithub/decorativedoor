@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Add New User</h3>
           
        <div class="top-bntspg-hdr">
            <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="body-content-new">
        <form action="{{ route('users.store') }}" method="post">
            @csrf

            <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                <div class="col-md-8">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                <div class="col-md-8">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                <div class="col-md-8">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>
                <div class="col-md-8">
                    <select class="form-select @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                        @forelse ($roles as $role)

                        @if ($role!='Super Admin')
                        <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                            {{ $role }}
                        </option>
                        @else
                        @if (Auth::user()->hasRole('Super Admin'))
                        <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                            {{ $role }}
                        </option>
                        @endif
                        @endif

                        @empty

                        @endforelse
                    </select>
                    @if ($errors->has('roles'))
                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <input type="submit" class="col-md-4 offset-md-6 btn btn-primary" value="Add User">
            </div>

        </form>
    </div>
</div>

@endsection