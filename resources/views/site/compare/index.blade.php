@extends('site.layouts.app')

@section('title', 'wishlist')

@section('content')

    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="index-2.html">Home</a></span>
                <span class="devider">/</span>
                <span><a href="#">Compaire</a></span>
            </div>
            <div class="blog-heading">
                <h1 class="heading">Product Comparison</h1>
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
                                    <h5 class="comment-title">Product Comparison</h5>
                                    <p class="paragraph">
                                        Select products to see the differences and similarities
                                        between them
                                    </p>
                                </div>
                            </td>
                            @foreach ($products as $product)
                                <td class="cart-center cart-item">
                                    <div class="wrapper-data">

                                        <div class="wrapper">
                                            <div class="wrapper-img">
                                                <img src="{{ $product->img_path }}" alt />
                                            </div>
                                            <div class="wrapper-content">
                                                <h5 class="wrapper-details">{{ $product->name }}</h5>
                                                <div class="price">
                                                    <span class="new-price">$6.99</span>
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
                                    <h5 class="comment-title">Star Rating</h5>
                                </div>
                            </td>

                            @foreach ($products as $product)
                                <td class="cart-item">
                                    <div class="wrapper-data">
                                        <div class="ratings">
                                            <span>
                                                <svg width="90" height="18" viewBox="0 0 90 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 0L11.0206 6.21885H17.5595L12.2694 10.0623L14.2901 16.2812L9 12.4377L3.70993 16.2812L5.73056 10.0623L0.440492 6.21885H6.97937L9 0Z"
                                                        fill="#FFA800" />
                                                    <path
                                                        d="M27 0L29.0206 6.21885H35.5595L30.2694 10.0623L32.2901 16.2812L27 12.4377L21.7099 16.2812L23.7306 10.0623L18.4405 6.21885H24.9794L27 0Z"
                                                        fill="#FFA800" />
                                                    <path
                                                        d="M45 0L47.0206 6.21885H53.5595L48.2694 10.0623L50.2901 16.2812L45 12.4377L39.7099 16.2812L41.7306 10.0623L36.4405 6.21885H42.9794L45 0Z"
                                                        fill="#FFA800" />
                                                    <path
                                                        d="M63 0L65.0206 6.21885H71.5595L66.2694 10.0623L68.2901 16.2812L63 12.4377L57.7099 16.2812L59.7306 10.0623L54.4405 6.21885H60.9794L63 0Z"
                                                        fill="#FFA800" />
                                                    <path
                                                        d="M81 0L83.0206 6.21885H89.5595L84.2694 10.0623L86.2901 16.2812L81 12.4377L75.7099 16.2812L77.7306 10.0623L72.4405 6.21885H78.9794L81 0Z"
                                                        fill="#FFA800" />
                                                </svg>
                                            </span>
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
