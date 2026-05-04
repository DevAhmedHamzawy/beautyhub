<div class="col-lg-6">
    <div class="checkout-wrapper">
        <a href="#" class="shop-btn show-coupon">{{ trans('main.enter_coupon_code') }}</a>

        <div class="coupon-box" style="display: none; margin-top: 10px;">
            <input type="text" class="form-control" name="couponCode" id="couponCode" style="font-size: 20px;"
                placeholder="{{ trans('main.enter_coupon_code') }}">
            <button type="button" class="shop-btn" id="applyCoupon">{{ trans('main.apply') }}</button>
            <p class="coupon-message" style="color: red; margin-top: 5px;"></p>
        </div>
        <div class="account-section billing-section">
            <h5 class="wrapper-heading">{{ trans('main.order_summary') }}</h5>
            <div class="order-summery">
                <div class="subtotal product-total">
                    <h5 class="wrapper-heading">{{ trans('main.product') }}</h5>
                    <h5 class="wrapper-heading">{{ trans('main.price') }}</h5>
                    <h5 class="wrapper-heading">{{ trans('main.tax') }}</h5>
                    <h5 class="wrapper-heading">{{ trans('main.quantity') }}</h5>
                    <h5 class="wrapper-heading">{{ trans('main.total') }}</h5>
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
                                    <h5 class="wrapper-heading"><span
                                            style="font-family: 'Arshid';">$</span>{{ $item['price'] }}</h5>
                                </div>
                                <div class="tax">
                                    <h5 class="wrapper-heading"><span
                                            style="font-family: 'Arshid';">$</span>{{ $item['tax'] }}</h5>
                                </div>
                                <div class="quantity">
                                    <h5 class="wrapper-heading">x{{ $item['quantity'] }}</h5>
                                </div>
                                <div class="price">
                                    <h5 class="wrapper-heading"><span
                                            style="font-family: 'Arshid';">$</span>{{ number_format($item['subtotal'], 2) }}
                                    </h5>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <hr />
                <div class="subtotal product-total">
                    <h5 class="wrapper-heading">{{ trans('main.subtotal') }}</h5>
                    <h5 class="wrapper-heading"><span style="font-family: 'Arshid';">$</span>{{ $subtotal }}</h5>
                </div>
                <div class="subtotal product-total">
                    <ul class="product-list">
                        <li>
                            <div class="product-info">
                                <p class="paragraph">{{ trans('main.shipping') }}</p>
                            </div>
                            <div class="price">
                                <h5 class="wrapper-heading shipping_cost">+<span
                                        style="font-family: 'Arshid';">$</span>{{ $shipping_cost }}</h5>
                            </div>
                        </li>
                    </ul>
                </div>
                <hr />
                <div class="subtotal total">
                    <h5 class="wrapper-heading">{{ trans('main.total') }}</h5>
                    <h5 class="wrapper-heading price total_price">{{ $subtotal + $shipping_cost }}<span
                            style="font-family: 'Arshid';">$</span></h5>
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
                            <h5 class="wrapper-heading">{{ trans('main.cash_on_delivery') }}</h5>
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
                <button type="submit" class="shop-btn">{{ trans('main.place_order_now') }}</button>
            </div>
        </div>
    </div>
</div>
