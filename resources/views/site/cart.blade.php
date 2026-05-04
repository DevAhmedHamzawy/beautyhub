@extends('site.layouts.app')

@section('title', 'Cart')

@section('content')

    <section class="blog about-blog">
        <div class="container">
            <div class="blog-bradcrum">
                <span><a href="{{ url('/') }}">{{ trans('main.home') }}</a></span>
                <span class="devider">/</span>
                <span><a href="#">{{ trans('main.cart') }}</a></span>
            </div>
            <div class="blog-heading about-heading">
                <h1 class="heading">{{ trans('main.cart') }}</h1>
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
                                <h5 class="table-heading">{{ trans('main.product') }}</h5>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">{{ trans('main.price') }}</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">{{ trans('main.quantity') }}</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">{{ trans('main.tax_rate') }}</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">{{ trans('main.tax') }}</h5>
                                </div>
                            </td>
                            <td class="table-wrapper wrapper-total">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">{{ trans('main.total') }}</h5>
                                </div>
                            </td>
                            <td class="table-wrapper">
                                <div class="table-wrapper-center">
                                    <h5 class="table-heading">{{ trans('main.action') }}</h5>
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
                                        <h5 class="heading">{{ $item['unit_price'] }} <span
                                                style="font-family: 'Arshid';">$</span></h5>
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
                                        <h5 class="heading">{{ $item['tax_rate'] }} <span
                                                style="font-family: 'Arshid';">$</span></h5>
                                    </div>
                                </td>
                                <td class="table-wrapper">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading total-tax">{{ $item['tax'] }} <span
                                                style="font-family: 'Arshid';">$</span></h5>
                                    </div>
                                </td>
                                <td class="table-wrapper wrapper-total">
                                    <div class="table-wrapper-center">
                                        <h5 class="heading line-total">{{ number_format($item['total'], 2) }} <span
                                                style="font-family: 'Arshid';">$</span></h5>
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
                                    <h5 class="heading" id="cart-subtotal">{{ number_format($subtotal, 2) }} <span
                                            style="font-family: 'Arshid';">$</span></h5>
                                </div>
                            </td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="wishlist-btn cart-btn">
                <a href="{{ route('checkout') }}" class="shop-btn">{{ trans('main.proceed_to_checkout') }}</a>
            </div>
        </div>
    </section>
@endsection


@section('footer')
    <script>
        $(document).on('click', '.qty-btn', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation(); // 👈 دي المهمة

            let wrapper = $(this).closest('.quantity');
            let stockId = wrapper.data('stock');
            let numberEl = wrapper.find('.number');

            let quantity = parseInt(numberEl.text()) || 1;

            numberEl.text(quantity);

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
                        row.find('.line-total').html(
                            item.total + ' <span style="font-family: \'Arshid\';">$</span>'
                        );

                        row.find('.total-tax').html(
                            item.tax + ' <span style="font-family: \'Arshid\';">$</span>'
                        );
                    }

                    // تحديث subtotal
                    $('#cart-subtotal').html(
                        res.subtotal + ' <span style="font-family: \'Arshid\';">$</span>'
                    );
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
