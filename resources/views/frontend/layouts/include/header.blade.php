<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Door Admin</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="#"><img src="{{asset('frontend/img/logo.png')}}" alt=""></a>
        </div>
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>{{ count((array) session('cart')) }}</span></a></li>
            </ul>
            <div class="header__cart__price">item: <span>$150.00</span></div>
        </div>
        <!-- <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <img src="img/language.png" alt="">
                <div>English</div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <li><a href="#">Spanis</a></li>
                    <li><a href="#">English</a></li>
                </ul>
            </div>
            <div class="header__top__right__auth">
                <a href="{{route('login')}}"><i class="fa fa-user"></i> Login</a>
            </div>
        </div> -->
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                @foreach($categories as $category)
                            @if(empty($category->parent_id) && $category->name != 'Add On')
                            <li>
                                <a href="{{route('category', $category->slug )}}">{{ isset($category->name) ? $category->name : '' }}</a>
                            </li>
                            @endif
                            @endforeach
                {{-- <li class="{{ request()->is('*home') ? 'active' : '' }}"><a href="{{route('home')}}">Home</a></li>
                <li class="{{ request()->is('*shop') ? 'active' : '' }}"><a href="{{route('shop')}}">Shop</a></li>
                <li class="{{ request()->is('*contact') ? 'active' : '' }}"><a href="{{route('contact')}}">Contact</a></li> --}}
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest-p"></i></a>
        </div>
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> hello@dummy.com</li>
                <li><i class="fa fa-phone"></i> +1 (604) 446-5841</li>
                <li>Free Shipping for all Order of $99</li>
            </ul>
        </div>
    </div>
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> hello@dummy.com</li>
                                <li><i class="fa fa-phone"></i> +1 (604) 446-5841</li>
                                <li>Free Shipping for all Order of $99</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">
                                <!-- <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a> -->
                            </div>
                            <!-- <div class="header__top__right__language">
                                <img src="img/language.png" alt="">
                                <div>English</div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <li><a href="#">Spanis</a></li>
                                    <li><a href="#">English</a></li>
                                </ul>
                            </div> -->
                            <div class="header__top__right__auth">
                                @if(auth()->check())
                                {{-- User is logged in --}}
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <!-- <input type="submit" value="Logout"> -->
                                    <label for="submitButton" style="cursor: pointer;">
                                        <input type="submit" id="submitButton" style="display: none;">
                                        Logout
                                    </label>
                                </form>
                                @else
                                {{-- User is not logged in --}}
                                <a href="{{ route('login') }}">Login</a>
                                @endif
                                <!-- <a href="{{route('login')}}"><i class="fa fa-user"></i> Login</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-lg-2 hero hero-normal">
                <div class="header__logo">
                        <a href="{{route('home')}}"><img src="{{asset('frontend/img/logo.png')}}" alt=""></a>
                </div>
                {{-- <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Categories</span>
                    </div>
                    <ul>
                        @foreach($categories as $category)
                        @if(empty($category->parent_id) && $category->name != 'Add On')
                        <li>
                            <a href="{{route('category', $category->slug )}}">{{ isset($category->name) ? $category->name : '' }}</a>
                            <ul class="under_ul sub">
                                @foreach($category->children as $subcategory)
                                <li><a class="sub-sub" href="{{route('category', $subcategory->slug )}}">{{ isset($subcategory->name) ? $subcategory->name : '' }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div> --}}
                </div>

                <div class="col-lg-7">
                    <nav class="header__menu">
                        <ul>
                            @foreach($categories as $category)
                            @if(empty($category->parent_id) && $category->name != 'Add On')
                            <li>
                                <a href="{{route('category', $category->slug )}}">{{ isset($category->name) ? $category->name : '' }}</a>
                            </li>
                            @endif
                            @endforeach

                            <li class="{{ request()->is('*customer') ? 'active' : '' }}"><a href="{{route('customer')}}">Customer</a></li>
                            <li class="primary-btn"><a href="{{route('neworder')}}">Start New Order</a></li>
                        </ul>
                    </nav>
                </div>



                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <div class="dropdown">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item dropdown">
                                        <a href="{{ route('cart') }}" role="button">
                                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                            <span class="badge badge-pill badge-danger">{{ count((array) session('cart')) }}</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="row total-header-section">

                                                @php $total = 0 @endphp
                                                @foreach((array) session('cart') as $id => $details)
                                                @if(isset($details['variant_price']))
                                                <!-- if product with multiple variants -->
                                                @if(isset($details['variant_data']))
                                                @foreach($details['variant_data'] as $variantId => $subVariant)
                                                @php $total += $subVariant['price'] * $subVariant['quantity'] @endphp
                                                @endforeach
                                                @else
                                                
                                                @php $total += $details['variant_price'] * $details['quantity'] @endphp
                                                @endif
                                                @endif
                                                @endforeach
                                                <div class="col-lg-12 col-sm-12 col-12 total-section text-center">
                                                    <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                                    <a href="{{ route('cart') }}" class="btn btn-primary btn-block">View all</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </ul>
                        <div class="header__cart__price">item: <span>${{ $total }}</span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
        </div>
    </header>