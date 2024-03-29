<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{route('dashboard')}}" class="navbar-brand mx-4 mt-3">
            <h3>Sunrise Doors </h3>
        </a>
        <div class="navbar-nav w-100">
            <a class="nav-item nav-link {{ request()->is('*/dashboard') ? 'active' : '' }}"
                href="{{route('dashboard')}}">
                <img src="{{asset('img/side-icon1.svg')}}" class="img" /> Dashboard</a>

            @if (auth()->user()->hasRole('Product Assembler'))
            @canany(['create-order', 'edit-order', 'delete-order','change-order-status'])
            <a class="nav-item nav-link {{ request()->is('*/assembler-order') ? 'active' : '' }}"
                href="{{ route('order-assembler') }}">
                <img src="{{asset('img/order-icon.svg')}}" class="img" />Orders</a>
            @endcanany
            @else
            @canany(['create-order', 'edit-order', 'delete-order','change-order-status'])
            <a class="nav-item nav-link {{ request()->is('*/orders') ? 'active' : '' }}"
                href="{{ route('orders.index') }}">
                <img src="{{asset('img/order-icon.svg')}}" class="img" />Orders</a>
            @endcanany
            @endif

            @canany(['create-product', 'edit-product', 'delete-product'])
            <a class="nav-item nav-link {{ request()->is('*/inventory') ? 'active' : '' }}"
                href="{{ route('inventory.index') }}">
                <img src="{{asset('img/inventory.svg')}}" class="img" />Inventory</a>
            @endcanany

            @canany(['create-product', 'edit-product', 'delete-product'])
            <a class="nav-item nav-link {{ request()->is('*/products') ? 'active' : '' }}"
                href="{{ route('products.index') }}">
                <img src="{{asset('img/products-icon.svg')}}" class="img" />Products</a>
            @endcanany
            @canany(['create-category', 'edit-category', 'delete-category,create-product', 'edit-product',
            'delete-product','create-user', 'edit-user', 'delete-user,create-role', 'edit-role', 'delete-role'])
            <div class="nav-item dropdown">
                <a href="#" class="nav-item nav-link dropdown-toggle toggle-menu-dropdown" data-bs-toggle="dropdown">
                    <img src="{{asset('img/administration.svg')}}" class="img" /></i>Administration</a>
                <div class="dropdown-menu bg-transparent border-0 toggle-menu">
                    @endcanany
                    @canany(['create-user', 'edit-user', 'delete-user'])
                    <a class="nav-item nav-link {{ request()->is('*/users') ? 'active' : '' }}"
                        href="{{ route('users.index') }}">
                        <img src="{{asset('img/8666755_users_group_icon.svg')}}" class="img" /></i>Users</a>
                    @endcanany

                    @canany(['create-role', 'edit-role', 'delete-role'])
                    <a class="nav-item nav-link {{ request()->is('*/roles') ? 'active' : '' }}"
                        href="{{ route('roles.index') }}">
                        <img src="{{asset('img/4634467_category_interface_link_categories_icon.svg')}}"
                            class="img" /></i>Roles</a>
                    @endcanany

                    @canany(['create-category', 'edit-category', 'delete-category'])
                    <a class="nav-item nav-link {{ request()->is('*/category') ? 'active' : '' }}"
                        href="{{ route('category.index') }}">
                        <img src="{{asset('img/103432_category_icon.svg')}}" class="img" /></i>Categories</a>
                    @endcanany
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Sidebar End -->