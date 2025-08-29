<section class="product-category">
    <div class="container">
        <div class="section-title">
            <h5>Our Categories</h5>
            <a href="product-sidebar.html" class="view">View All</a>
        </div>
        <div class="category-section">

            @foreach ($categories as $category)
                <div class="product-wrapper" data-aos="fade-right" data-aos-duration="100">
                    <div class="wrapper-img">
                        <img src="{{ asset($category->img_path) }}" alt="dress" />
                    </div>
                    <div class="wrapper-info">
                        <a href="product-sidebar.html"
                            class="wrapper-details">{{ $category->translate($locale)->name }}</a>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</section>
