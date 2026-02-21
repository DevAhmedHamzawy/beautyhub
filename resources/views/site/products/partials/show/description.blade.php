 <section class="product product-description">
     <div class="container">
         <div class="product-detail-section">
             <nav>
                 <div class="nav nav-tabs nav-item" id="nav-tab" role="tablist">
                     <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                         type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                         Description
                     </button>
                     <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review"
                         type="button" role="tab" aria-controls="nav-review" aria-selected="false">
                         Reviews
                     </button>
                     <button class="nav-link" id="nav-seller-tab" data-bs-toggle="tab" data-bs-target="#nav-seller"
                         type="button" role="tab" aria-controls="nav-seller" aria-selected="false">
                         Seller Info
                     </button>
                 </div>
             </nav>
             <div class="tab-content tab-item" id="nav-tabContent">
                 <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                     tabindex="0" data-aos="fade-up">
                     <div class="product-intro-section">
                         <h5 class="intro-heading">Introduction</h5>
                         <p class="product-details">
                             Lorem Ipsum is simply dummy text of the printing and
                             typesetting industry. Lorem Ipsum has been the industry's
                             standard dummy text ever since the 1500s, when an unknown
                             printer took a galley of type and scrambled it to make a type
                             specimen book. It has survived not only five centuries but
                             also the on leap into electronic typesetting, remaining
                             essentially unchanged. It wasn’t popularised in the 1960s with
                             the release of Letraset sheets containing Lorem Ipsum
                             passages, andei more recently with desktop publishing software
                             like Aldus PageMaker including versions of Lorem Ipsum to make
                             a type specimen book.
                         </p>
                     </div>
                     <div class="product-feature">
                         <h5 class="intro-heading">Features :</h5>
                         <ul>
                             <li>
                                 <p>slim body with metal cover</p>
                             </li>
                             <li>
                                 <p>
                                     latest Intel Core i5-1135G7 processor (4 cores / 8
                                     threads)
                                 </p>
                             </li>
                             <li>
                                 <p>8GB DDR4 RAM and fast 512GB PCIe SSD</p>
                             </li>
                             <li>
                                 <p>
                                     NVIDIA GeForce MX350 2GB GDDR5 graphics card backlit
                                     keyboard, touchpad with gesture support
                                 </p>
                             </li>
                         </ul>
                     </div>
                 </div>
                 <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab"
                     tabindex="0">
                     <div class="product-review-section" data-aos="fade-up">
                         <h5 class="intro-heading">Reviews</h5>
                         <div class="review-wrapper">
                             <form action="{{ route('products.rate', $product) }}" method="POST">
                                 @csrf

                                 {{-- ⭐ Stars --}}
                                 <div class="rating-input mb-3">
                                     @for ($i = 5; $i >= 1; $i--)
                                         <input type="radio" name="rating" value="{{ $i }}"
                                             id="star{{ $i }}">
                                         <label for="star{{ $i }}">★</label>
                                     @endfor
                                 </div>

                                 {{-- 📝 Review Text --}}
                                 <div class="mb-3">
                                     <textarea name="review" class="form-control" rows="4" placeholder="اكتب رأيك في المنتج..."></textarea>
                                 </div>

                                 {{-- Submit --}}
                                 <button class="btn btn-primary">
                                     إرسال التقييم ⭐
                                 </button>
                             </form>
                             @foreach ($product->ratings as $rating)
                                 <div class="wrapper">
                                     <div class="wrapper-aurthor">
                                         <div class="wrapper-info">
                                             <div class="aurthor-img">
                                                 <img src="{{ $rating->user->image ?? asset('assets/images/default-user.png') }}"
                                                     alt="author-img" />
                                             </div>
                                             <div class="author-details">
                                                 <h5>{{ $rating->user->name }}</h5>
                                                 <p>{{ $rating->user->country ?? 'Unknown' }}</p>
                                             </div>
                                         </div>

                                         <div class="ratings">
                                             <span>
                                                 @for ($i = 1; $i <= 5; $i++)
                                                     @if ($i <= $rating->rating)
                                                         <i class="fa-solid fa-star text-warning"></i>
                                                     @else
                                                         <i class="fa-regular fa-star text-warning"></i>
                                                     @endif
                                                 @endfor
                                             </span>
                                             <span>({{ number_format($rating->rating, 1) }})</span>
                                         </div>
                                     </div>

                                     <div class="wrapper-description">
                                         <p class="wrapper-details">
                                             {{ $rating->review }}
                                         </p>
                                     </div>
                                 </div>
                             @endforeach
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
