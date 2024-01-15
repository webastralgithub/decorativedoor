<div class="col-lg-3 col-md-5">
    <div class="sidebar">
        <div class="sidebar__item">
            @foreach($allcategory as $category)
            @php
            if(empty($category->parent_id) && $category->name != 'Add On'):
            @endphp
            <h4>{{$category->name}}</h4>

            <ul class="under_ul">
                @foreach($category->children as $subcategory)
                <li><a href="{{route('category', $subcategory->slug)}}">{{$subcategory->name}}</a></li>
                @endforeach
            </ul>
            @php
            endif
            @endphp
            @endforeach
        </div>
        <div class="sidebar__item">
            <h4>Price</h4>
            <form id="price-range-form" method="get">
                <div class="price-range-wrap">
                    <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="10" data-max="540">
                        <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                    </div>
                    <div class="range-slider">
                        <div class="price-input">
                            <input type="text" id="minamount" name="min" @if(isset($_GET['min'])) value="{{$_GET['min']}}" @endif>
                            <input type="text" id="maxamount" name="max" @if(isset($_GET['max'])) value="{{$_GET['max']}}" @endif>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- <div class="sidebar__item sidebar__item__color--option">
            <h4>Colors</h4>
            <div class="sidebar__item__color sidebar__item__color--white">
                <label for="white">
                    White
                    <input type="radio" id="white">
                </label>
            </div>
            <div class="sidebar__item__color sidebar__item__color--gray">
                <label for="gray">
                    Gray
                    <input type="radio" id="gray">
                </label>
            </div>
            <div class="sidebar__item__color sidebar__item__color--red">
                <label for="red">
                    Red
                    <input type="radio" id="red">
                </label>
            </div>
            <div class="sidebar__item__color sidebar__item__color--black">
                <label for="black">
                    Black
                    <input type="radio" id="black">
                </label>
            </div>
            <div class="sidebar__item__color sidebar__item__color--blue">
                <label for="blue">
                    Blue
                    <input type="radio" id="blue">
                </label>
            </div>
            <div class="sidebar__item__color sidebar__item__color--green">
                <label for="green">
                    Green
                    <input type="radio" id="green">
                </label>
            </div>
        </div> --}}
        {{-- <div class="sidebar__item">
            <h4>Popular Size</h4>
            <div class="sidebar__item__size">
                <label for="large">
                    Large
                    <input type="radio" id="large">
                </label>
            </div>
            <div class="sidebar__item__size">
                <label for="medium">
                    Medium
                    <input type="radio" id="medium">
                </label>
            </div>
            <div class="sidebar__item__size">
                <label for="small">
                    Small
                    <input type="radio" id="small">
                </label>
            </div>
            <div class="sidebar__item__size">
                <label for="tiny">
                    Tiny
                    <input type="radio" id="tiny">
                </label>
            </div>
        </div> --}}
        <!-- <div class="sidebar__item">
            <div class="latest-product__text">
                <h4>Latest Products</h4>
                <div class="latest-product__slider owl-carousel">
                    <div class="latest-prdouct__slider__item">
                        <a href="{{route('product',getRandomProductSlug())}}" class="latest-product__item">
                            <div class="latest-product__item__pic">
                                <img src="{{asset('img/featured/feature-1.jpg')}}" alt="">
                            </div>
                            <div class="latest-product__item__text">
                                <h6>Heavy Double Door</h6>
                                <span>$76.000</span>
                            </div>
                        </a>
                        <a href="{{route('product',getRandomProductSlug())}}" class="latest-product__item">
                            <div class="latest-product__item__pic">
                                <img src="{{asset('img/featured/feature-1.jpg')}}" alt="">
                            </div>
                            <div class="latest-product__item__text">
                                <h6>Heavy Double Door</h6>
                                <span>$76.000</span>
                            </div>
                        </a>
                        <a href="{{route('product',getRandomProductSlug())}}" class="latest-product__item">
                            <div class="latest-product__item__pic">
                                <img src="{{asset('img/featured/feature-1.jpg')}}" alt="">
                            </div>
                            <div class="latest-product__item__text">
                                <h6>Heavy Double Door</h6>
                                <span>$76.000</span>
                            </div>
                        </a>
                    </div>
                    <div class="latest-prdouct__slider__item">
                        <a href="{{route('product',getRandomProductSlug())}}" class="latest-product__item">
                            <div class="latest-product__item__pic">
                                <img src="{{asset('img/featured/feature-1.jpg')}}" alt="">
                            </div>
                            <div class="latest-product__item__text">
                                <h6>Heavy Double Door</h6>
                                <span>$76.000</span>
                            </div>
                        </a>
                        <a href="{{route('product',getRandomProductSlug())}}" class="latest-product__item">
                            <div class="latest-product__item__pic">
                                <img src="{{asset('img/featured/feature-1.jpg')}}" alt="">
                            </div>
                            <div class="latest-product__item__text">
                                <h6>Heavy Double Door</h6>
                                <span>$76.000</span>
                            </div>
                        </a>
                        <a href="{{route('product',getRandomProductSlug())}}" class="latest-product__item">
                            <div class="latest-product__item__pic">
                                <img src="{{asset('img/featured/feature-1.jpg')}}" alt="">
                            </div>
                            <div class="latest-product__item__text">
                                <h6>Heavy Double Door</h6>
                                <span>$76.000</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>