@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Update Product</h3>   
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
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3 class="card-title">
                                    {{ __('Product Update') }}
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
                                    <input name="title" id="name" class="form-control product-title" placeholder="Product name" value="{{ $product->title }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                    Url
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="slug" id="name" class="form-control product-slug" placeholder="Product Slug" value="{{ $product->slug }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        SKU
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="code" id="productcode" class="form-control product-code" placeholder="SKU" value="{{ $product->code }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        Sub Title
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="sub_title" id="name" class="form-control" placeholder="Sub Title" value="{{ $product->sub_title }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        Meta Title
                                    </label>
                                    <input name="meta_title" id="name" class="form-control" placeholder="Meta Title" value="{{ $product->meta_title }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="category_id" class="form-label">
                                        Meta Keywords
                                    </label>
                                    <input name="meta_keywords" id="name" class="form-control" placeholder="Meta Keywords" value="{{ $product->meta_keywords }}" />
                                </div>
                                <div class="col-md-12">
                                    <label for="category_id" class="form-label">
                                        Meta Description
                                    </label>
                                    <textarea name="meta_description" id="editor" rows="5" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Meta Description">{{ $product->meta_description }}</textarea>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">
                                            Product Category
                                            <span class="text-danger">*</span>
                                        </label>

                                        @if ($categories->count() === 1)
                                        <select type="text" name="parent_id" class="select-category form-control form-select @error('category_id') is-invalid @enderror" multiple>
                                            <option value="">None</option>
                                            @if($categories)
                                            @foreach($categories as $category)
                                            <?php $dash = ''; ?>
                                            <option value="{{$category->id}}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>{{$category->name}}</option>
                                            @if(count($category->subcategory))
                                            @include('admin.category.sub-category',['subcategories' => $category->subcategory])
                                            @endif
                                            @endforeach
                                            @endif
                                        </select>
                                        @else
                                        <select name="category_id" id="category_id" class="select-category form-select @error('category_id') is-invalid @enderror" multiple>
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
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
                                    <input type="number" label="Buying Price" class="form-control" name="buying_price" id="buying_price" placeholder="0" value="{{ $product->buying_price }}" min="0" />
                                </div>

                                <div class="col-sm-4 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Selling Price') }}
                                    </label>
                                    <input type="number" label="Selling Price" class="form-control" name="selling_price" id="selling_price" placeholder="0" value="{{ $product->selling_price }}" min="0" />
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <span class="dots-assigned cursor-pointer btn btn-primary"  onclick="return ManageInventory('{{$product->id}}');">Manage Inventory</span>
                                    {{-- <label for="notes" class="form-label">
                                        {{ __('Quantity') }} 
                                    </label> --}}
                                    <input type="hidden" label="Quantity" class="form-control" name="quantity" id="quantity" placeholder="0" value="{{ $product->quantity }}" />
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label for="notes" class="form-label">
                                        {{ __('Tax') }}
                                    </label>
                                    <input type="number" label="Tax" name="tax" class="form-control" id="tax" placeholder="0" value="{{ $product->tax }}" min="0" />
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">
                                            {{ __('Notes') }}
                                        </label>

                                        <textarea name="notes" id="notes" rows="5" class="form-control @error('notes') is-invalid @enderror" placeholder="Product notes">{{ $product->notes }}</textarea>
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

                                        <textarea name="short_description" id="short_description" rows="5" class="form-control @error('short_description') is-invalid @enderror" placeholder="Product Short Description">{{ $product->short_description }}</textarea>
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
                    <div class="card">
                        <div class="card-body product-imguploads">
                            <h3 class="card-title">
                                {{ __('Product Image') }}
                            </h3>
                            <!-- <img class="img-account-profile mb-2" src="{{ asset('img/product/default.webp') }}" alt="" id="image-preview" /> -->
                           
                            <div class="mt-1 text-center">
                            <div class="images-preview-div">
                            @foreach($productImages AS $image)                           
                                <span class="delete_image delete_{{$image->id}}" onclick="return ImageDelete('{{$image->id}}');" data-id="{{$image->id}}"><i class="fa fa-close"></i></span>                          
                                <img class="delete_{{$image->id}}" src="{{ asset('storage/products/' . $image->path)}}" data-id="{{$image->id}}">                            
                            @endforeach
                            </div> 
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

            @include('admin.products.edit-product-variant')

            <div class="card-ftr text-end">
                <div class="mb-3 row mt-4">
                    <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="{{ __('Save Product') }}">
                </div>
            </div>
        </form>
    </div>
    <form id="addressForm" class="edit-inventory-popup" style="display: none;">
            <div class="inventory_info">
                <p><strong>On Hold Quantity :</strong> {{ getProductOnhandAvailabityStock($product->id) }}</p>
                <p><strong>On Order Quantity :</strong> {{ getProductOnorderAvailabityStock($product->id) }}</p>
                <p><strong>Available Quantity :</strong> {{ getProductAvailabityStock($product->id) }}</p>
            </div>

            
        <div class="mb-3 row">
            <div class="col-md-12 flex">
                <label for="waybill" class="col-md-3 col-form-label text-md-end text-start">
                    {{ __('Waybill') }}
                    <span class="text-danger">*</span>
                </label>
                <input type="hidden" id="product_id" name="product_id" value=" {{ $product->id }}">
                <div class="col-md-9" style="line-height: 35px;">
                    <input name="waybill" id="waybill" type="text" class="form-control example-date-input @error('waybill') is-invalid @enderror" value="{{ old('waybill') }}" required>
                </div>
            </div>
        </div>
       
        <div class="mb-3 row">
            <div class="col-md-12 flex">
                <label for="quantity" class="col-md-3 col-form-label text-md-end text-start">
                    {{ __('Quantity') }}
                    <span class="text-danger">*</span>
                </label>
                <div class="col-md-9" style="line-height: 35px;">
                    <input name="quantity" id="quantity" type="number" class="form-control example-date-input @error('quantity') is-invalid @enderror" value="{{ old('Quantity') }}" required>
                </div>
            </div>
        </div>
        <div class="manage-inventory-pop-up-table content-body">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Waybill</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventory as $invent)
                <tr>
                    <td>{{$product->title}}</td>
                    <td>{{ $invent->waybill }}</td>
                    <td>{{ $invent->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
        <!-- <button type="button" onclick="submitAddressForm()">Submit</button> -->
    </form>
</div>
<script>
    async function ImageDelete(ImageId){
        var confirmation = confirm("Are you sure you want to delete this image?");
        if(confirmation){
            jQuery.ajax({
                url: "{{route('product.imges.delete')}}", // Replace with your actual route
                type: 'post',
                data: {
                    image_id: ImageId,
                    _token: '{{ csrf_token() }}' // Add CSRF token if needed
                },
                success: function(response) {
                    // Handle success, if needed
                    jQuery('.delete_'+ImageId).remove();
                   // location.reload();
                },
                error: function(error) {
                    // Handle error, if needed
                    console.error('Error updating order status', error);
                }
            });
        }


    }
     async function ManageInventory(InventoryId, responseType) {
      
      if (InventoryId <= 0) {
          Swal.fire({
              icon: 'warning',
              title: 'User not valid!',
              text: "Please select Sales Person"
          });
          return false;
      }
      await Swal.fire({
         // title: "Add User Address",
          html: document.getElementById('addressForm').innerHTML,
          showCancelButton: true,
          preConfirm: () => {
              const product_id = Swal.getPopup().querySelector('#product_id').value;
              const waybill = Swal.getPopup().querySelector('#waybill').value;
              const quantity = Swal.getPopup().querySelector('#quantity').value;

              if (product_id.trim() === '' || waybill.trim() === '' || quantity.trim() === '') {
                  Swal.showValidationMessage('All fields are required');
              } else {
                  jQuery.ajax({
                      url: "{{route('inventory.store')}}", // Replace with your actual route
                      type: 'post',
                      data: {
                          product_id: product_id,
                          waybill: waybill,
                          quantity: quantity,
                          _token: '{{ csrf_token() }}' // Add CSRF token if needed
                      },
                      success: function(response) {
                          // Handle success, if needed
                          location.reload();
                      },
                      error: function(error) {
                          // Handle error, if needed
                          console.error('Error updating order status', error);
                      }
                  });
                  Swal.close(); // Close the Swal.fire modal
              }
          }
      });
  }
    </script>
@endsection