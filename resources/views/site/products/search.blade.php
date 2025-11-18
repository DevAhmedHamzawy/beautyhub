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
                                        <p>Showing <span>1–16 of {{ count($products) }} results</span></p>
                                    </div>
                                    <div class="product-sorting">
                                        <span class="product-sort">Sort by:</span>
                                        <div class="product-list">
                                            <span class="default">Default</span>
                                            <span>
                                                <svg width="10" height="6" viewBox="0 0 10 6" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1L5 5L9 1" stroke="#9A9A9A" />
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="the_result" class="row">
                                @include('site.products.partials.search.result')
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
        $(document).on('change', '#filterForm input', function() {
            let query = $('#filterForm').serialize();

            $.ajax({
                url: "{{ route('search.filter') }}?" + query,
                type: "GET",
                success: function(response) {
                    $('#the_result').html(response.html);
                }
            });
        });
    </script>
@endsection
