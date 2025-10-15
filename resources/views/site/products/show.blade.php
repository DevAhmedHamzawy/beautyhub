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
                });
        }
    </script>

@endsection
