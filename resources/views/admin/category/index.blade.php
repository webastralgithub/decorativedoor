@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
      <h3>Manage Categories</h3> 
         <form >
            <input type="search" class="form-control" placeholder="Find Category" name="q" value="{{ request('q') }}">
        </form>
      <div class="top-bntspg-hdr">
        @can('create-category')
        <a href="{{ route('category.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Category</a>
        @endcan
        @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
            <li class="alert alert-danger">{{ $error }}</li>
            @endforeach
        </div>
        @endif

      </div>
    </div>
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
    <div class="content-body">

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Parent Category</th>
                    <th>Category Name</th>
                    <th>Category Url</th>
                    <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($categories))
                <?php $_SESSION['i'] = 0; ?>
                @foreach($categories as $category)

                @if(!isset($category->parent_id))
                <?php $_SESSION['i'] = $_SESSION['i'] + 1; ?>
                <tr>
                    <?php $dash = ''; ?>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="visually-hidden"><i class="bi bi-pencil-square"></i></span>
                            </button>
                            <ul class="dropdown-menu">
                                <form action="{{ route('category.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                        
                                    @can('edit-category')
                                    <li><a href="{{ route('category.edit', $category->id) }}" class="dropdown-item"><i
                                                class="bi bi-pencil-square"></i> Edit</a></li>
                                    @endcan
                        
                                    @can('delete-category')
                                    <li><button type="submit" class="dropdown-item btn-danger"
                                            onclick="return confirm('Do you want to delete this Category?');"><i class="bi bi-trash"></i>
                                            Delete</button></li>
                                    @endcan
                                </form>
                            </ul>
                        </div>
                    </td>
                    <td>
                        @if(isset($category->parent_id) && !empty($category->subcategory->name))
                        <a href="{{ route('category.edit', $category->id) }}">{{ $category->subcategory->name ?? 'None' }}</a>
                        @else
                        None
                        @endif
                    </td>
                    <td> <a href="{{ route('category.edit', $category->id) }}">{{$category->name}}</a></td>
                    <td>{{$category->slug}}</td>
                </tr>
                @endif
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