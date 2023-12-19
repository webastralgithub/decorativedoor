@extends('admin.layouts.app')

@section('content')
<div class="card mx-4">
    <div class="card-header">Manage Categories</div>
    <div class="card-body">
        @can('create-category')
        <a href="{{ route('category.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Category</a>
        @endcan
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Category Name</th>
                    <th>Category Slug</th>
                    <th>Parent Category</th>
                    <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($categories))
                <?php $_SESSION['i'] = 0; ?>
                @foreach($categories as $category)
                <?php $_SESSION['i'] = $_SESSION['i'] + 1; ?>
                <tr>
                    <?php $dash = ''; ?>
                    <td>{{$_SESSION['i']}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->slug}}</td>
                    <td>
                        @if(isset($category->parent_id) && !empty($category->subcategory->name))
                        {{$category->subcategory->name}}
                        @else
                        None
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('category.destroy', $category->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('category.show', $category->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>
                            @can('edit-role')
                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endcan

                            @can('delete-role')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this Category?');"><i class="bi bi-trash"></i> Delete</button>
                            @endcan

                        </form>
                    </td>
                </tr>
                @if(count($category->subcategory))
                @include('admin.category.sub-category-list',['subcategories' => $category->subcategory])
                @endif
                @endforeach
                <?php unset($_SESSION['i']); ?>
                @endif
            </tbody>
        </table>


    </div>
</div>
@endsection