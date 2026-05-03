@extends('site.layouts.app')

@section('title', 'wishlist')

@section('content')

    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="{{ url('/') }}">{{ trans('main.home') }}</a></span>
                <span class="devider">/</span>
                <span><a href="#">{{ trans('main.compare') }}</a></span>
            </div>
            <div class="blog-heading">
                <h1 class="heading">{{ trans('main.product_comparison') }}</h1>
            </div>
        </div>
    </section>

    <section class="product-cart product product-compair footer-padding">
        <div class="container">
            <div class="cart-section">
                <table>
                    <tbody>
                        <tr class="cart-top">
                            <td class="cart-item cart-grey-bg vertical-cart">
                                <div class="wrapper-title">
                                    <h5 class="comment-title">{{ trans('main.product_comparison') }}</h5>
                                    <p class="paragraph">
                                        {{ trans('main.product_comparison_text') }}
                                    </p>
                                </div>
                            </td>
                            @foreach ($products as $product)
                                <td class="cart-center cart-item">
                                    <div class="wrapper-data">

                                        <div class="wrapper">

                                            <a href="#" class="remove-product" data-id="{{ $product->id }}">
                                                <i class="fa-solid fa-xmark"></i>
                                            </a>

                                            <div class="wrapper-img">
                                                <img src="{{ $product->img_path }}" alt />
                                            </div>

                                            <div class="wrapper-content">
                                                <h5 class="wrapper-details">{{ $product->name }}</h5>

                                                <div class="price">
                                                    @php
                                                        $price = $product->the_price ?? [];
                                                    @endphp

                                                    @if (!empty($price) && $price['discounted'] != null)
                                                        <span class="price-cut">{{ $product->the_price['original'] }} <span
                                                                style="font-family: 'Arshid';">$</span></span>
                                                        <span class="new-price">{{ $product->the_price['discounted'] }}
                                                            <span style="font-family: 'Arshid';">$</span></span>
                                                    @else
                                                        <span
                                                            class="new-price">{{ $product->the_price['original'] ?? 'N/A' }}
                                                            <span style="font-family: 'Arshid';">$</span></span>
                                                    @endif
                                                </div>



                                            </div>

                                        </div>
                                    </div>
                                </td>
                            @endforeach


                        </tr>
                        <tr class="cart-top cart-bottom">
                            <td class="cart-item cart-grey-bg">
                                <div class="wrapper-title">
                                    <h5 class="comment-title">{{ trans('main.star_rating') }}</h5>
                                </div>
                            </td>

                            @foreach ($products as $product)
                                <td class="cart-item">
                                    <div class="wrapper-data">
                                        <div class="ratings">
                                            <span>
                                                @php
                                                    $rating = round($product->averageRating());
                                                @endphp

                                                <div class="stars">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $rating)
                                                            <i class="fa-solid fa-star text-warning"></i>
                                                        @else
                                                            <i class="fa-regular fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </span>
                                        </div>
                                    </div>
            </div>
            </td>
            @endforeach


            </tr>
            </tbody>
            </table>
        </div>
        </div>
    </section>

@endsection
