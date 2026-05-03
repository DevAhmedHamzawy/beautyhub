 <div class="tab-pane fade" id="v-pills-review" role="tabpanel" aria-labelledby="v-pills-review-tab" tabindex="0">
     <div class="top-selling-section">
         <div class="row g-5">
             @foreach (auth()->user()->reviews as $review)
                 <div class="col-md-6">
                     <div class="product-wrapper">
                         <div class="product-img">
                             <img src="{{ $review->product->img_path }}" alt="product-img" />
                         </div>
                         <div class="product-info">
                             <div class="review-date">
                                 <p>{{ $review->created_at->diffForHumans() }}</p>
                             </div>
                             <div class="ratings">
                                 <span>
                                     @php
                                         $rating = round($review->product->averageRating());
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
                             <div class="product-description">
                                 <a href="{{ route('products.show', $review->product->slug) }}"
                                     class="product-details">{{ $review->product->name }}
                                 </a>
                                 <p>
                                     {{ $review->review }}
                                 </p>
                             </div>
                         </div>
                         <div class="product-cart-btn">
                             <a href="{{ route('products.show', $review->product->slug) }}"
                                 class="product-btn">{{ trans('main.edit_review') }}</a>
                         </div>
                     </div>
                 </div>
             @endforeach


         </div>
     </div>
 </div>
