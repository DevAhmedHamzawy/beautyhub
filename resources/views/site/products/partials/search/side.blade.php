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
                                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}"
                                        {{ in_array($category->id, (array) request('category_id')) ? 'checked' : '' }} />
                                    <label for="mobile">{{ $category->name }}</label>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <hr />
                <div class="sidebar-wrapper sidebar-range">
                    <h5 class="wrapper-heading">Price Range</h5>

                    <div id="slider-tooltips" class="slider-range mb-3"></div>

                    <input type="hidden" name="price[]" id="min_price" value="{{ $min }}">
                    <input type="hidden" name="price[]" id="max_price" value="{{ $max }}">

                    <span id="slider-margin-value-min">{{ $min ?? 0 }}</span>
                    <span>-</span>
                    <span id="slider-margin-value-max">{{ $max ?? 1000 }}</span>
                </div>
                <hr />
                <div class="sidebar-wrapper">
                    <h5 class="wrapper-heading">Brands</h5>
                    <div class="sidebar-item">
                        <ul class="sidebar-list">
                            @foreach ($brands as $brand)
                                <li>
                                    <input type="checkbox" name="brand_id[]" value="{{ $brand->id }}"
                                        {{ in_array($brand->id, (array) request('brand_id')) ? 'checked' : '' }} />
                                    <label for="mobile">{{ $brand->name }}</label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <hr />

                @php
                    $selectedAttributes = request()->input('attributes', []);
                @endphp
                @foreach ($attributes as $attribute)
                    <div class="sidebar-wrapper">
                        <h5 class="wrapper-heading">{{ $attribute->name }}</h5>
                        <div class="sidebar-item">
                            <ul class="sidebar-list">

                                @foreach ($attribute->children as $child)
                                    <li>
                                        <input type="checkbox" name="attributes[{{ $attribute->id }}][]"
                                            value="{{ $child->id }}" id="attr_{{ $child->id }}"
                                            {{ isset($selectedAttributes[$attribute->id]) && in_array($child->id, (array) $selectedAttributes[$attribute->id]) ? 'checked' : '' }}>

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
    <img src="{{ $settings->banner_five_path }}" alt="" srcset="">
</div>
</div>
