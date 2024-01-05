@extends('admin.layouts.app')

@section('content')
<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Manage Roles</h3>
        <form >
            <input type="search" class="form-control" placeholder="Find Role" name="q" value="{{ request('q') }}">
        </form>
        <div class="top-bntspg-hdr">
        @can('create-role')
        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Role</a>
        @endcan
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

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col" style="width: 250px;">Action</th>
                    <th scope="col">Name</th>
                    <th scope="col">Permissions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $role)
                <tr>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="visually-hidden"><i class="fa fa-home"></i></span>
                            </button>
                            <ul class="dropdown-menu">
                                <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                    
                                    @if ($role->name != 'Super Admin')
                                    @can('edit-role')
                                    <li><a href="{{ route('roles.edit', $role->id) }}">Edit</a></li>
                                    @endcan
                    
                                    @can('delete-role')
                                    @if ($role->name != Auth::user()->hasRole($role->name))
                                    <li><button type="submit" class="dropdown-item"
                                            onclick="return confirm('Do you want to delete this role?');">Delete</button></li>
                                    @endif
                                    @endcan
                                    @endif
                    
                                </form>
                            </ul>
                        </div>
                    </td>
                    <td><a href="{{ route('roles.edit', $role->id) }}">{{ $role->name }}</a></td>
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