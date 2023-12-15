<div class="card mt-3">
    <div class="card-header">
        <div>
            <h3 class="card-title">
                {{ __('Product Variants') }}
            </h3>
        </div>
    </div>
    <div class="card-body product-variants">
        <div class="variantForm">
            <div class="row row-cards">
                <div class="col-sm-4 col-md-4">
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
                        <span class="tag-container" id="tagContainer" data-count="1">
                        </span>
                        <div id="variant_addTag">
                            <input id="variant-tags" class="variant-tags form-control tag-input error" value="" placeholder="Enter variant value seperated by comma" />
                        </div>

                    </span>
                </div>
            </div>
        </div>

        <div class="mx-3 row variant-btn">
            <input type="button" class="col-md-3 offset-md-5 btn btn-primary add-more-variant" value="{{ __('+ Add More Variant') }}">
        </div>

        <div class="mt-3 row">
            <table id="variantsTable" class="table table-striped table-bordered" style="display: none;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Value</th>
                        <th>Code</th>
                        <th>Quantity</th>
                        <th>Buying Price</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>