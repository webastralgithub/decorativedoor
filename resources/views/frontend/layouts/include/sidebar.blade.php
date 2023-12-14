 <!-- Sidebar Start -->
 <div class="sidebar pe-4 pb-3">
     <nav class="navbar bg-light navbar-light">
         <a href="{{route('dashboard')}}" class="navbar-brand mx-4 mt-3">
             <h3>Home Docer</h3>
         </a>
         <div class="navbar-nav w-100">
             <a href="{{route('dashboard')}}" class="nav-item nav-link active"><img src="{{asset('img/side-icon1.svg')}}" class="img" /> Dashboard</a>
             @canany(['create-role', 'edit-role', 'delete-role'])
             <a class="btn btn-primary" href="{{ route('roles.index') }}">
                 <i class="bi bi-person-fill-gear"></i> Manage Roles</a>
             @endcanany
             @canany(['create-category', 'edit-category', 'delete-category'])
             <a class="btn btn-primary" href="{{ route('category.index') }}">
                 <i class="bi bi-person-fill-gear"></i> Manage Category</a>
             @endcanany
             @canany(['create-user', 'edit-user', 'delete-user'])
             <a class="btn btn-success" href="{{ route('users.index') }}">
                 <i class="bi bi-people"></i> Manage Users</a>
             @endcanany
             @canany(['create-product', 'edit-product', 'delete-product'])
             <a class="btn btn-warning" href="{{ route('products.index') }}">
                 <i class="bi bi-bag"></i> Manage Products</a>
             @endcanany
         </div>
     </nav>
 </div>
 <!-- Sidebar End -->