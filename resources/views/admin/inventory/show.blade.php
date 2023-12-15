@extends('admin.layouts.app')

@section('content')

<div class="card mx-4">
    <div class="card-header">
        <div class="float-start">
            Category Information
        </div>
        <div class="float-end">
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="card-body">

        <div class="mb-3 row">
            <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
            <div class="col-md-6" style="line-height: 35px;">
                {{ $category->name }}
            </div>
        </div>
    </div>
</div>
@endsection