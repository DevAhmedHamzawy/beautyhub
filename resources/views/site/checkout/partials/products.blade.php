<div class="col-lg-6">
    <div class="checkout-wrapper">
        <a href="#" class="shop-btn">Enter Coupon Code</a>
        <div class="account-section billing-section">
            <h5 class="wrapper-heading">Order Summary</h5>
            <div class="order-summery">
                <div class="subtotal product-total">
                    <h5 class="wrapper-heading">PRODUCT</h5>
                    <h5 class="wrapper-heading">TOTAL</h5>
                </div>
                <hr />
                <div class="subtotal product-total">
                    <ul class="product-list">

                        @foreach ($cartItems as $item)
                            <li>
                                <div class="product-info">
                                    <h5 class="wrapper-heading">{{ $item['product_name'] }}</h5>
                                    <ul>
                                        @foreach ($item['attributes'] as $key => $value)
                                            <li>{{ $key }}: {{ $value }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="price">
                                    <h5 class="wrapper-heading">${{ $item['price'] }}</h5>
                                </div>
                                <div class="quantity">
                                    <h5 class="wrapper-heading">x{{ $item['quantity'] }}</h5>
                                </div>
                                <div class="price">
                                    <h5 class="wrapper-heading">{{ number_format($item['subtotal'], 2) }}</h5>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <hr />
                <div class="subtotal product-total">
                    <h5 class="wrapper-heading">SUBTOTAL</h5>
                    <h5 class="wrapper-heading">{{ $subtotal }}</h5>
                </div>
                <div class="subtotal product-total">
                    <ul class="product-list">
                        <li>
                            <div class="product-info">
                                <p class="paragraph">SHIPPING</p>
                            </div>
                            <div class="price">
                                <h5 class="wrapper-heading">+{{ $shipping_cost }}</h5>
                            </div>
                        </li>
                    </ul>
                </div>
                <hr />
                <div class="subtotal total">
                    <h5 class="wrapper-heading">TOTAL</h5>
                    <h5 class="wrapper-heading price">{{ $subtotal + $shipping_cost }}</h5>
                </div>
                <div class="subtotal payment-type">
                    {{-- <div class="checkbox-item">
                        <input type="radio" value="bank" name="payment_method" />
                        <div class="bank">
                            <h5 class="wrapper-heading">Direct Bank Transfer</h5>
                            <p class="paragraph">
                                Make your payment directly into our bank account.
                                Please use
                                <span class="inner-text">
                                    your Order ID as the payment reference.
                                </span>
                            </p>
                        </div>
                    </div> --}}
                    <div class="checkbox-item">
                        <input type="radio" value="cod" name="payment_method" />
                        <div class="cash">
                            <h5 class="wrapper-heading">Cash on Delivery</h5>
                        </div>
                    </div>
                    {{-- <div class="checkbox-item">
                        <input type="radio" id="credit" name="payment_method" />
                        <div class="credit">
                            <h5 class="wrapper-heading">
                                Credit/Debit Cards or Paypal
                            </h5>
                        </div>
                    </div> --}}
                </div>
                <button type="submit" class="shop-btn">Place Order Now</button>
            </div>
        </div>
    </div>
</div>
