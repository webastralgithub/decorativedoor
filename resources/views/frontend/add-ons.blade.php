<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Add Ons</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($addOnProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{asset('frontend/img/featured/feature-1.jpg')}}">
                        <ul class="product__item__pic__hover">
                            <!-- <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li> -->
                            <li><a href="{{ route('add.to.cart', $product->id) }}"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="./shop-details.html">{{ $product->title}}</a></h6>
                        <h5>${{ $product->buying_price}}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>