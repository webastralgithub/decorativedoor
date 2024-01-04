@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Add Category</h3>

        <div class="top-bntspg-hdr">
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="body-content-new">
        <form role="form" action="{{ route('category.store') }}" method="post" method="post">
            @csrf

            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Category name*</label>
                <div class="col-md-8">
                    <input type="text" name="name" class="form-control" placeholder="Category name" value="{{old('name')}}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Category Url*</label>
                <div class="col-md-8">
                    <input type="text" name="slug" class="form-control" placeholder="Category Url" value="{{old('slug')}}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Select parent category*</label>
                <div class="col-md-8">
                    <select type="text" name="parent_id" class="form-control select-category form-control">
                        <option value="">None</option>
                        @if($categories)
                        @foreach($categories as $category)
                        @if(!isset($category->parent_id))
                        <?php $dash = ''; ?>
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                        @if(count($category->subcategory))
                        @include('admin.category.sub-category',['subcategories' => $category->subcategory])
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <input type="submit" class="col-md-4 offset-md-6 btn btn-primary" value="Add Category">
            </div>
        </form>        
    </div>
</div>
@endsection