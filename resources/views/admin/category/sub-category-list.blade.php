<?php $dash .= '-- '; ?>
@foreach($subcategories as $subcategory)
<?php $_SESSION['i'] = $_SESSION['i'] + 1; ?>
<tr>
    <td>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden cogs-btn"><i class="fa fa-cog" aria-hidden="true"></i></span>
            </button>
            <ul class="dropdown-menu">
                <form action="{{ route('category.destroy', $subcategory->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    @can('edit-subcategory')
                    <li><a href="{{ route('category.edit', $subcategory->id) }}" class="dropdown-item"><i
                                class="bi bi-pencil-square"></i> Edit</a></li>
                    @endcan

                    @can('delete-subcategory')
                    <li><button type="submit" class="dropdown-item btn-danger"
                            onclick="return confirm('Do you want to delete this Subcategory?');"><i class="bi bi-trash"></i>
                            Delete</button></li>
                    @endcan
                </form>
            </ul>
        </div>
    </td>
    <td><a href="{{ route('category.edit', $subcategory->id) }}">{{$subcategory->parent->name}}</a></td>
    <td> <a href="{{ route('category.edit', $subcategory->id) }}">{{$dash}}{{$subcategory->name}}</a></td>
    <td>{{$subcategory->slug}}</td>
</tr>
@if(count($subcategory->subcategory) > 1)
@include('admin.category.sub-category-list',['subcategories' => $subcategory->subcategory])
@endif
@endforeach