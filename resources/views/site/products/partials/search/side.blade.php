<div class="col-lg-3">
    <form id="filterForm">
        <div class="sidebar" data-aos="fade-right">
            <div class="sidebar-section">
                <div class="sidebar-wrapper">
                    <h5 class="wrapper-heading">Product Categories</h5>
                    <div class="sidebar-item">
                        <ul class="sidebar-list">
                            @foreach ($categories as $category)
                                <li>
                                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}" />
                                    <label for="mobile">{{ $category->name }}</label>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <hr />
                <div class="sidebar-wrapper sidebar-range">
                    <h5 class="wrapper-heading">Price Range</h5>
                    <div class="price-slide range-slider">
                        <div class="price">
                            <div class="range-slider style-1">
                                <div id="slider-tooltips" class="slider-range mb-3"></div>
                                <span class="example-val" id="slider-margin-value-min"></span>
                                <span>-</span>
                                <span class="example-val" id="slider-margin-value-max"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="sidebar-wrapper">
                    <h5 class="wrapper-heading">Brands</h5>
                    <div class="sidebar-item">
                        <ul class="sidebar-list">
                            @foreach ($brands as $brand)
                                <li>
                                    <input type="checkbox" name="brand_id[]" value="{{ $brand->id }}" />
                                    <label for="mobile">{{ $brand->name }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <hr />
                @foreach ($attributes as $attribute)
                    <div class="sidebar-wrapper">
                        <h5 class="wrapper-heading">{{ $attribute->name }}</h5>
                        <div class="sidebar-item">
                            <ul class="sidebar-list">

                                @foreach ($attribute->children as $child)
                                    <li>
                                        <input type="checkbox" name="attributes[{{ $attribute->id }}][]"
                                            value="{{ $child->id }}" id="attr_{{ $child->id }}">

                                        <label for="attr_{{ $child->id }}">{{ $child->name }}</label>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
    </form>
    <div class="sidebar-shop-section">
        <span class="wrapper-subtitle">TRENDY</span>
        <h5 class="wrapper-heading">Best wireless Shoes</h5>
        <a href="seller-sidebar.html" class="shop-btn deal-btn">Shop Now
        </a>
    </div>
</div>
</div>
