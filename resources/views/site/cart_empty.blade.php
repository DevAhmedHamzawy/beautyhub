 @extends('site.layouts.app')

 @section('title', 'Cart')

 @section('content')

     <section class="blog about-blog footer-padding">
         <div class="container">
             <div class="blog-bradcrum">
                 <span><a href="{{ url('/') }}">{{ trans('main.home') }}</a></span>
                 <span class="devider">/</span>
                 <span><a href="#">{{ trans('main.404') }}</a></span>
             </div>
             <div class="blog-item" data-aos="fade-up">
                 <div class="cart-img">
                     <img src="{{ asset('site/assets/images/homepage-one/empty-cart.webp') }}" alt />
                 </div>
                 <div class="cart-content">
                     <p class="content-title">{{ trans('main.cart_is_empty') }}</p>
                     <a href="{{ route('search') }}" class="shop-btn">{{ trans('main.back_to_shop') }}</a>
                 </div>
             </div>
         </div>
     </section>

 @endsection
