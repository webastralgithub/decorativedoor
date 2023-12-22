<?php $dash .= '-- '; ?>
@foreach($subcategories as $subcategory)
<?php $_SESSION['i'] = $_SESSION['i'] + 1; ?>
<tr>
    <td>{{$_SESSION['i']}}</td>
    <td>{{$dash}}{{$subcategory->name}}</td>
    <td>{{$subcategory->slug}}</td>
    <td>{{$subcategory->parent->name}}</td>
    <td>
        <form action="{{ route('category.destroy', $subcategory->id) }}" method="post">
            @csrf
            @method('DELETE')

            <!-- <a href="{{ route('category.show', $subcategory->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a> -->
            @can('edit-role')
            <a href="{{ route('category.edit', $subcategory->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
            @endcan

            @can('delete-role')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this Category?');"><i class="bi bi-trash"></i> Delete</button>
            @endcan

        </form>
    </td>
</tr>
@if(count($subcategory->subcategory) > 1)
@include('admin.category.sub-category-list',['subcategories' => $subcategory->subcategory])
@endif
@endforeach