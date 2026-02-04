@extends('site.layouts.app')

@section('title', 'Cart')

@section('content')

    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="index-2.html">Home</a></span>
                <span class="devider">/</span>
                <span><a href="#">Cart</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">Cart</h1>
            </div>
        </div>
    </section>

    <section class="product-cart product footer-padding">
        <div class="container">
            <div class="cart-section">
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
                                    <h5 class="table-heading">QUANTITY</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">Tax Rate</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">Tax</h5>
                                </div>
                            </td>
                            <td class="table-wrapper wrapper-total">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">TOTAL</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">ACTION</h5>
                                </div>
                            </td>
                        </tr>
                        @foreach ($cartItems as $item)
                            <tr class="table-row ticket-row" data-stock="{{ $item['stock_id'] }}">
                                <td class="table-wrapper wrapper-product">
                                    <div class="wrapper">
                                        <div class="wrapper-img">
                                            <img src="{{ $item['img_path'] }}" alt="img" />
                                        </div>
                                        <div class="wrapper-content">
                                            <h5 class="heading">
                                                {{ $item['product_name'] }}
                                                <br>
                                                @foreach ($item['attributes'] as $key => $value)
                                                    {{ $key }} : {{ $value }} <br>
                                                @endforeach
                                            </h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading">{{ $item['unit_price'] }}</h5>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <div class="quantity" data-stock="{{ $item['stock_id'] }}">

                                            <button class="qty-btn minus" type="button">−</button>

                                            <span class="number">{{ $item['quantity'] }}</span>

                                            <button class="qty-btn plus" type="button">+</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading">{{ $item['tax_rate'] }}</h5>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading total-tax">{{ $item['tax'] }}</h5>
                                    </div>
                                </td>
                                <td class="table-wrapper wrapper-total">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading line-total">{{ number_format($item['total'], 2) }} EGP</h5>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <span class="remove-item" data-stock="{{ $item['stock_id'] }}"
                                            style="cursor:pointer;">
                                            ✕
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <tr class="table-row">
                            <td colspan="5" class="table-wrapper wrapper-total">
                                <div class="table-wrapper-center">
                                    <h5 class="heading">Subtotal</h5>
                                </div>
                            </td>
                            <td class="table-wrapper wrapper-total">
                                <div class="table-wrapper-center">
                                    <h5 class="heading" id="cart-subtotal">{{ number_format($subtotal, 2) }} EGP</h5>
                                </div>
                            </td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="wishlist-btn cart-btn">
                <a href="empty-cart.html" class="clean-btn">Clear Cart</a>
                <a href="#" class="shop-btn update-btn">Update Cart</a>
                <a href="{{ route('checkout') }}" class="shop-btn">Proceed to Checkout</a>
            </div>
        </div>
    </section>
@endsection


@section('footer')
    <script>
        $(document).on('click', '.qty-btn', function() {

            let wrapper = $(this).closest('.quantity');
            let stockId = wrapper.data('stock');
            let numberEl = wrapper.find('.number');

            let quantity = parseInt(numberEl.text());

            if ($(this).hasClass('plus')) {
                quantity++;
            }

            if ($(this).hasClass('minus')) {
                if (quantity <= 1) return;
                quantity--;
            }

            // تحديث UI مباشرة
            numberEl.text(quantity);

            // إرسال التحديث للسيرفر
            updateCart(stockId, quantity);
        });


        function updateCart(stockId, quantity) {

            $.ajax({
                url: '/cart/update',
                method: 'POST',
                data: {
                    stock_id: stockId,
                    quantity: quantity,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {

                    // تحديث total للسطر
                    let item = res.items[stockId];
                    if (item) {
                        let row = $('tr[data-stock="' + stockId + '"]');
                        row.find('.line-total').text(item.total);
                        row.find('.total-tax').text(item.tax);
                    }

                    // تحديث subtotal
                    $('#cart-subtotal').text(res.subtotal);
                },
                error: function() {
                    toastr.error('Update failed');
                }
            });
        }

        $(document).on('click', '.remove-item', function() {

            let stockId = $(this).data('stock');
            let row = $(this).closest('tr');

            $.ajax({
                url: "/cart/remove",
                method: "DELETE",
                data: {
                    stock_id: stockId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {

                    if (res.success) {
                        // شيل الصف
                        row.fadeOut(300, function() {
                            $(this).remove();
                        });

                        // حدث subtotal
                        $('#cart-subtotal').text(res.subtotal + ' EGP');
                    }
                }
            });
        });
    </script>
@endsection
