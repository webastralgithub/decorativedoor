@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3> Add New Permission</h3>
            
        <div class="top-bntspg-hdr">
            <a href="{{ route('permissions.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="body-content-new">
        <form action="{{ route('permissions.store') }}" method="post">
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
                <label for="guard_name" class="col-md-4 col-form-label text-md-end text-start">Gaurd Name</label>
                <div class="col-md-8">
                    <input type="guard_name" class="form-control @error('guard_name') is-invalid @enderror" id="guard_name" name="guard_name" value="{{ old('guard_name', 'web') }}">
                    @if ($errors->has('guard_name'))
                    <span class="text-danger">{{ $errors->first('guard_name') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <input type="submit" class="col-md-4 offset-md-6 btn btn-primary" value="Add Permission">
            </div>

        </form>
    </div>
</div>
@endsection