@extends('admin.layouts.app')

@section('content')

<div class="card mx-4">
    <div class="card-header">
        <div class="float-start">
            Add New Permission
        </div>
        <div class="float-end">
            <a href="{{ route('permissions.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('permissions.store') }}" method="post">
            @csrf

            <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <label for="guard_name" class="col-md-4 col-form-label text-md-end text-start">Gaurd Name</label>
                <div class="col-md-6">
                    <input type="guard_name" class="form-control @error('guard_name') is-invalid @enderror" id="guard_name" name="guard_name" value="{{ old('guard_name', 'web') }}">
                    @if ($errors->has('guard_name'))
                    <span class="text-danger">{{ $errors->first('guard_name') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Permission">
            </div>

        </form>
    </div>
</div>
@endsection