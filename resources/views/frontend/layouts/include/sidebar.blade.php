 <!-- Sidebar Start -->
 <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All Categories</span>
                        </div>
                        <ul>
                            @foreach($categories as $category)
                            <li>
                                <a href="{{route('category', $category->slug )}}">{{ isset($category->name) ? $category->name : '' }}</a>
                                @if(count($category->children))
                                <ul class="under_ul">
                                    @foreach($category->children as $subcategory)
                                    <li><a href="{{route('category', $subcategory->slug )}}">{{ isset($subcategory->name) ? $subcategory->name : '' }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
 <!-- Sidebar End -->