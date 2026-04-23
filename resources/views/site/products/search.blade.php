@extends('site.layouts.app')

@section('title', 'search')

@section('content')

    <section class="product product-sidebar footer-padding">
        <div class="container">
            <div class="row g-5">

                @include('site.products.partials.search.side')


                <div class="col-lg-9">
                    <div class="product-sidebar-section" data-aos="fade-up">
                        <div class="row g-5">
                            <div class="col-lg-12">
                                <div class="product-sorting-section">
                                    <div class="result">
                                        <p>{{ trans('main.showing') }} <span>
                                                <span id="resultsCount">{{ $products->count() }}</span>
                                                {{ trans('main.of') }}
                                                <span id="resultsTotal">{{ $products->total() }}</span>
                                                {{ trans('main.results') }}
                                            </span></p>
                                    </div>
                                    <div class="product-sorting dropdown">
                                        <span class="product-sort">{{ trans('main.sort_by') }} :</span>

                                        <div class="product-list dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <span class="selected-sort">{{ trans('main.default') }}</span>

                                            <span>
                                                <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1L5 5L9 1" stroke="#9A9A9A" />
                                                </svg>
                                            </span>
                                        </div>

                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item sort-option"
                                                    data-value="default">{{ trans('main.default') }}</a></li>
                                            <li><a class="dropdown-item sort-option"
                                                    data-value="price_asc">{{ trans('main.price_low_to_high') }}</a></li>
                                            <li><a class="dropdown-item sort-option"
                                                    data-value="price_desc">{{ trans('main.price_high_to_low') }}</a></li>
                                            <li><a class="dropdown-item sort-option"
                                                    data-value="newest">{{ trans('main.newest_first') }}</a></li>
                                        </ul>

                                        <!-- مهم عشان يدخل في serialize -->
                                        <input type="hidden" name="sort" class="filters-input" value="default">
                                    </div>
                                </div>
                            </div>


                            <div id="preloader" style="display:none;">
                                <div class="row">
                                    @for ($i = 0; $i < 6; $i++)
                                        <div class="col-md-4 mb-4">
                                            <div class="skeleton-card"></div>
                                        </div>
                                    @endfor
                                </div>
                            </div>


                            <div id="the_result" class="row">
                                @include('site.products.partials.search.result')
                            </div>

                            <div id="loadMoreWrapper">
                                <button id="loadMoreBtn" class="col-lg-12">{{ trans('main.load_more') }}</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


@endsection

@section('footer')
    <script>
        function runFilter() {
            let query = $('#filterForm').serialize();


            $('#the_result').html('');

            $('#loadMoreWrapper').hide();

            page = 1;

            $('#preloader').show();

            // 🔥 ناخد sort حتى لو برا الفورم
            let sort = $('input[name="sort"]').val() || 'default';

            // نضيفه على query
            query += '&sort=' + sort;

            let newUrl = "{{ route('search.filter') }}" + "?" + query;

            // تحديث URL بدون reload
            window.history.pushState({
                path: newUrl
            }, '', newUrl);

            $.ajax({
                url: newUrl,
                type: "GET",
                headers: {
                    'Accept': 'application/json'
                },
                success: function(response) {
                    $('#preloader').hide();
                    $('#the_result').html(response.html);

                    let totalShown = $('#the_result .product-item').length;

                    $('#resultsCount').text(totalShown);

                    $('#resultsTotal').text(response.total);

                    if (!response.has_more) {
                        $('#loadMoreWrapper').hide();
                    } else {
                        $('#loadMoreWrapper').show();
                    }
                }
            });
        }

        var priceslider = function() {
            if ($("#slider-tooltips").length > 0) {
                var tooltipSlider = document.getElementById("slider-tooltips");

                var formatForSlider = {
                    from: function(formattedValue) {
                        return Number(formattedValue);
                    },
                    to: function(numericValue) {
                        return Math.round(numericValue);
                    },
                };

                let minPrice = parseInt(document.getElementById('min_price').value) || 0;
                let maxPrice = parseInt(document.getElementById('max_price').value) || 1000;

                noUiSlider.create(tooltipSlider, {
                    start: [minPrice, maxPrice],
                    connect: true,
                    range: {
                        min: 0,
                        max: 1000
                    },
                    format: formatForSlider,
                });

                var formatValues = [
                    document.getElementById("slider-margin-value-min"),
                    document.getElementById("slider-margin-value-max"),
                ];

                tooltipSlider.noUiSlider.on(
                    "update",
                    function(values, handle, unencoded) {
                        formatValues[0].innerHTML = "Price: " + "$" + values[0];
                        formatValues[1].innerHTML = "$" + values[1];


                        document.getElementById('min_price').value = Math.round(values[0]);
                        document.getElementById('max_price').value = Math.round(values[1]);
                    },
                );

                // 🔥 trigger search لما المستخدم يخلص
                tooltipSlider.noUiSlider.on("change", function() {
                    runFilter();
                });
            }
        };
        priceslider();

        $(document).on('change', '#filterForm', function() {
            runFilter();
        });

        $(document).on('click', '.sort-option', function() {
            let value = $(this).data('value');
            let text = $(this).text();

            // UI update
            $('.selected-sort').text(text);

            // update hidden input (حتى لو برا الفورم)
            $('input[name="sort"]').val(value);

            // run unified filter
            runFilter();
        });

        let page = 1;

        $(document).on('click', '#loadMoreBtn', function(e) {
            e.preventDefault();

            let btn = $(this);

            btn.html('<div class="loader"></div>');

            page++;

            $.ajax({
                url: "{{ route('search.filter') }}",
                type: "GET",
                headers: {
                    'Accept': 'application/json'
                },
                data: $('#filterForm').serialize() + '&page=' + page,

                success: function(response) {
                    $('#the_result').append(response.html);

                    let totalShown = $('#the_result .product-item').length;

                    $('#resultsCount').text(totalShown);

                    btn.html('Load More');

                    if (!response.has_more) {
                        $('#loadMoreWrapper').hide();
                    } else {
                        $('#loadMoreWrapper').show();
                    }
                }
            });
        });
    </script>
@endsection
