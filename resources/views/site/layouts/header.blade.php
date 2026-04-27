 <header id="header" class="header">
     <div class="header-top-section">
         <div class="container">
             <div class="header-top d-flex justify-content-between align-items-center">

                 <div class="header-profile">
                     <a href="{{ route('profile') }}"><span>{{ trans('main.account') }}</span></a>
                     <a href="{{ route('contact') }}"><span>{{ trans('main.support') }}</span></a>
                 </div>

                 <div class="d-flex align-items-center gap-3">

                     <!-- Language Dropdown -->
                     <div class="dropdown">
                         @php $locale = app()->getLocale(); @endphp

                         <a class="dropdown-toggle d-flex align-items-center" href="#" role="button"
                             data-bs-toggle="dropdown">

                             @if ($locale == 'ar')
                                 <img src="{{ asset('assets/img/flags/egypt_flag.jpg') }}" width="22">
                                 <span class="ms-2">{{ trans('main.ar') }}</span>
                             @else
                                 <img src="{{ asset('assets/img/flags/us_flag.jpg') }}" width="22">
                                 <span class="ms-2">{{ trans('main.en') }}</span>
                             @endif
                         </a>

                         <ul class="dropdown-menu dropdown-menu-end">
                             <li>
                                 <a class="dropdown-item" href="{{ route('language', 'en') }}">
                                     <img src="{{ asset('assets/img/flags/us_flag.jpg') }}" width="18">
                                     {{ trans('main.en') }}
                                 </a>
                             </li>
                             <li>
                                 <a class="dropdown-item" href="{{ route('language', 'ar') }}">
                                     <img src="{{ asset('assets/img/flags/egypt_flag.jpg') }}" width="18">
                                     {{ trans('main.ar') }}
                                 </a>
                             </li>
                         </ul>
                     </div>

                     <!-- Contact -->
                     <div class="header-contact d-none d-lg-block">
                         <a href="#">
                             <span>{{ trans('main.help_call') }}</span>
                             <span class="contact-number">{{ $settings->phone }}</span>
                         </a>
                     </div>

                 </div>

             </div>
         </div>
     </div>
     <div class="header-center-section d-none d-lg-block">
         <div class="container">
             <div class="header-center">
                 <div class="logo">
                     <a href="{{ url('/') }}">
                         <img src="{{ $settings->logo_path }}" alt="logo" />
                     </a>
                 </div>
                 <div class="header-cart-items">
                     <div class="header-search">
                         <button class="header-search-btn" onclick="modalAction('.search')">
                             <span>
                                 <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                     <path
                                         d="M13.9708 16.4151C12.5227 17.4021 10.9758 17.9723 9.27353 18.0062C5.58462 18.0802 2.75802 16.483 1.05056 13.1945C-1.76315 7.77253 1.33485 1.37571 7.25086 0.167548C12.2281 -0.848249 17.2053 2.87895 17.7198 7.98579C17.9182 9.95558 17.5566 11.7939 16.5852 13.5061C16.4512 13.742 16.483 13.8725 16.6651 14.0553C18.2412 15.6386 19.8112 17.2272 21.3735 18.8244C22.1826 19.6513 22.2058 20.7559 21.456 21.4932C20.7697 22.1678 19.7047 22.1747 18.9764 21.4793C18.3623 20.8917 17.7774 20.2737 17.1796 19.6688C16.118 18.5929 15.0564 17.5153 13.9708 16.4151ZM2.89545 9.0364C2.91692 12.4172 5.59664 15.1164 8.91967 15.1042C12.2384 15.092 14.9138 12.3493 14.8889 8.98505C14.864 5.63213 12.1826 2.92508 8.89047 2.92857C5.58204 2.93118 2.87397 5.68958 2.89545 9.0364Z" />
                                 </svg>
                             </span>
                         </button>
                         <div class="modal-wrapper search">
                             <div onclick="modalAction('.search')" class="anywhere-away"></div>

                             <div class="modal-main">
                                 <div class="wrapper-close-btn" onclick="modalAction('.search')">
                                     <span>
                                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="red" class="w-6 h-6">
                                             <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M6 18L18 6M6 6l12 12"></path>
                                         </svg>
                                     </span>
                                 </div>
                                 <form class="search-wrapper" action="{{ route('search.filter') }}">
                                     <input type="text" name="name"
                                         placeholder="{{ trans('main.search_products') }}">

                                     <select class="category-select" name="category_id[]">
                                         <option value="" disabled selected>{{ trans('main.all_categories') }}
                                         </option>
                                         @foreach ($categories as $category)
                                             <option value="{{ $category->id }}">
                                                 {{ $category->translate($locale)->name }}</option>
                                         @endforeach
                                     </select>

                                     <button class="search-btn">{{ trans('main.search') }}</button>
                                 </form>
                             </div>
                         </div>
                     </div>
                     <div class="header-compaire">
                         <a href="{{ route('compare.index') }}" class="cart-item">
                             <span>
                                 <svg width="34" height="27" viewBox="0 0 34 27" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                     <path
                                         d="M22 16.0094C21.997 22.0881 17.0653 27.007 10.9802 27C4.90444 26.9931 -0.00941233 22.0569 1.3538e-05 15.9688C0.00943941 9.89602 4.95157 4.98663 11.0422 5.00003C17.0961 5.01342 22.003 9.94315 22 16.0094ZM6.16553 15.7812C6.40365 12.6236 8.72192 11.2861 10.5868 11.1993C12.3305 11.1179 14.4529 12.3353 14.7465 13.6143C14.2425 13.6143 13.7459 13.6143 13.2429 13.6143C13.2429 14.0241 13.2429 14.3986 13.2429 14.7975C14.308 14.7975 15.3374 14.8064 16.3668 14.793C16.7805 14.7876 17.0102 14.5291 17.0147 14.1005C17.0221 13.3414 17.0172 12.5824 17.0172 11.8234C17.0172 11.558 17.0172 11.2925 17.0172 11.0311C16.5836 11.0311 16.2165 11.0311 15.7908 11.0311C15.7908 11.6046 15.7908 12.1572 15.7908 12.7937C13.9379 10.0444 10.8447 9.4545 8.48578 10.4824C6.21811 11.4706 4.90792 13.847 5.04682 15.7817C5.40997 15.7812 5.77609 15.7812 6.16553 15.7812ZM15.8191 16.2178C15.7581 17.4576 15.3498 18.547 14.4742 19.4286C13.5976 20.3111 12.5265 20.772 11.2858 20.8008C9.57472 20.8405 7.568 19.6424 7.2495 18.3892C7.75403 18.3892 8.25013 18.3892 8.76012 18.3892C8.76012 17.9809 8.76012 17.6064 8.76012 17.2041C7.68458 17.2041 6.64178 17.1921 5.59997 17.21C5.19962 17.2169 5.00069 17.4839 4.99771 17.9442C4.99176 18.803 4.99573 19.6612 4.99573 20.52C4.99573 20.6698 4.99573 20.8196 4.99573 20.964C5.4318 20.964 5.79692 20.964 6.20224 20.964C6.20224 20.3895 6.20224 19.8418 6.20224 19.1686C7.07984 20.4912 8.16976 21.3465 9.58216 21.7617C11.0184 22.1839 12.4114 22.0494 13.7548 21.4035C15.8191 20.4113 17.0946 18.1466 16.9507 16.2178C16.5861 16.2178 16.2209 16.2178 15.8191 16.2178Z"
                                         fill="#6E6D79" />
                                     <path
                                         d="M6.16568 15.7814C5.77624 15.7814 5.41062 15.7814 5.04648 15.7814C4.90757 13.8471 6.21777 11.4703 8.48543 10.482C10.8444 9.45411 13.9376 10.044 15.7905 12.7934C15.7905 12.1569 15.7905 11.6042 15.7905 11.0307C16.2161 11.0307 16.5833 11.0307 17.0168 11.0307C17.0168 11.2917 17.0168 11.5571 17.0168 11.823C17.0168 12.582 17.0218 13.341 17.0144 14.1001C17.0104 14.5287 16.7802 14.7877 16.3665 14.7926C15.3371 14.8055 14.3076 14.7971 13.2425 14.7971C13.2425 14.3982 13.2425 14.0237 13.2425 13.6139C13.7451 13.6139 14.2417 13.6139 14.7462 13.6139C14.4525 12.3355 12.3302 11.118 10.5864 11.1989C8.72207 11.2862 6.4038 12.6237 6.16568 15.7814Z"
                                         fill="white" />
                                     <path
                                         d="M15.8191 16.2178C16.2209 16.2178 16.5865 16.2178 16.9502 16.2178C17.094 18.1466 15.8186 20.4108 13.7543 21.4035C12.4109 22.0494 11.0178 22.1834 9.58161 21.7617C8.16971 21.3469 7.07978 20.4912 6.20169 19.1686C6.20169 19.8418 6.20169 20.3895 6.20169 20.9639C5.79687 20.9639 5.43125 20.9639 4.99518 20.9639C4.99518 20.8201 4.99518 20.6703 4.99518 20.5199C4.99518 19.6612 4.99121 18.8029 4.99716 17.9442C5.00014 17.4838 5.19907 17.2169 5.59943 17.21C6.64173 17.1916 7.68403 17.204 8.75957 17.204C8.75957 17.6064 8.75957 17.9809 8.75957 18.3892C8.25008 18.3892 7.75348 18.3892 7.24895 18.3892C7.56794 19.6428 9.57466 20.8404 11.2852 20.8007C12.526 20.772 13.597 20.3111 14.4736 19.4285C15.3492 18.547 15.758 17.457 15.8191 16.2178Z"
                                         fill="white" />
                                     <circle cx="25.9322" cy="8" r="8" fill="#AE1C9A" />
                                     <text class="compare_count" x="25.9322" y="11.5" text-anchor="middle"
                                         font-size="10" fill="white" font-weight="bold">
                                         {{ $compare ? count($compare) : 0 }}
                                     </text>
                                 </svg>
                             </span>
                             <span class="cart-text"> {{ trans('main.compare') }} </span>
                         </a>
                     </div>
                     <div class="header-favourite">
                         <a href="{{ route('wishlist.index') }}" class="cart-item">
                             <span>
                                 <svg width="35" height="27" viewBox="0 0 35 27" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                     <path
                                         d="M11.4047 8.54989C11.6187 8.30247 11.8069 8.07783 12.0027 7.86001C15.0697 4.45162 20.3879 5.51717 22.1581 9.60443C23.4189 12.5161 22.8485 15.213 20.9965 17.6962C19.6524 19.498 17.95 20.9437 16.2722 22.4108C15.0307 23.4964 13.774 24.5642 12.5246 25.6408C11.6986 26.3523 11.1108 26.3607 10.2924 25.6397C8.05177 23.6657 5.79225 21.7125 3.59029 19.6964C2.35865 18.5686 1.33266 17.2553 0.638823 15.7086C-0.626904 12.8872 0.0324709 9.41204 2.22306 7.41034C4.84011 5.01855 8.81757 5.36918 11.1059 8.19281C11.1968 8.30475 11.2907 8.41404 11.4047 8.54989Z"
                                         fill="#6E6D79" />
                                     <circle cx="26.7662" cy="8" r="8" fill="#AE1C9A" />
                                     <text class="wishlist_count" x="25.9322" y="11.5" text-anchor="middle"
                                         font-size="10" fill="white" font-weight="bold">
                                         {{ $wishlists ? count($wishlists) : 0 }}
                                     </text>
                                 </svg>
                             </span>
                             <span class="cart-text"> {{ trans('main.wishlist') }} </span>
                         </a>
                     </div>
                     <div class="header-cart">
                         <a href="{{ route('cart.show') }}" class="cart-item">
                             <span>
                                 <svg width="35" height="28" viewBox="0 0 35 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                     <path
                                         d="M16.4444 21.897C14.8444 21.897 13.2441 21.8999 11.6441 21.8963C9.79233 21.892 8.65086 21.0273 8.12595 19.2489C7.04294 15.5794 5.95756 11.9107 4.87166 8.24203C4.6362 7.4468 4.37783 7.25412 3.55241 7.25175C2.7786 7.24964 2.00507 7.25754 1.23127 7.24911C0.512247 7.24148 0.0157813 6.79109 0.000242059 6.15064C-0.0160873 5.48281 0.475637 5.01689 1.23232 5.00873C2.11121 4.99952 2.99089 4.99214 3.86951 5.01268C5.36154 5.04769 6.52014 5.93215 6.96393 7.35415C7.14171 7.92378 7.34055 8.49026 7.46382 9.07201C7.54968 9.47713 7.77881 9.49661 8.10566 9.49582C11.8335 9.48897 15.5611 9.49134 19.2889 9.49134C21.0825 9.49134 22.8761 9.48108 24.6694 9.49503C26.0848 9.50608 27.0907 10.4906 27.0156 11.7778C27.0006 12.0363 26.925 12.2958 26.8473 12.5457C26.1317 14.8411 25.4124 17.1351 24.6879 19.4279C24.1851 21.0186 23.0223 21.8826 21.3504 21.8944C19.7151 21.906 18.0797 21.897 16.4444 21.897Z"
                                         fill="#6E6D79" />
                                     <path
                                         d="M12.4012 27.5161C11.167 27.5227 10.1488 26.524 10.1345 25.2928C10.1201 24.0419 11.1528 22.9982 12.3967 23.0066C13.6209 23.0151 14.6422 24.0404 14.6436 25.2623C14.6451 26.4855 13.6261 27.5095 12.4012 27.5161Z"
                                         fill="#6E6D79" />
                                     <path
                                         d="M22.509 25.2393C22.5193 26.4842 21.5393 27.4971 20.3064 27.5155C19.048 27.5342 18.0272 26.525 18.0277 25.2622C18.0279 24.0208 19.0214 23.0161 20.2572 23.0074C21.4877 22.9984 22.4988 24.0006 22.509 25.2393Z"
                                         fill="#6E6D79" />
                                     <circle cx="26.9523" cy="8" r="8" fill="#AE1C9A" />
                                     <text id="cart-count" x="25.9322" y="11.5" text-anchor="middle" font-size="10"
                                         fill="white" font-weight="bold">
                                         {{ $cart->sum('quantity') }}
                                     </text>
                                 </svg>
                             </span>
                             <span class="cart-text"> {{ trans('main.cart') }} </span>
                         </a>
                         <div class="cart-submenu">
                             <div class="cart-wrapper-item" id="cart-items">
                                 @forelse ($cart as $item)
                                     <div class="wrapper">
                                         <div class="wrapper-item">
                                             <div class="wrapper-img">
                                                 <img src="{{ $item->product->img_path }}"
                                                     alt="{{ $item->product->name }}">
                                             </div>
                                             <div class="wrapper-content">
                                                 <h5 class="wrapper-title">{{ $item->product->name }}</h5>
                                                 <div class="price">
                                                     <p class="new-price">
                                                         ${{ number_format($item->product->the_price['discounted'] ?? $item->product->the_price['original'], 2) }}
                                                     </p>
                                                 </div>
                                             </div>
                                         </div>
                                         <span class="close-btn remove-item" data-stock="{{ $item->stock->id }}">
                                             ✕
                                         </span>
                                     </div>
                                 @empty
                                     <p class="text-center">{{ trans('main.cart_empty') }}</p>
                                 @endforelse
                             </div>
                             <div class="cart-wrapper-section">
                                 <div class="wrapper-line"></div>
                                 <div class="wrapper-subtotal">
                                     <h5 class="wrapper-title">{{ trans('main.subtotal') }}</h5>
                                     <h5 class="wrapper-title-sub">

                                         @php
                                             $subtotal = $cart->sum(fn($item) => $item->unit_price * $item->quantity);
                                         @endphp
                                         ${{ number_format($subtotal, 2) }}
                                     </h5>
                                 </div>
                                 <div class="cart-btn">
                                     <a href="{{ route('cart.show') }}"
                                         class="shop-btn view-btn">{{ trans('main.view_cart') }}</a>
                                     <a href="{{ route('checkout') }}"
                                         class="shop-btn checkout-btn">{{ trans('main.checkout_now') }}</a>
                                 </div>
                             </div>
                         </div>
                     </div>
                     <div class="header-user">
                         @auth
                             <div class="dropdown">
                                 <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                     <span>
                                         <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                             height="24" class="fill-current">
                                             <path fill="none" d="M0 0h24v24H0z"></path>
                                             <path
                                                 d="M20 22H4v-2a5 5 0 0 1 5-5h6a5 5 0 0 1 5 5v2zm-8-9a6 6 0 1 1 0-12 6 6 0 0 1 0 12z">
                                             </path>
                                         </svg>
                                     </span>
                                 </a>

                                 <ul class="dropdown-menu">
                                     {{-- لوحة التحكم --}}
                                     <li>
                                         <a class="dropdown-item" href="{{ route('profile') }}">
                                             لوحة التحكم
                                         </a>
                                     </li>

                                     {{-- تسجيل الخروج --}}
                                     <li>
                                         <form method="POST" action="{{ route('logout') }}">
                                             @csrf
                                             <button type="submit" class="dropdown-item">
                                                 تسجيل الخروج
                                             </button>
                                         </form>
                                     </li>
                                 </ul>
                             </div>
                         @endauth

                         @guest
                             <a href="{{ route('login') }}">{{ trans('main.login') }}</a>
                             &nbsp;&nbsp;
                             <a href="{{ route('register') }}">{{ trans('main.register') }}</a>
                         @endguest

                     </div>
                 </div>
             </div>
         </div>
     </div>
     <nav class="mobile-menu d-block d-lg-none">
         <div class="mobile-menu-header d-flex justify-content-between align-items-center">
             <button class="btn" type="button" data-bs-toggle="offcanvas"
                 data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                 <span>
                     <svg width="14" height="9" viewBox="0 0 14 9" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                         <rect width="14" height="1" fill="#1D1D1D" />
                         <rect y="8" width="14" height="1" fill="#1D1D1D" />
                         <rect y="4" width="10" height="1" fill="#1D1D1D" />
                     </svg>
                 </span>
             </button>
             <a href="{{ url('/') }}" class="mobile-header-logo">
                 <img src="{{ $settings->logo_path }}" alt="logo" />
             </a>
             <a href="{{ route('cart.show') }}" class="header-cart cart-item">
                 <span>
                     <svg width="35" height="28" viewBox="0 0 35 28" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                         <path
                             d="M16.4444 21.897C14.8444 21.897 13.2441 21.8999 11.6441 21.8963C9.79233 21.892 8.65086 21.0273 8.12595 19.2489C7.04294 15.5794 5.95756 11.9107 4.87166 8.24203C4.6362 7.4468 4.37783 7.25412 3.55241 7.25175C2.7786 7.24964 2.00507 7.25754 1.23127 7.24911C0.512247 7.24148 0.0157813 6.79109 0.000242059 6.15064C-0.0160873 5.48281 0.475637 5.01689 1.23232 5.00873C2.11121 4.99952 2.99089 4.99214 3.86951 5.01268C5.36154 5.04769 6.52014 5.93215 6.96393 7.35415C7.14171 7.92378 7.34055 8.49026 7.46382 9.07201C7.54968 9.47713 7.77881 9.49661 8.10566 9.49582C11.8335 9.48897 15.5611 9.49134 19.2889 9.49134C21.0825 9.49134 22.8761 9.48108 24.6694 9.49503C26.0848 9.50608 27.0907 10.4906 27.0156 11.7778C27.0006 12.0363 26.925 12.2958 26.8473 12.5457C26.1317 14.8411 25.4124 17.1351 24.6879 19.4279C24.1851 21.0186 23.0223 21.8826 21.3504 21.8944C19.7151 21.906 18.0797 21.897 16.4444 21.897Z"
                             fill="#6E6D79" />
                         <path
                             d="M12.4012 27.5161C11.167 27.5227 10.1488 26.524 10.1345 25.2928C10.1201 24.0419 11.1528 22.9982 12.3967 23.0066C13.6209 23.0151 14.6422 24.0404 14.6436 25.2623C14.6451 26.4855 13.6261 27.5095 12.4012 27.5161Z"
                             fill="#6E6D79" />
                         <path
                             d="M22.509 25.2393C22.5193 26.4842 21.5393 27.4971 20.3064 27.5155C19.048 27.5342 18.0272 26.525 18.0277 25.2622C18.0279 24.0208 19.0214 23.0161 20.2572 23.0074C21.4877 22.9984 22.4988 24.0006 22.509 25.2393Z"
                             fill="#6E6D79" />
                         <circle cx="26.9523" cy="8" r="8" fill="#AE1C9A" />
                         <text id="cart-count" x="25.9322" y="11.5" text-anchor="middle" font-size="10"
                             fill="white" font-weight="bold">
                             {{ $cart->sum('quantity') }}
                         </text>
                     </svg>
                 </span>
             </a>
         </div>
         <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions">
             <div class="offcanvas-body">
                 <div class="header-top">
                     <div class="header-cart">
                         <div class="header-compaire">
                             <a href="{{ route('compare.index') }}" class="cart-item">
                                 <span>
                                     <svg width="34" height="27" viewBox="0 0 34 27" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                         <path
                                             d="M22 16.0094C21.997 22.0881 17.0653 27.007 10.9802 27C4.90444 26.9931 -0.00941233 22.0569 1.3538e-05 15.9688C0.00943941 9.89602 4.95157 4.98663 11.0422 5.00003C17.0961 5.01342 22.003 9.94315 22 16.0094ZM6.16553 15.7812C6.40365 12.6236 8.72192 11.2861 10.5868 11.1993C12.3305 11.1179 14.4529 12.3353 14.7465 13.6143C14.2425 13.6143 13.7459 13.6143 13.2429 13.6143C13.2429 14.0241 13.2429 14.3986 13.2429 14.7975C14.308 14.7975 15.3374 14.8064 16.3668 14.793C16.7805 14.7876 17.0102 14.5291 17.0147 14.1005C17.0221 13.3414 17.0172 12.5824 17.0172 11.8234C17.0172 11.558 17.0172 11.2925 17.0172 11.0311C16.5836 11.0311 16.2165 11.0311 15.7908 11.0311C15.7908 11.6046 15.7908 12.1572 15.7908 12.7937C13.9379 10.0444 10.8447 9.4545 8.48578 10.4824C6.21811 11.4706 4.90792 13.847 5.04682 15.7817C5.40997 15.7812 5.77609 15.7812 6.16553 15.7812ZM15.8191 16.2178C15.7581 17.4576 15.3498 18.547 14.4742 19.4286C13.5976 20.3111 12.5265 20.772 11.2858 20.8008C9.57472 20.8405 7.568 19.6424 7.2495 18.3892C7.75403 18.3892 8.25013 18.3892 8.76012 18.3892C8.76012 17.9809 8.76012 17.6064 8.76012 17.2041C7.68458 17.2041 6.64178 17.1921 5.59997 17.21C5.19962 17.2169 5.00069 17.4839 4.99771 17.9442C4.99176 18.803 4.99573 19.6612 4.99573 20.52C4.99573 20.6698 4.99573 20.8196 4.99573 20.964C5.4318 20.964 5.79692 20.964 6.20224 20.964C6.20224 20.3895 6.20224 19.8418 6.20224 19.1686C7.07984 20.4912 8.16976 21.3465 9.58216 21.7617C11.0184 22.1839 12.4114 22.0494 13.7548 21.4035C15.8191 20.4113 17.0946 18.1466 16.9507 16.2178C16.5861 16.2178 16.2209 16.2178 15.8191 16.2178Z"
                                             fill="#6E6D79" />
                                         <path
                                             d="M6.16568 15.7814C5.77624 15.7814 5.41062 15.7814 5.04648 15.7814C4.90757 13.8471 6.21777 11.4703 8.48543 10.482C10.8444 9.45411 13.9376 10.044 15.7905 12.7934C15.7905 12.1569 15.7905 11.6042 15.7905 11.0307C16.2161 11.0307 16.5833 11.0307 17.0168 11.0307C17.0168 11.2917 17.0168 11.5571 17.0168 11.823C17.0168 12.582 17.0218 13.341 17.0144 14.1001C17.0104 14.5287 16.7802 14.7877 16.3665 14.7926C15.3371 14.8055 14.3076 14.7971 13.2425 14.7971C13.2425 14.3982 13.2425 14.0237 13.2425 13.6139C13.7451 13.6139 14.2417 13.6139 14.7462 13.6139C14.4525 12.3355 12.3302 11.118 10.5864 11.1989C8.72207 11.2862 6.4038 12.6237 6.16568 15.7814Z"
                                             fill="white" />
                                         <path
                                             d="M15.8191 16.2178C16.2209 16.2178 16.5865 16.2178 16.9502 16.2178C17.094 18.1466 15.8186 20.4108 13.7543 21.4035C12.4109 22.0494 11.0178 22.1834 9.58161 21.7617C8.16971 21.3469 7.07978 20.4912 6.20169 19.1686C6.20169 19.8418 6.20169 20.3895 6.20169 20.9639C5.79687 20.9639 5.43125 20.9639 4.99518 20.9639C4.99518 20.8201 4.99518 20.6703 4.99518 20.5199C4.99518 19.6612 4.99121 18.8029 4.99716 17.9442C5.00014 17.4838 5.19907 17.2169 5.59943 17.21C6.64173 17.1916 7.68403 17.204 8.75957 17.204C8.75957 17.6064 8.75957 17.9809 8.75957 18.3892C8.25008 18.3892 7.75348 18.3892 7.24895 18.3892C7.56794 19.6428 9.57466 20.8404 11.2852 20.8007C12.526 20.772 13.597 20.3111 14.4736 19.4285C15.3492 18.547 15.758 17.457 15.8191 16.2178Z"
                                             fill="white" />
                                         <circle cx="25.9322" cy="8" r="8" fill="#AE1C9A" />
                                         <text class="compare_count" x="25.9322" y="11.5" text-anchor="middle"
                                             font-size="10" fill="white" font-weight="bold">
                                             {{ $compare ? count($compare) : 0 }}
                                         </text>
                                     </svg>
                                 </span>
                             </a>
                         </div>
                         <div class="header-favourite">
                             <a href="{{ route('wishlist.index') }}" class="cart-item">
                                 <span>
                                     <svg width="35" height="27" viewBox="0 0 35 27" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                         <path
                                             d="M11.4047 8.54989C11.6187 8.30247 11.8069 8.07783 12.0027 7.86001C15.0697 4.45162 20.3879 5.51717 22.1581 9.60443C23.4189 12.5161 22.8485 15.213 20.9965 17.6962C19.6524 19.498 17.95 20.9437 16.2722 22.4108C15.0307 23.4964 13.774 24.5642 12.5246 25.6408C11.6986 26.3523 11.1108 26.3607 10.2924 25.6397C8.05177 23.6657 5.79225 21.7125 3.59029 19.6964C2.35865 18.5686 1.33266 17.2553 0.638823 15.7086C-0.626904 12.8872 0.0324709 9.41204 2.22306 7.41034C4.84011 5.01855 8.81757 5.36918 11.1059 8.19281C11.1968 8.30475 11.2907 8.41404 11.4047 8.54989Z"
                                             fill="#6E6D79" />
                                         <circle cx="26.7662" cy="8" r="8" fill="#AE1C9A" />
                                         <text class="wishlist_count" x="25.9322" y="11.5" text-anchor="middle"
                                             font-size="10" fill="white" font-weight="bold">
                                             {{ $wishlists ? count($wishlists) : 0 }}
                                         </text>
                                     </svg>
                                 </span>
                             </a>
                         </div>
                     </div>
                     <div class="shop-btn">
                         <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                             aria-label="Close"></button>
                     </div>
                 </div>
                 <div class="header-input">
                     <input type="text" placeholder="Search...." />
                     <span>
                         <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                             <path
                                 d="M13.9708 16.4151C12.5227 17.4021 10.9758 17.9723 9.27353 18.0062C5.58462 18.0802 2.75802 16.483 1.05056 13.1945C-1.76315 7.77253 1.33485 1.37571 7.25086 0.167548C12.2281 -0.848249 17.2053 2.87895 17.7198 7.98579C17.9182 9.95558 17.5566 11.7939 16.5852 13.5061C16.4512 13.742 16.483 13.8725 16.6651 14.0553C18.2412 15.6386 19.8112 17.2272 21.3735 18.8244C22.1826 19.6513 22.2058 20.7559 21.456 21.4932C20.7697 22.1678 19.7047 22.1747 18.9764 21.4793C18.3623 20.8917 17.7774 20.2737 17.1796 19.6688C16.118 18.5929 15.0564 17.5153 13.9708 16.4151ZM2.89545 9.0364C2.91692 12.4172 5.59664 15.1164 8.91967 15.1042C12.2384 15.092 14.9138 12.3493 14.8889 8.98505C14.864 5.63213 12.1826 2.92508 8.89047 2.92857C5.58204 2.93118 2.87397 5.68958 2.89545 9.0364Z"
                                 fill="black"></path>
                         </svg>
                     </span>
                 </div>
                 <div class="category-dropdown">
                     <ul class="category-list">
                         @foreach ($categories as $category)
                             <li class="category-list-item">
                                 <a href="product-sidebar.html">
                                     <div class="dropdown-item d-flex justify-content-between align-items-center">
                                         <div class="dropdown-list-item d-flex">
                                             <span class="dropdown-img">
                                                 <img src="{{ $category->img_path }}" alt="{{ $category->name }}" />
                                             </span>
                                             <span class="dropdown-text"> {{ $category->name }} </span>
                                         </div>
                                         <div class="drop-down-list-icon">
                                             <span>
                                                 <svg width="6" height="9" viewBox="0 0 6 9" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                     <rect x="1.5" y="0.818359" width="5.78538" height="1.28564"
                                                         transform="rotate(45 1.5 0.818359)" />
                                                     <rect x="5.58984" y="4.90918" width="5.78538" height="1.28564"
                                                         transform="rotate(135 5.58984 4.90918)" />
                                                 </svg>
                                             </span>
                                         </div>
                                     </div>
                                 </a>
                             </li>
                         @endforeach

                     </ul>
                 </div>
             </div>
         </div>
     </nav>
     <div class="header-bottom d-lg-block d-none">
         <div class="container">
             <div class="header-nav">
                 <div class="category-menu-section position-relative">
                     <div class="empty position-fixed" onclick="tooglmenu()"></div>
                     <button class="dropdown-btn" onclick="tooglmenu()">
                         <span class="dropdown-icon">
                             <svg width="14" height="9" viewBox="0 0 14 9" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <rect width="14" height="1" />
                                 <rect y="8" width="14" height="1" />
                                 <rect y="4" width="10" height="1" />
                             </svg>
                         </span>
                         <span class="list-text"> {{ trans('main.all_categories') }} </span>
                     </button>
                     <div class="category-dropdown position-absolute" id="subMenu">
                         <ul class="category-list">
                             @foreach ($categories as $category)
                                 <li class="category-list-item">
                                     <a href="product-sidebar.html">
                                         <div class="dropdown-item">
                                             <div class="dropdown-list-item">
                                                 <span class="dropdown-img">
                                                     <img src="{{ $category->img_path }}"
                                                         alt="{{ $category->name }}" />
                                                 </span>
                                                 <span class="dropdown-text"> {{ $category->name }} </span>
                                             </div>
                                             <div class="drop-down-list-icon">
                                                 <span>
                                                     <svg width="6" height="9" viewBox="0 0 6 9"
                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                         <rect x="1.5" y="0.818359" width="5.78538" height="1.28564"
                                                             transform="rotate(45 1.5 0.818359)" fill="#1D1D1D" />
                                                         <rect x="5.58984" y="4.90918" width="5.78538"
                                                             height="1.28564" transform="rotate(135 5.58984 4.90918)"
                                                             fill="#1D1D1D" />
                                                     </svg>
                                                 </span>
                                             </div>
                                         </div>
                                     </a>
                                 </li>
                             @endforeach

                         </ul>
                     </div>
                 </div>
                 <div class="header-nav-menu">
                     <ul class="menu-list">
                         <li>
                             <a href="index-2.html">
                                 <span class="list-text">{{ trans('main.home') }}</span>
                             </a>
                         </li>

                         <li>
                             <a href="#">
                                 <span class="list-text">{{ trans('main.pages') }}</span>
                                 <span>
                                     <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                         <g clip-path="url(#clip0_1_183)">
                                             <path
                                                 d="M2.37811 5.89491C1.88356 5.89491 1.38862 5.90351 0.894066 5.89218C0.443267 5.88202 0.108098 5.59451 0.0178597 5.17027C-0.0641747 4.7851 0.137786 4.36204 0.508895 4.20305C0.659291 4.13859 0.83586 4.11008 1.00071 4.10851C1.93786 4.09992 2.87539 4.10461 3.81254 4.10422C4.07075 4.10422 4.10357 4.07062 4.10396 3.80889C4.10474 2.85847 4.102 1.90843 4.10513 0.958001C4.10669 0.513061 4.336 0.177111 4.71218 0.0501527C5.30752 -0.151027 5.88567 0.278287 5.89387 0.937687C5.90168 1.56232 5.89582 2.18735 5.89582 2.81237C5.89582 3.14441 5.89504 3.47646 5.89621 3.80811C5.897 4.07023 5.92942 4.10422 6.18685 4.10422C7.13728 4.105 8.08732 4.10265 9.03774 4.10539C9.48503 4.10656 9.81941 4.33235 9.94872 4.70776C10.1534 5.30192 9.72605 5.88437 9.06782 5.89413C8.50803 5.90233 7.94825 5.89608 7.38846 5.89608C6.97829 5.89608 6.56851 5.89491 6.15833 5.89687C5.93918 5.89804 5.897 5.94023 5.8966 6.1625C5.89543 7.11918 5.89778 8.07625 5.89543 9.03293C5.89426 9.48216 5.67238 9.81577 5.29736 9.94741C4.70437 10.1552 4.11841 9.72983 4.10669 9.07316C4.09771 8.57861 4.10474 8.08367 4.10474 7.58912C4.10474 7.12035 4.10552 6.65197 4.10435 6.1832C4.10396 5.93398 4.06841 5.89726 3.82387 5.89687C3.34221 5.89569 2.86055 5.89647 2.37889 5.89647C2.37811 5.8953 2.37811 5.8953 2.37811 5.89491Z"
                                                 fill="white" />
                                         </g>
                                         <defs>
                                             <clipPath id="clip0_1_18">
                                                 <rect width="10" height="10" fill="white" />
                                             </clipPath>
                                         </defs>
                                     </svg>
                                 </span>
                             </a>
                             <ul class="header-sub-menu">
                                 @foreach ($pages as $page)
                                     <li><a href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a>
                                     </li>
                                 @endforeach

                             </ul>
                         </li>
                         <li>
                             <a href="{{ route('about') }}">
                                 <span class="list-text">{{ trans('main.about') }}</span>
                             </a>
                         </li>

                         <li>
                             <a href="{{ route('profile') }}">
                                 <span class="list-text">{{ trans('main.user_dashboard') }}</span>
                             </a>
                         </li>
                         <li>
                             <a href="{{ route('contact') }}">
                                 <span class="list-text">{{ trans('main.contact') }}</span>
                             </a>
                         </li>
                         <li>
                             <a href="{{ route('faqs') }}">
                                 <span class="list-text">{{ trans('main.faq') }}</span>
                             </a>
                         </li>
                     </ul>
                 </div>

             </div>
         </div>
     </div>
 </header>
