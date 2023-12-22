<?php $dash .= '-- '; ?>
@foreach($subcategories as $subcategory)
<option value="{{$subcategory->id}}" {{ isset($selectedCategories) && in_array($subcategory->id, $selectedCategories) ? 'selected' : '' }}>{{$dash}}{{$subcategory->name}}</option>
@if(count($subcategory->subcategory))
@include('admin.category.sub-category',['subcategories' => $subcategory->subcategory])
@endif
@endforeach