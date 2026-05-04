 <section class="product product-description">
     <div class="container">
         <div class="product-detail-section">
             <nav>
                 <div class="nav nav-tabs nav-item" id="nav-tab" role="tablist">
                     <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                         type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                         {{ trans('main.description') }}
                     </button>
                     <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review"
                         type="button" role="tab" aria-controls="nav-review" aria-selected="false">
                         {{ trans('main.reviews') }}
                     </button>
                 </div>
             </nav>
             <div class="tab-content tab-item" id="nav-tabContent">
                 <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                     tabindex="0" data-aos="fade-up">
                     {{ $product->description }}
                 </div>
                 <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab"
                     tabindex="0">
                     <div class="product-review-section" data-aos="fade-up">
                         <h5 class="intro-heading">{{ trans('main.reviews') }}</h5>
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
                                     <textarea name="review" class="form-control" rows="4" placeholder="{{ trans('main.write_your_review') }}"></textarea>
                                 </div>

                                 {{-- Submit --}}
                                 <button class="btn btn-primary">
                                     {{ trans('main.send_review') }} ⭐
                                 </button>
                             </form>
                             @foreach ($product->ratings as $rating)
                                 <div class="wrapper">
                                     <div class="wrapper-aurthor">
                                         <div class="wrapper-info">
                                             <div class="aurthor-img">
                                                 <img src="{{ $rating->user->img_path }}" width="50"
                                                     alt="author-img" />
                                             </div>
                                             <div class="author-details">
                                                 <h5>{{ $rating->user->name }}</h5>
                                                 <p>{{ $rating->user->defaultAddress?->full_location ?? 'Unknown' }}
                                                 </p>
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
