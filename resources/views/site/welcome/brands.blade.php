@extends('site.layouts.app')

@section('title', 'beauty hub')

@section('content')

    <br><br><br>

    <section class="product brand" data-aos="fade-up">
        <div class="container">
            <div class="section-title">
                <h5>{{ trans('main.brands_of_products') }}</h5>
            </div>
            <div class="brand-section">

                @foreach ($brands as $brand)
                    <div class="product-wrapper">
                        <div class="wrapper-img">
                            <a href="{{ route('search.filter', ['brand_id[]' => $brand->id]) }}">
                                <img src="{{ asset($brand->img_path) }}" alt="img" />
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>


    <br><br><br><br><br><br><br><br>

@endsection
