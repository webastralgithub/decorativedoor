@extends('frontend.layouts.app')

@section('content')
<!-- Hero Section Begin -->
@include('frontend.layouts.include.search-bar')
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{asset('img/breadcrumb')}}.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Interior Doors</h2>
                    <div class="breadcrumb__option">
                        <a href="#">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            @include('frontend.layouts.include.sidebar')
            <div class="col-lg-9 col-md-7">
                <div class="filter__item">
                    <div class="row">
                      
                    @if(!empty($products))
                    
                        @foreach($products as $product)
                        @php
                        $stockAvailability = getProductAvailabityStock($product->id);
                        $stockOnCart = getProductStockOnCart($product->id);
                        $inStock = $stockAvailability > 0 && $stockAvailability > $stockOnCart;
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <a href="{{route('product',$product->slug)}}">
                                    <div class="featured__item__pic set-bg" data-setbg="{{asset((!empty($product->image) ? Storage::url('products/'.$product->image->path) : 'img/featured/feature-1.jpg'))}}">
                                        {{-- <ul class="featured__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul> --}}
                                    </div>
                                    <div class="featured__item__text">
                                        <h6>{{$product->title}}</h6>
                                        <h4 class="stock" style="color: {{ $inStock ? 'green' : 'red' }}">
                                            {{ $inStock ? 'In' : 'Out of' }} Stock
                                        </h4>                            
                                        <h5>${{$product->selling_price}}</h5>
                                    </div>
                                </a>
                                <a href="#" id="share-with-email" data-id ="{{$product->id}}" data-toggle="modal" data-target="#exampleModal" onclick="return share_product('{{$product->id}}');">Share <i class="fa fa-share"></i></a> 
                            </div>
                        </div>
                        @endforeach
                    @else
                    <h6>Record not found!</h6>
                    @endif
                    </div>
                </div>
                {{-- <div class="product__pagination">
                    <a href="#">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#"><i class="fa fa-long-arrow-right"></i></a>
                </div> --}}
            </div>
        </div>
    </div>
</section> 
<!-- Product Section End -->
@endsection