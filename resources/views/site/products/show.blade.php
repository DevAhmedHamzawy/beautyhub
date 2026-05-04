@extends('site.layouts.app')

@section('title', $product->translate($locale)->name)

@section('content')

    @include('site.products.partials.show.info')

    @include('site.products.partials.show.description')

    @include('site.products.partials.show.related_products')

@endsection


@section('footer')

    <script>
        // تنفيذ الطلب اول مرة (القيم الافتراضية مُعلمة من السيرفر)
        document.addEventListener("DOMContentLoaded", function() {
            let productId = document.querySelector("#product-price").dataset.id;
            fetchPrice(productId);
        });

        document.querySelectorAll(".product-size").forEach(function(pdSize) {
            let pdBtn = pdSize.querySelector(".size-section"),
                pdOption = pdSize.querySelectorAll(".option"),
                pdBtn_Text = pdSize.querySelector(".size-text"),
                pdBtn_Text2 = pdSize.querySelector(".toggle-btn2");

            let defaultOption = pdSize.querySelector(".option[data-default='true']");
            if (defaultOption) {
                defaultOption.classList.add("selected");
                pdBtn_Text.innerHTML = defaultOption.querySelector(".option-text").innerText;
            }

            if (pdBtn) {
                pdBtn.addEventListener("click", () => {
                    pdSize.classList.toggle("active");
                });
            }

            // عند اختيار قيمة جديدة
            pdOption.forEach((option) => {
                option.addEventListener("click", () => {
                    let selectedOption = option.querySelector(".option-text").innerText;

                    pdBtn_Text.innerHTML = selectedOption;

                    pdOption.forEach((opt) => opt.classList.remove("selected"));

                    option.classList.add("selected");

                    pdSize.classList.remove("active");

                    // طلب السعر الجديد
                    let productId = document.querySelector("#product-price").dataset.id;
                    fetchPrice(productId);
                });
            });
        });


        // دالة ترجع القيم المختارة (من الـ DOM .option.selected)
        function getSelectedAttributes() {
            let selected = {};
            document.querySelectorAll(".product-size").forEach(function(pdSize) {
                let selectedOption = pdSize.querySelector(".option.selected");
                if (selectedOption) {
                    let attrId = selectedOption.dataset.attr;
                    let valueId = selectedOption.dataset.value;
                    selected[attrId] = valueId;
                }
            });
            return selected;
        }

        // جلب السعر من السيرفر
        function fetchPrice(productId) {
            let selected = getSelectedAttributes();

            fetch(`/products/${productId}/price`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        attributes: selected,
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    let priceBox = document.querySelector("#product-price");
                    let availability = document.getElementById("availability-text");
                    let addToCartBtns = document.querySelectorAll('.add_to_cart');

                    let discountBox = document.getElementById("product-discount-box");
                    let discountValue = document.getElementById("product-discount-value");

                    if (!priceBox) return;

                    if (data.discounted) {
                        priceBox.innerHTML =
                            `<span class="price-cut">${data.original}  <span
                                                      style="font-family: 'Arshid';">$</span></span>  <span class="new-price">${data.discounted}  <span
                                                      style="font-family: 'Arshid';">$</span></span>`;

                        // ===== اظهار الخصم =====
                        if (discountBox && discountValue) {
                            discountValue.innerText = `- ${data.discount}%`;
                            discountBox.classList.remove("d-none");
                        }
                    } else {
                        priceBox.innerHTML = `<span class="new-price">${data.original}  <span
                                                      style="font-family: 'Arshid';">$</span></span>`;

                        // ===== اخفاء الخصم =====
                        if (discountBox) {
                            discountBox.classList.add("d-none");
                        }
                    }

                    if (data.out_of_stock) {
                        availability.innerText = "{!! trans('main.out_of_stock') !!}";
                        availability.classList.add("text-danger");

                        addToCartBtns.forEach(btn => {
                            btn.classList.add("disabled");
                            btn.setAttribute("disabled", true);
                            btn.removeAttribute("data-stock");
                        });

                    } else {
                        availability.innerText = "{!! trans('main.in_stock') !!}";
                        availability.classList.remove("text-danger");

                        addToCartBtns.forEach(btn => {
                            btn.classList.remove("disabled");
                            btn.removeAttribute("disabled");
                            btn.setAttribute("data-stock", data.stock_id);
                        });
                    }

                });
        }

        $(document).on('click', '.quantity .plus', function() {
            let $number = $(this).siblings('.number');
            let current = parseInt($number.text());
            $number.text(current + 1);
        });

        // نقص الكمية
        $(document).on('click', '.quantity .minus', function() {
            let $number = $(this).siblings('.number');
            let current = parseInt($number.text());
            if (current > 1) { // عشان ما ينقصش عن 1
                $number.text(current - 1);
            }
        });

        $(document).on('click', '.add_to_cart', function(e) {
            e.preventDefault();

            let product_id = $(this).data('product');
            let stock_id = $(this).data('stock');
            let quantity = parseInt($(this).closest('.product').find('.quantity .number').text());

            // نجمع كل الـ attributes اللي المستخدم اختارها
            let parent = $(this).closest('.col-md-6');

            let selectedAttributes = {};

            parent.find('.product-size').each(function() {

                let selectedOption = $(this).find('.option.selected');

                if (!selectedOption.length) {
                    selectedOption = $(this).find('.option').first();
                    selectedOption.addClass('selected');
                }

                let attribute_id = $(this).data('attribute-id');
                let value_id = selectedOption.data('value');

                if (attribute_id && value_id) {
                    selectedAttributes[attribute_id] = value_id;
                }
            });

            console.log("Selected Attributes:", selectedAttributes);

            $.ajax({
                url: '/cart/add',
                type: 'POST',
                data: {
                    product_id: product_id,
                    stock_id: stock_id,
                    attributes: selectedAttributes,
                    quantity: quantity,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('.add-to-cart-btn').prop('disabled', true).text('Adding...');
                },
                success: function(response) {
                    toastr.success(response.message || 'Added to cart successfully!');

                    $('#cart-count').text(response.cart.count);

                    let itemsHtml = '';

                    response.cart.items.forEach(item => {
                        itemsHtml += `
                            <div class="wrapper">
                                <div class="wrapper-item">
                                    <div class="wrapper-img">
                                        <img src="${item.image}" alt="${item.name}" />
                                    </div>
                                    <div class="wrapper-content">
                                        <h5 class="wrapper-title">${item.name}</h5>
                                        <div class="price">
                                            <p class="new-price">$${item.price} <span
                                                         style="font-family: 'Arshid';">$</span></p>
                                        </div>
                                    </div>
                                </div>
                                <span class="close-btn remove-item" data-id="${item.id}" data-stock="${item.stock.id}">
                                    ✕
                                </span>
                            </div>
                        `;
                    });

                    $('#cart-items').html(itemsHtml);

                    $('.wrapper-subtotal .wrapper-title-sub').html(`
                                ${response.cart.subtotal}
                                <span style="font-family: 'Arshid';">$</span>
                            `);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error("{!! trans('main.select_all_options') !!}");
                    } else {
                        toastr.error("{!! trans('main.something_went_wrong') !!}");
                    }
                },
                complete: function() {
                    $('.add-to-cart-btn').prop('disabled', false).text('Add to Cart');
                }
            });
        });

        $(document).on('click', '.remove-item', function() {

            let btn = $(this);
            let stockId = btn.data('stock');
            let wrapper = btn.closest('.wrapper');

            $.ajax({
                url: '/cart/remove',
                type: 'DELETE',
                data: {
                    stock_id: stockId,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {

                    // شيل العنصر من القائمة
                    wrapper.slideUp(300, function() {
                        $(this).remove();

                        // لو الكارت فاضي
                        if ($('#cart-items .wrapper').length === 0) {
                            $('#cart-items').html(
                                '<p class="text-center">{{ trans('main.cart_empty') }}</p>'
                            );
                        }
                    });

                    $('.wrapper-subtotal .wrapper-title-sub').html(`
                                ${response.subtotal}
                                <span style="font-family: 'Arshid';">$</span>
                            `);

                    // تحديث العداد
                    document.getElementById('cart-count').textContent = res.count;

                    toastr.success(res.message);

                }
            });
        });


        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const type = this.dataset.type;
                const url = encodeURIComponent(window.location.href);
                const title = encodeURIComponent(document.title);

                let shareUrl = '';

                switch (type) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                        break;

                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                        break;

                    case 'pinterest':
                        shareUrl =
                            `https://pinterest.com/pin/create/button/?url=${url}&description=${title}`;
                        break;
                }

                window.open(
                    shareUrl,
                    '_blank',
                    'width=600,height=400'
                );
            });
        });
    </script>

@endsection
