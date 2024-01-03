@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Manage Roles</h3>

        <div class="top-bntspg-hdr">
        @can('create-role')
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Role</a>
        @endcan
        </div>
    </div>

    <div class="content-body">

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Permissions</th>
                    <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $role->name }}</td>
                    <td>
                        @if ($role->name=='Super Admin')
                        <span class="badge bg-primary">All</span>
                        @else
                        @php
                        $rolePermissions = \App\Models\Permission::join("role_has_permissions", "permission_id", "=", "id")
                        ->where("role_id", $role->id)
                        ->select('name')
                        ->get();
                        @endphp
                        @forelse ($rolePermissions as $permission)
                        <span class="badge bg-primary">{{ $permission->name }}</span>
                        @empty
                        @endforelse
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <!-- <a href="{{ route('roles.show', $role->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a> -->

                            @if ($role->name != 'Super Admin')
                            @can('edit-role')
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endcan

                            @can('delete-role')
                            @if ($role->name!=Auth::user()->hasRole($role->name))
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this role?');"><i class="bi bi-trash"></i> Delete</button>
                            @endif
                            @endcan
                            @endif

                        </form>
                    </td>
                </tr>
                @empty
                <td colspan="3">
                    <span class="text-danger">
                        <strong>No Role Found!</strong>
                    </span>
                </td>
                @endforelse
            </tbody>
        </table>
        {{ $roles->links() }}

    </div>
</div>
@endsection