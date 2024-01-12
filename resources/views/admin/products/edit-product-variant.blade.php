<div class="card mt-3">
    <div class="card-header">
        <div>
            <h3 class="card-title">
                {{ __('Product Variants') }}
            </h3>
        </div>
    </div>
    <div class="card-body product-variants">
        <div class="variantForm edit">
            @php
            $variantSingle = $product->variants;
            $variantSingle = $variantSingle->first();
            $variantOptions = !empty($variantSingle->option_type) ? json_decode($variantSingle->option_type, true) : null;
            @endphp
            @if (!empty($variantOptions))
            {{-- Access the decoded JSON data --}}
            @foreach ($variantOptions as $key => $variant)
            <div class="row row-cards">
                <div class="col-sm-3 col-md-3">
                    <label for="category_id" class="form-label">
                        Option
                        <span class="text-danger">*</span>
                    </label>
                    <input name="variant_option[]" id="option" class="form-control" placeholder="Like Size, Color..." value="{{$variant['variantType']}}" />
                </div>

                <div class="col-sm-8 col-md-8">
                    <label for="category_id" class="form-label">
                        Value
                        <span class="text-danger">*</span>
                    </label>
                    <input name="variant_option_value[]" id="variant-value" class="form-control" style="display: none;" value="" />
                    <span class="input-tags">
                        <span class="tag-container" id="tagContainer" data-count="1">
                            @if(!empty($variant['tagNames']) && is_array($variant['tagNames']))
                            @foreach($variant['tagNames'] as $tag)
                            <span class="tag">
                                <span class="tag-text">{{$tag}}</span>
                                <button type="button" class="close" aria-label="Close">×</button>
                            </span>
                            @endforeach
                            @endif
                        </span>
                        <div id="variant_addTag">
                            <input data-check="existing" id="variant-tags" class="edit-variant-tags form-control tag-input error" value="" placeholder="Enter variant value seperated by comma" />
                        </div>

                    </span>
                </div>
                {{-- <div class="col-sm-1 col-md-1">                   
                    <span class="remove-input-tags">
                        <button type="button" id="remove-input-variant" class="close-row btn btn-primary" aria-label="Close">×</button>
                    </span>
                </div> --}}
            </div>
            @endforeach
            @else
            <div class="row row-cards">
                <div class="col-sm-3 col-md-3">
                    <label for="category_id" class="form-label">
                        Option
                        <span class="text-danger">*</span>
                    </label>
                    <input name="variant_option[]" id="option" class="form-control" placeholder="Like Size, Color..." value="" />
                </div>

                <div class="col-sm-8 col-md-8">
                    <label for="category_id" class="form-label">
                        Value
                        <span class="text-danger">*</span>
                    </label>
                    <input name="variant_option_value[]" id="variant-value" class="form-control" style="display: none;" value="" />
                    <span class="input-tags">
                        <span class="tag-container" id="tagContainer">
                        </span>
                        <div id="variant_addTag">
                            <input data-check="new" id="variant-tags" class="edit-variant-tags form-control tag-input error" value="" placeholder="Enter variant value seperated by comma" />
                        </div>

                    </span>
                </div>
                {{-- <div class="col-sm-1 col-md-1">                   
                    <span class="remove-input-tags">
                        <button type="button" id="remove-input-variant" class="close-row  btn btn-primary" aria-label="Close">×</button>
                    </span>
                </div> --}}
            </div>
            @endif
        </div>

        <div class="mx-3 row variant-btn">
            <input type="button" class="col-md-3 offset-md-5 btn btn-primary add-more-variant" value="{{ __('+ Add More Variant') }}">
        </div>

        <div class="mt-3 row">
            <table id="variantsTable" class="table table-striped table-bordered edit-variant-table" style="@if($product->variants->count() <= 0)display: none;@endif">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Code</th>
                        <th>Quantity</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->variants->all() as $variant)
                    <tr>
                        <input type="hidden" name="variant_option_type[]" class="form-control" value='{{$variant->option_type}}'>
                        <td><input type="text" name="variant_name[]" class="form-control" placeholder="Enter Name" value="{{$variant->name}}"></td>
                        <td><input type="text" name="variant_value[]" class="form-control" placeholder="Enter Value" value="{{$variant->value}}"></td>
                        <td><input type="text" name="variant_code[]" class="form-control" placeholder="Enter Code" value="{{$variant->code}}"></td>
                        <td><input type="text" name="variant_quantity[]" class="form-control" placeholder="Enter Quantity" value="{{$variant->quantity}}"></td>
                        <td><input type="text" name="variant_buying_price[]" class="form-control" placeholder="Enter Buying Price" value="{{$variant->buying_price}}"></td>
                        <td><input type="text" name="variant_selling_price[]" class="form-control" placeholder="Enter Selling Price" value="{{$variant->selling_price}}"></td>
                        <td><input type="text" name="variant_notes[]" class="form-control" placeholder="Enter Notes" value="{{$variant->notes}}"></td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>