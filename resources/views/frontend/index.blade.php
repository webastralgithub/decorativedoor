@extends('frontend.layouts.app')


@section('content')
@include('frontend.layouts.include.search-bar')
<!-- Hero Section End -->
<style>
    .slider {
        position: relative;
        width: 98%;
        margin: auto;
        overflow: hidden;
        height: 350px;
    }

    .slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        min-width: 100%;
        box-sizing: border-box;
    }

    .slider-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 24px;
        cursor: pointer;
        user-select: none;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: top center;
        /* Adjust as needed: cover, contain, fill, etc. */
    }

    .prev-btn {
        left: 10px;
    }

    .next-btn {
        right: 10px;
    }
</style>

<!-- Categories Section Begin -->
<!-- <section class="categories">
    <div class="container">
        <div class="row">
            <div class="categories__slider owl-carousel">
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="{{asset('frontend/img/banner/banner1.jpg')}}">

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="{{asset('frontend/img/banner/banner2.jpg')}}">

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="{{asset('frontend/img/banner/banner3.jpg')}}">

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="categories__item set-bg" data-setbg="{{asset('frontend/img/banner/banner4.jpg')}}">

                    </div>
                </div>

            </div>
        </div>
    </div>
</section> -->

{{-- <section class="hero">
    <div class="hero__item set-bg" data-setbg="{{asset('frontend/img/banner/banner.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                
                    <div class="hero__text">
                        <span>Latest Designs</span>
                        <h2>Creative &<br /> Sunrise Doors</h2>
                        <p>Secure you home with modern design doors.</p>
                        <a href="{{ route('shop')}}" class="primary-btn">SHOP NOW</a>
                    </div>
                
            </div>
        </div>
    </div>
    </div>
</section> --}}
<!-- Categories Section End -->

<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured Product</h2>
                </div>
                <div class="featured__controls">
                    <ul>
                        <li class="active" data-filter="*">All</li>
                        <li data-filter=".oranges">Interior Doors</li>
                        <li data-filter=".fresh-meat">Exterior Doors</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row featured__filter">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                <div class="featured__item">
                    <a href="{{route('product',$product->slug)}}">
                        <div class="featured__item__pic set-bg" data-setbg="{{asset((!empty($product->image) ? Storage::url('products/'.$product->image->path) : 'img/featured/feature-1.jpg'))}}">
                            <!-- <ul class="featured__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul> -->
                        </div>
                        <div class="featured__item__text">
                            <h6>{{$product->title}}</h6>
                            <h5>${{number_format($product->selling_price, 2, '.', ',')}}</h5>
                        </div>
                        <a href="#" id="share-with-email" data-id="{{$product->id}}" onclick="return share_product_email('{{$product->id}}')">Share <i class="fa fa-share"></i></a>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Featured Section End -->

<!-- Banner Begin -->
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="{{asset('frontend/img/banner/banner-1.jpg')}}" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="banner__pic">
                    <img src="{{asset('frontend/img/banner/banner-2.jpg')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection