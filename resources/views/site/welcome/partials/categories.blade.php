<section class="product-category">
    <div class="container">
        <div class="section-title">
            <h5>{{ trans('main.categories') }}</h5>
            <a href="{{ route('categories') }}" class="view">{{ trans('main.view_all') }}</a>
        </div>
        <div class="category-section">

            @foreach ($categories as $category)
                <div class="product-wrapper" data-aos="fade-right" data-aos-duration="100">
                    <div class="wrapper-img">
                        <img src="{{ asset($category->img_path) }}" alt="dress" />
                    </div>
                    <div class="wrapper-info">
                        <a href="{{ route('search.filter', ['category_id[]' => $category->id]) }}"
                            class="wrapper-details">{{ $category->translate($locale)->name }}</a>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</section>
