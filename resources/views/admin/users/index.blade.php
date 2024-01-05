@extends('admin.layouts.app')

@section('content')

<div class="mx-4 content-p-mobile">
    <div class="page-header-tp">
        <h3>Manage Users</h3>
        
        <div class="top-bntspg-hdr">
        @can('create-user')
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New User</a>
        @endcan
        @can('create-permission')
        <a href="{{ route('permissions.index') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Manage Permissions</a>
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
                    <th scope="col">Action</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Roles</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td>
                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <!-- <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a> -->

                            @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                            @if (Auth::user()->hasRole('Super Admin'))
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endif
                            @else
                            @can('edit-user')
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            @endcan

                            @can('delete-user')
                            @if (Auth::user()->id!=$user->id)
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this user?');"><i class="bi bi-trash"></i> Delete</button>
                            @endif
                            @endcan
                            @endif

                        </form>
                    </td>
                    <td> <a href="{{ route('users.edit', $user->id) }}">{{ $user->name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @forelse ($user->getRoleNames() as $role)
                        {{ $role }}
                        @empty
                        @endforelse
                    </td>
                </tr>
                @empty
                <td colspan="5">
                    <span class="text-danger">
                        <strong>No User Found!</strong>
                    </span>
                </td>
                @endforelse
            </tbody>
        </table>

        {{ $users->links() }}

    </div>
</div>

@endsection