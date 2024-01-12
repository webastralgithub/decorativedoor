@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Add New Product</h3> 
        <div class="top-bntspg-hdr">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="body-content-new">
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
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">
                                    {{ __('Product Create') }}
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row row-cards">
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        Product Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="title" id="name" class="form-control product-title" placeholder="Product name" value="{{ old('title') }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        Url
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="slug" id="name" class="form-control product-slug" placeholder="Product Slug" value="{{ old('slug') }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        SKU
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="code" id="productcode" class="form-control product-code" placeholder="SKU" value="{{ old('product_code') }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        Sub Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="sub_title" id="name" class="form-control" placeholder="Sub Title" value="{{ old('sub_title') }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        Meta Title
                                    </label>
                                    <input name="meta_title" id="name" class="form-control" placeholder="Meta Title" value="{{ old('meta_title') }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        Meta Keywords
                                    </label>
                                    <input name="meta_keywords" id="name" class="form-control" placeholder="Meta Keywords" value="{{ old('meta_keywords') }}" />
                                </div>
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Meta Description
                                    </label>
                                    <textarea name="meta_description" id="editor" rows="5" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Meta Description"></textarea>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">
                                            Product Category
                                            <span class="text-danger">*</span>
                                        </label>

                                        @if ($categories->count() === 1)
                                        <select type="text" name="category_id[]" class="select-category form-control form-select @error('category_id') is-invalid @enderror" multiple>
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
                                        @else
                                        <select name="category_id[]" id="category_id" class="select-category form-select @error('category_id') is-invalid @enderror" multiple>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if(old('category_id')==$category->id) selected="selected" @endif>
                                                {{ $category->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @endif

                                        @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Buying Price') }}
                                    </label>
                                    <input type="number" label="Buying Price" class="form-control" name="buying_price" id="buying_price" placeholder="0" value="{{ old('buying_price') }}" min="0"  />
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Selling Price') }}
                                    </label>
                                    <input type="number" label="Selling Price" class="form-control" name="selling_price" id="selling_price" placeholder="0" value="{{ old('selling_price') }}" min="0"/>
                                </div>
                                <input type="hidden" name="quantity" value="0">
                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Tax') }}
                                    </label>
                                    <input type="number" label="Tax" name="tax" class="form-control" id="tax" placeholder="0" value="{{ old('tax') }}" min="0" />
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">
                                            {{ __('Notes') }}
                                        </label>

                                        <textarea name="notes" id="notes" rows="5" class="form-control @error('notes') is-invalid @enderror" placeholder="Product notes"></textarea>
                                        @error('notes')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">
                                            {{ __('Short Description') }}
                                        </label>

                                        <textarea name="short_description" id="short_description" rows="5" class="form-control @error('short_description') is-invalid @enderror" placeholder="Product Short Description"></textarea>
                                        @error('short_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-4">
                        <div class="card-body product-imguploads">
                            <h3 class="card-title">
                                {{ __('Product Images') }}
                            </h3>
                            <!-- <img class="img-account-profile mb-2" src="{{ asset('img/product/default.webp') }}" alt="" id="image-preview" /> -->

                            <div class="mt-1 text-center">
                                <div class="images-preview-div"> </div>
                            </div>
                            <div class="small font-italic text-muted mb-2">
                                JPG or PNG no larger than 2 MB
                            </div>
                            <input type="file" accept="image/*" id="image" name="product_images[]" class="form-control @error('product_images') is-invalid @enderror" onchange="previewImages(this, 'div.images-preview-div') /*previewImage(); */;" multiple>
                            @error('product_images')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            @include('admin.products.product-variant')

            <div class="card-ftr text-end">
                <div class="mb-3 row mt-4">
                    <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="{{ __('Save Product') }}">
                </div>
            </div>
        </form>
    </div>

</div>

@endsection
@section('scripts')
<script>
    jQuery('.select-category').select2({
        theme: "classic"
    });
</script>


@endsection