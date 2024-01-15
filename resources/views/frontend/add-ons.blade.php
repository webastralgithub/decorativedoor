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
                    <div class="featured__item__pic set-bg" data-setbg="{{asset((!empty($product->image) ? Storage::url('products/'.$product->image->path) : 'img/featured/feature-1.jpg'))}}">
                        <ul class="product__item__pic__hover">
                            <!-- <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li> -->

                            <form method="POST" action="{{ route('add.to.cart') }}" class="form-cart-btn">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="variant" class="product-variant-data" value="{{json_encode($variantSingle)}}" />
                                <input type="hidden" name="product_id" value="{{$product->id}}" />
                                <input type="hidden" name="quantity" value="1" />
                                <li><button type="submit" class=" add-to-cart"><i class="fa fa-shopping-cart"></i></button></li>
                            </form>

                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{ route('product',$product->slug)}}">{{ $product->title}}</a></h6>
                        <h5>${{ $product->selling_price}}</h5>
                    </div>
                    <a href="#" id="share-with-email" data-id ="{{$product->id}}" data-toggle="modal" data-target="#exampleModal" onclick="return share_product('{{$product->id}}');">Share <i class="fa fa-share"></i></a> 
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>