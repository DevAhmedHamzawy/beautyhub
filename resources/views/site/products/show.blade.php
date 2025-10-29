@extends('site.layouts.app')

@section('title', $product->translate($locale)->name)

@section('content')

    @include('site.products.partials.info')

    @include('site.products.partials.description')

    @include('site.products.partials.best_week_sell')

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
                    if (!priceBox) return;

                    if (data.discounted) {
                        priceBox.innerHTML =
                            `<span class="price-cut">${data.original}</span> <span class="new-price">${data.discounted}</span>`;
                    } else {
                        priceBox.innerHTML = `<span class="new-price">${data.original}</span>`;
                    }

                    $('.shop-btn').attr('data-stock', data.stock_id);

                });
        }

        $(document).on('click', '.shop-btn', function(e) {
            e.preventDefault();

            let product_id = $(this).data('product');
            let stock_id = $(this).data('stock');
            let quantity = 1;

            // نجمع كل الـ attributes اللي المستخدم اختارها
            let selectedAttributes = {};

            $('.product-size').each(function() {
                let attribute_id = $(this).data('attribute-id');
                let selectedOption = $(this).find('.option.selected');
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
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error('Please select all options.');
                    } else {
                        toastr.error('Something went wrong.');
                    }
                },
                complete: function() {
                    $('.add-to-cart-btn').prop('disabled', false).text('Add to Cart');
                }
            });
        });
    </script>

@endsection
