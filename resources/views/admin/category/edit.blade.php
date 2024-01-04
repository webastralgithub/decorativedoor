@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Edit Category</h3>
            
        <div class="top-bntspg-hdr">
            <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="body-content-new">
        <form action="{{ route('category.update', $category->id) }}" method="post">
            @csrf
            @method("PUT")
            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Category name*</label>
                <div class="col-md-8">
                    <input type="text" name="name" class="form-control" placeholder="Category name" value="{{$category->name}}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Category Url*</label>
                <div class="col-md-8">
                    <input type="text" name="slug" class="form-control" placeholder="Category Url" value="{{$category->slug}}" required />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-md-4 col-form-label text-md-end text-start">Select parent category*</label>
                <div class="col-md-8">
                    <select type="text" name="parent_id" class="select-category form-control">
                        <option value="">None</option>
                        @if($categories)
                        @foreach($categories as $item)
                        @if(!isset($item->parent_id))
                        <?php $dash = ''; ?>
                        <option value="{{$item->id}}" @if($category->parent_id == $item->id ) selected @endif>{{$item->name}}</option>
                        @endif
                        @if(count($item->subcategory))
                        @include('admin.category.sub-category-update',['subcategories' => $item->subcategory])
                        @endif
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <input type="submit" class="col-md-4 offset-md-6 btn btn-primary" value="Update Category">
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