@extends('admin.layouts.app')

@section('content')

<div class="card mx-4">
    <div class="card-header">
        <div class="float-start">
            Add Category
        </div>
        <div class="float-end">
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="card-body">
        <form role="form" action="{{ route('category.store') }}" method="post" method="post">
            @csrf

            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Category name*</label>
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Category name" value="{{old('name')}}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Category Slug*</label>
                <div class="col-md-6">
                    <input type="text" name="slug" class="form-control" placeholder="Category Slug" value="{{old('slug')}}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Select parent category*</label>
                <div class="col-md-6">
                    <select type="text" name="parent_id" class="form-control">
                        <option value="">None</option>
                        @if($categories)
                        @foreach($categories as $category)
                        <?php $dash = ''; ?>
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @if(count($category->subcategory))
                        @include('admin.category.sub-category',['subcategories' => $category->subcategory])
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Category">
            </div>
        </form>

        @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
            <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
        </div>
        @endif

        @if(\Session::has('error'))
        <div>
            <li class="alert alert-danger">{!! \Session::get('error') !!}</li>
        </div>
        @endif

        @if(\Session::has('success'))
        <div>
            <li class="alert alert-success">{!! \Session::get('success') !!}</li>
        </div>
        @endif
    </div>
</div>
@endsection