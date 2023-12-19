<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Categories</span>
                    </div>
                    <ul>
                        @foreach($categories as $category)
                        @if(empty($category->parent_id))
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
                </div>
            </div>
            <!-- Sidebar End -->
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="What do yo u need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+00 00.000.000</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>