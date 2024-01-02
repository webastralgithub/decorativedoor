<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-category|edit-category|delete-category', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-category', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-category', ['only' => ['destroy']]);
    }

    public function index(): View
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        return view('admin.category.index', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->parent_id
        ]);

        return redirect()->route('category.index')->with('success',  'Category has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.category.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {

        $categories = Category::where('parent_id', null)->where('id', '!=', $category->id)->orderby('name', 'asc')->get();
        return view('admin.category.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $validator = $request->validate([
            'name'     => 'required',
            'slug' => ['required', Rule::unique('categories')->ignore($category->id)],
            'parent_id' => 'nullable|numeric'
        ]);

        if ($request->name != $category->name || $request->parent_id != $category->parent_id) {
            if (isset($request->parent_id)) {
                $checkDuplicate = Category::where('name', $request->name)->where('parent_id', $request->parent_id)->first();
                if ($checkDuplicate) {
                    return redirect()->route('category.index')->with('error', 'Category already exist in this parent.');
                }
            } else {
                $checkDuplicate = Category::where('name', $request->name)->where('parent_id', null)->first();
                if ($checkDuplicate) {
                    return redirect()->route('category.index')->with('error', 'Category already exist with this name.');
                }
            }
        }

        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->slug = $request->slug;
        $category->save();
        return redirect()->route('category.index')->with('success',  'Category has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if (count($category->subcategory)) {
            $subcategories = $category->subcategory;
            foreach ($subcategories as $cat) {
                $cat = Category::findOrFail($cat->id);
                $cat->parent_id = null;
                $cat->save();
            }
        }
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category has been deleted successfully.');
    }
}
