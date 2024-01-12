<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Inventory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Str;

class ProductController extends Controller
{
    /**
     * Instantiate a new ProductController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-product|edit-product|delete-product', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $products = Product::when(isset($request->q), function ($query) use ($request) {

            $query->whereRaw("(title LIKE '%" . $request->q . "%')");
        })->latest()->paginate(env('RECORD_PER_PAGE', 10));
        return view('admin.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all(['id', 'name']);
        $selectedCategories = 0;
        return view('admin.products.create', compact('categories', 'selectedCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        // dd($request->all());
        $product = new Product();
        $product->title = $request->title;
        $product->sub_title = $request->sub_title;
        $product->meta_title = $request->meta_title;
        $product->meta_keywords = $request->meta_keywords;
        $product->meta_description = $request->meta_description;
        $product->slug = $request->slug;
        $product->notes = $request->notes;
        $product->short_description = $request->short_description;
        $product->code = $request->code;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->tax = $request->tax;
        $product->quantity = $request->quantity;

        $categories = Category::whereIn('id', $request->category_id)->get();
        $product->save();

        if (isset($request->product_images) && $request->product_images) {
            foreach ($request->product_images as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key . '.' . $image->extension();
                $image->storeAs('public/products', $imgName);

                // Store images in relational table
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $imgName,
                ]);
            }
        }

        $product->categories()->attach($categories);
        // Create Variants
        if (!empty($request->variant_option) && !empty($request->variant_name))
            $this->createVariants($request, $product->id);
        return redirect()->route('products.index')
            ->withSuccess('Product has been created successfully!');
    }

    public function createVariants($request, $productId)
    {
        $variantNames = $request->input('variant_name');
        $variant_option_type = $request->input('variant_option_type');
        $variant_value = $request->input('variant_value');
        $variant_code = $request->input('variant_code');
        $variant_quantity = $request->input('variant_quantity');
        $variant_buying_price = $request->input('variant_buying_price');
        $variant_selling_price = $request->input('variant_selling_price');
        $variant_notes = $request->input('variant_notes');

        foreach ($variantNames as $key => $variant) {

            $variantName = explode('/', $variant);

            $product = new ProductVariant();
            $product->product_id = $productId;
            $product->name = !empty($variant) ? $variant : '';
            $product->option_type = !empty($variant_option_type[$key]) ? $variant_option_type[$key] : '';
            $product->value = !empty($variantName[0]) ? $variantName[0] : '';
            $product->code  = !empty($variant_code[$key]) ? $variant_code[$key] : Str::random(10, 1200);
            $product->quantity = !empty($variant_quantity[$key]) ? $variant_quantity[$key] : $key;
            $product->buying_price = !empty($variant_buying_price[$key]) ? $variant_buying_price[$key] : $key;
            $product->selling_price = !empty($variant_selling_price[$key]) ? $variant_selling_price[$key] : $key;
            $product->notes = !empty($variant_notes[$key]) ? $variant_notes[$key] : '';
            $product->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        return view('admin.products.show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all(['id', 'name']);
        $selectedCategories = $product->categories->pluck('id')->toArray();
        $productImages = ProductImage::where('product_id',$product->id)->get();

        $inventory = Inventory::where('product_id',$product->id)->get();

        return view('admin.products.edit', compact('product', 'inventory', 'productImages','categories', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        // echo print_r($request->all(), true);die();    
        $product->update($request->only([
            'title', 'sub_title', 'meta_title', 'meta_keywords', 'meta_description',
            'notes', 'buying_price', 'tax', 'short_description','selling_price'
        ]));

        // Update category
        $category = Category::find($request->category_id);
        $product->categories()->sync([$category->id]);

        // Update images
        if (isset($request->product_images) && $request->product_images) {
            foreach ($request->product_images as $key => $image) {
                $imgName = Carbon::now()->timestamp . $key . '.' . $image->extension();
                $image->storeAs('public/products', $imgName);

                // Store images in relational table
                ProductImage::updateOrCreate(
                    ['product_id' => $product->id, 'path' => $imgName],
                    ['path' => $imgName]
                );
            }
        }

        // Update variants
    
        $this->updateVariants($request, $product->id);
        
        
       // $product->update($request->all());
        return redirect()->back()
            ->withSuccess('Product is updated successfully.');
    }

    public function updateVariants($request, $productId)
    {
        ProductVariant::where('product_id', $productId)->delete();
        
        $variantNames = $request->input('variant_name');
        $variant_option_type = $request->input('variant_option_type');
        $variant_value = $request->input('variant_value');
        $variant_code = $request->input('variant_code');
        $variant_quantity = $request->input('variant_quantity');
        $variant_buying_price = $request->input('variant_buying_price');
        $variant_selling_price = $request->input('variant_selling_price');
        $variant_notes = $request->input('variant_notes');
        if(!empty($variantNames)){
            foreach ($variantNames as $key => $variant) {

                $variantName = explode('/', $variant);
    
                $product = new ProductVariant();
                $product->product_id = $productId;
                $product->name = !empty($variant) ? $variant : '';
                $product->option_type = !empty($variant_option_type[$key]) ? $variant_option_type[$key] : '';
                $product->value = !empty($variantName[0]) ? $variantName[0] : '';
                $product->code  = !empty($variant_code[$key]) ? $variant_code[$key] : Str::random(10, 1200);
                $product->quantity = !empty($variant_quantity[$key]) ? $variant_quantity[$key] : $key;
                $product->buying_price = !empty($variant_buying_price[$key]) ? $variant_buying_price[$key] : $key;
                $product->selling_price = !empty($variant_selling_price[$key]) ? $variant_selling_price[$key] : $key;
                $product->notes = !empty($variant_notes[$key]) ? $variant_notes[$key] : '';
                $product->save();
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->variants()->delete();
        $product->delete();
        return redirect()->route('products.index')
            ->withSuccess('Product is deleted successfully.');
    }
}
