@extends('admin.layouts.app')

@section('content')
<style>
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        /* background-color: #f9f9f9; */
        min-width: 160px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        padding: 12px;
        z-index: 1;

        width: 100%;
        background: white;
    }

    .checkbox-item {
        margin-bottom: 8px;
    }
</style>
<div class="card mx-4">
    <div class="card-header">
        <div class="float-start">
            Add New Role
        </div>
        <div class="float-end">
            <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('roles.store') }}" method="post">
            @csrf

            <div class="mb-3 row">
                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                <div class="col-md-6">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <label for="permissions" class="col-md-4 col-form-label text-md-end text-start">Permissions</label>
                <div class="col-md-6">
                    <!-- <select class="form-select @error('permissions') is-invalid @enderror" multiple aria-label="Permissions" id="permissions" name="permissions[]" style="height: 210px;">
                        @forelse ($permissions as $permission)
                        <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                            {{ $permission->name }}
                        </option>
                        @empty

                        @endforelse
                    </select> -->
                    <div id="myDropdownSelect" class="form-select dropdown @error('permissions') is-invalid @enderror">
                        <div onclick="toggleDropdown()">Select Permissions</div>
                        <div id="myDropdown" class="dropdown-content">
                            @forelse ($permissions as $permission)
                            <div class="checkbox-item">
                                <input type="checkbox" id="option1" name="permissions[]" value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions ?? []) ? 'checked' : '' }}>
                                <label for="option1">{{ $permission->name }}</label>
                            </div>
                            @endforeach
                            <!-- Add more checkboxes as needed -->
                        </div>
                    </div>
                    @if ($errors->has('permissions'))
                    <span class="text-danger">{{ $errors->first('permissions') }}</span>
                    @endif
                </div>
            </div>

            <div class="mb-3 row">
                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Role">
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('click', function(event) {
        var dropdown = document.getElementById('myDropdownSelect');
        var myDropdown = document.getElementById('myDropdown');
        if (!dropdown.contains(event.target)) {
            myDropdown.style.display = 'none';
        }
    });

    function toggleDropdown() {
        console.log('click');
        // document.getElementById("myDropdown").classList.toggle("show");
        var dropdown = document.getElementById("myDropdown");
        // Get the computed style of the dropdown
        var computedStyle = window.getComputedStyle(dropdown);
        // Check the display property
        if (computedStyle.display === 'none') {
            // If display is 'none', show the dropdown
            dropdown.style.display = 'block';
        } else {
            // If display is not 'none', hide the dropdown
            dropdown.style.display = 'none';
        }
    }

    window.onclick = function(event) {
        if (!event.target.matches('.dropdown button')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>
@endsection