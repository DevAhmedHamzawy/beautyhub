<section id="hero" class="hero">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper hero-wrapper">

            @foreach ($sliders as $slider)
                <div class="swiper-slide" style="background: url({{ $slider->img_path }})no-repeat center/cover;">

                </div>
            @endforeach

        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>
