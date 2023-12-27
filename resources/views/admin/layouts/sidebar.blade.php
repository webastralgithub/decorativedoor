 <!-- Sidebar Start -->
 <div class="sidebar pe-4 pb-3">
     <nav class="navbar bg-light navbar-light">
         <a href="{{route('dashboard')}}" class="navbar-brand mx-4 mt-3">
             <h3>Home Docer</h3>
         </a>
         <div class="navbar-nav w-100">
             <a class="nav-item nav-link {{ request()->is('*/dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}">
                 <img src="{{asset('img/side-icon1.svg')}}" class="img" /> Dashboard</a>

             @canany(['create-user', 'edit-user', 'delete-user'])
             <a class="nav-item nav-link {{ request()->is('*/users') ? 'active' : '' }}" href="{{ route('users.index') }}">
                 <img src="{{asset('img/8666755_users_group_icon.svg')}}" class="img" /></i> Manage Users</a>
             @endcanany

             @canany(['create-category', 'edit-category', 'delete-category'])
             <a class="nav-item nav-link {{ request()->is('*/category') ? 'active' : '' }}" href="{{ route('category.index') }}">
                 <img src="{{asset('img/103432_category_icon.svg')}}" class="img" /></i> Manage Category</a>
             @endcanany

             @canany(['create-product', 'edit-product', 'delete-product'])
             <a class="nav-item nav-link {{ request()->is('*/products') ? 'active' : '' }}" href="{{ route('products.index') }}">
                 <img src="{{asset('img/4544841_box_business_comerce_delivery_shop_icon.svg')}}" class="img" /> Manage Products</a>
             @endcanany

             @canany(['create-product', 'edit-product', 'delete-product'])
             <!-- <a class="nav-item nav-link {{ request()->is('*/inventory') ? 'active' : '' }}" href="{{ route('inventory.index') }}">
                 <img src="{{asset('img/4544841_box_business_comerce_delivery_shop_icon.svg')}}" class="img" /> Manage Inventory</a> -->
             @endcanany

             @canany(['create-order', 'edit-order', 'delete-order','change-order-status'])
             <a class="nav-item nav-link {{ request()->is('*/orders') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                 <img src="{{asset('img/4544841_box_business_comerce_delivery_shop_icon.svg')}}" class="img" /> Manage Orders</a>
             @endcanany

             @canany(['create-role', 'edit-role', 'delete-role'])
             <a class="nav-item nav-link {{ request()->is('*/roles') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                 <img src="{{asset('img/4634467_category_interface_link_categories_icon.svg')}}" class="img" /></i> Manage Roles</a>
             @endcanany
         </div>
     </nav>
 </div>
 <!-- Sidebar End -->