<section class="product brand" data-aos="fade-up">
    <div class="container">

        <div class="section-title">
            <h5>{{ trans('main.brands_of_products') }}</h5>

            <a href="{{ route('brands') }}" class="view">
                {{ trans('main.view_all') }}
            </a>
        </div>

        <div class="swiper brandSwiper">

            <div class="swiper-wrapper">

                @foreach ($brands as $brand)
                    <div class="swiper-slide">

                        <a href="{{ route('search.filter', ['brand_id[]' => $brand->id]) }}" class="brand-card">

                            <img src="{{ asset($brand->img_path) }}" alt="{{ $brand->name }}">

                        </a>

                    </div>
                @endforeach

            </div>

        </div>

    </div>
</section>
