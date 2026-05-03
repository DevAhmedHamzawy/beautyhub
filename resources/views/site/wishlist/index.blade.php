@extends('site.layouts.app')

@section('title', 'wishlist')

@section('content')

    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="index-2.html">Home</a></span>
                <span class="devider">/</span>
                <span><a href="#">Wishlist</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">Wishlist</h1>
            </div>
        </div>
    </section>

    <section class="cart product wishlist footer-padding" data-aos="fade-up">
        <div class="container">
            <div class="cart-section wishlist-section">
                <table>
                    <tbody>
                        <tr class="table-row table-top-row">
                            <td class="table-wrapper wrapper-product">
                                <h5 class="table-heading">PRODUCT</h5>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">PRICE</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">ACTION</h5>
                                </div>
                            </td>
                        </tr>

                        @foreach ($wishlists as $product)
                            <tr class="table-row ticket-row">
                                <td class="table-wrapper wrapper-product">
                                    <div class="wrapper">
                                        <div class="wrapper-img">
                                            <img src="{{ $product->img_path }}" alt="img" />
                                        </div>
                                        <div class="wrapper-content">
                                            <h5 class="heading">{{ $product->name }}</h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading">
                                            @php
                                                $price = $product->the_price ?? [];
                                            @endphp

                                            @if (!empty($price) && $price['discounted'] != null)
                                                <span class="new-price">{{ $price['discounted'] }}</span>
                                            @else
                                                <span class="new-price">{{ $price['original'] ?? 'N/A' }}</span>
                                            @endif
                                        </h5>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <span class="remove-wishlist" data-product="{{ $product->id }}"
                                            style="cursor:pointer;">
                                            ✕
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <div class="wishlist-btn">
                <a href="empty-wishlist.html" class="clean-btn">Clean Wishlist</a>
                <a href="#" class="shop-btn">View Cards</a>
            </div>
        </div>
    </section>
@endsection
