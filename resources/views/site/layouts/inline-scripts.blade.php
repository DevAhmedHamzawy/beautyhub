<script>
    document.querySelectorAll(".favourite").forEach(function(element) {
        element.addEventListener("click", function(e) {
            e.preventDefault(); // منع الرابط الافتراضي

            const productSlug = this.dataset.slug;

            fetch(`{{ route('wishlist.toggle', ['product' => ':slug']) }}`.replace(':slug',
                    productSlug), {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": '{{ csrf_token() }}',
                        "Accept": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === 'guest') {

                        swal({
                            title: data.title,
                            type: data.type, // success, error, info...
                            html: true,
                            text: `
                                <h5>${"{{ trans('main.please_login') }}"}</h5>
                                <div class="swal-custom-buttons">
                                    <a href="{{ route('login') }}" class="swal-btn swal-btn-login">
                                        {{ trans('main.login_site') }}
                                    </a>
                                    <a href="{{ route('register') }}" class="swal-btn swal-btn-register">
                                        {{ trans('main.register_site') }}
                                    </a>
                                    <a href="javascript:void(0);" class="swal-btn swal-btn-later">
                                        {{ trans('main.thanks_later') }}
                                    </a>
                                </div>
                            `,
                            showConfirmButton: false
                        });

                        document.addEventListener('click', function(e) {
                            if (e.target.classList.contains('swal-btn-later')) {
                                swal.close();
                            }
                        });


                        return;
                    }

                    if (data.status == 'added' || data.status == 'removed') {
                        swal({
                            type: data.type, // success, error, info...
                            title: data.title,
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }


                    // Update icon color
                    updateIcon(this, data.active);

                    // Update wishlist count
                    document.querySelector('.wishlist_count').textContent = data.wishlist_count;

                    // Save state for refresh
                    this.dataset.inWishlist = data.active ? '1' : '0';

                })
                .catch(error => console.log(error));
        });
    });

    document.querySelectorAll(".compaire").forEach(function(element) {
        element.addEventListener("click", function(e) {
            e.preventDefault(); // منع الرابط الافتراضي

            productSlug = this.dataset.slug;

            fetch(`{{ route('compare.toggle', ['product' => ':slug']) }}`.replace(':slug',
                    productSlug), {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": '{{ csrf_token() }}',
                        "Accept": "application/json"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'full') {

                        swal({
                            type: data.type, // success, error, info...
                            title: data.title,
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });

                        return;
                    }

                    if (data.status == 'added' || data.status == 'removed') {
                        swal({
                            type: data.type, // success, error, info...
                            title: data.title,
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }

                    // Update icon color
                    updateIcon(this, data.active);

                    // Update wishlist count
                    document.querySelector('.compare_count').textContent = data.compare_count;

                    // Save state for refresh
                    this.dataset.inCompare = data.active ? '1' : '0';
                })
                .catch(error => console.log(error));
        });
    })

    function updateIcon(el, active = false) {
        const rect = el.querySelector('svg rect');
        const paths = el.querySelectorAll('svg path');

        if (active) {
            // لون الخلفية
            rect.style.fill = '#8a4ba6';

            // لون الأيقونة
            paths.forEach(p => p.style.fill = 'white');
        } else {
            rect.style.fill = 'white';
            paths.forEach(p => p.style.fill = '#181818'); // يرجع غامق
        }
    }

    document.querySelectorAll('.compaire.cart-item').forEach(item => {
        const inCompare = item.dataset.inCompare === '1';
        updateIcon(item, inCompare);
    });

    document.querySelectorAll('.favourite.cart-item').forEach(item => {
        const inWishlist = item.dataset.inWishlist === '1';
        updateIcon(item, inWishlist);
    });

    // فتح الـ Modal وجلب البيانات
    function openProductModal(slug) {
        // إظهار الـ Modal
        const modal = new bootstrap.Modal(document.getElementById('productModal'));
        modal.show();

        // إظهار loader
        document.getElementById('modalContent').innerHTML =
            '<div class="text-center"><div class="spinner-border"></div></div>';

        // جلب البيانات من Controller
        fetch('/product/details/' + slug)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalContent').innerHTML = data.html;

                let priceBox = document.querySelector("#product-price");
                if (priceBox) {
                    let productId = priceBox.dataset.id;
                    fetchPrice(productId); // <<<<< الحل
                }
            })
            .catch(error => {
                document.getElementById('modalContent').innerHTML =
                    '<div class="alert alert-danger">حدث خطأ في تحميل البيانات</div>';
            });
    }

    // ===============================
    // فتح القائمة (size-section)
    // ===============================
    document.addEventListener("click", function(e) {
        let btn = e.target.closest(".size-section");
        if (!btn) return;

        let pdSize = btn.closest(".product-size");
        if (pdSize) {
            pdSize.classList.toggle("active");
        }
    });


    // ===============================
    // اختيار عنصر من .option
    // ===============================
    document.addEventListener("click", function(e) {
        let option = e.target.closest(".option");
        if (!option) return;

        let pdSize = option.closest(".product-size");
        if (!pdSize) return;

        // النص المعروض فوق
        let pdBtn_Text = pdSize.querySelector(".size-text");

        // جلب النص
        let selectedOption = option.querySelector(".option-text").innerText;
        pdBtn_Text.innerHTML = selectedOption;

        // إزالة السيلكت القديمة
        pdSize.querySelectorAll(".option").forEach(o => o.classList.remove("selected"));

        // إضافة الجديدة
        option.classList.add("selected");

        // إغلاق القائمة
        pdSize.classList.remove("active");

        // طلب تحديث السعر
        let priceBox = document.querySelector("#product-price");
        if (!priceBox) return;

        let productId = priceBox.dataset.id;
        fetchPrice(productId);
    });


    // ===============================
    // جلب القيم المختارة من الـ DOM
    // ===============================
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


    // ===============================
    // جلب السعر من السيرفر
    // ===============================
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
                        `<span class="price-cut">${data.original}</span>
                     <span class="new-price">${data.discounted}</span>`;

                    // ===== اظهار الخصم =====
                    if (discountBox && discountValue) {
                        discountValue.innerText = `- ${data.discount}%`;
                        discountBox.classList.remove("d-none");
                    }
                } else {
                    priceBox.innerHTML = `<span class="new-price">${data.original}</span>`;

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
                        btn.dataset.disabled = "1";
                        btn.style.pointerEvents = "none";
                        btn.style.opacity = "0.5";
                        btn.style.cursor = "not-allowed";
                    });

                } else {
                    availability.innerText = "{!! trans('main.in_stock') !!}";
                    availability.classList.remove("text-danger");

                    addToCartBtns.forEach(btn => {
                        btn.removeAttribute("disabled");
                        btn.classList.remove("disabled");
                        btn.dataset.disabled = "0";
                        btn.style.pointerEvents = "";
                        btn.style.opacity = "";
                        btn.style.cursor = "";

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

    // ===============================
    // زر "Add to Cart"
    // ===============================
    let isRequesting = false;

    $(document).off('click.addToCart')
        .on('click.addToCart', '.add_to_cart', function(e) {
            e.preventDefault();

            if (isRequesting) return;

            isRequesting = true;

            let product_id = $(this).data('product');
            let stock_id = $(this).data('stock');
            let quantity = parseInt($(this).closest('.product').find('.quantity .number').text());

            let selectedAttributes = {};

            // جمع كل الصفات المختارة
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
                                            <p class="new-price">$${item.price}</p>
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

                    $('.wrapper-subtotal .wrapper-title-sub').text(`$${response.cart.subtotal}`);


                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error("{!! trans('main.select_all_options') !!}");
                    } else {
                        toastr.error("{!! trans('main.something_went_wrong') !!}");
                    }
                },
                complete: function() {
                    isRequesting = false;
                    $('.add-to-cart-btn').prop('disabled', false).text('Add to Cart');
                }
            });
        });

    let modalSwiper = null;
    let modalThumbs = null;

    function initModalSwipers() {
        // تدمير أي instance موجودة
        if (modalSwiper) {
            modalSwiper.destroy(true, true);
            modalSwiper = null;
        }
        if (modalThumbs) {
            modalThumbs.destroy(true, true);
            modalThumbs = null;
        }

        // التأكد من وجود العناصر
        const thumbsElement = document.querySelector(".product-modal-bottom");
        const mainElement = document.querySelector(".product-modal-top");

        if (!thumbsElement || !mainElement) {
            console.error('Swiper elements not found');
            return;
        }

        // إنشاء Swiper جديد
        modalThumbs = new Swiper(".product-modal-bottom", {
            spaceBetween: 10,
            slidesPerView: 4,
            watchSlidesProgress: true,
            observer: true, // مهم: لمراقبة التغييرات في DOM
            observeParents: true,
        });

        modalSwiper = new Swiper(".product-modal-top", {
            loop: true,
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: modalThumbs,
            },
            observer: true, // مهم: لمراقبة التغييرات في DOM
            observeParents: true,
        });
    }

    let modalEl = document.getElementById('productModal');

    if (modalEl) {
        document.getElementById('productModal').addEventListener('shown.bs.modal', function() {
            setTimeout(() => {
                initModalSwipers();
            }, 100); // زود الوقت شوية لـ 100ms
        });

        document.getElementById('productModal').addEventListener('hidden.bs.modal', function() {
            if (modalSwiper) {
                modalSwiper.destroy(true, true);
                modalSwiper = null;
            }
            if (modalThumbs) {
                modalThumbs.destroy(true, true);
                modalThumbs = null;
            }
        });

    }

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
                            '<p class="text-center">Your cart is empty</p>'
                        );
                    }
                });

                $('.wrapper-subtotal .wrapper-title-sub').text(`$${res.subtotal}`);

                // تحديث العداد
                document.getElementById('cart-count').textContent = res.count;

                toastr.success(res.message);

            }
        });
    });

    $(document).on('click', '.remove-wishlist', function() {

        let btn = $(this);
        let productId = btn.data('product');
        let wrapper = btn.closest('tr'); // ✅ الصح

        $.ajax({
            url: '/wishlist/remove',
            type: 'DELETE',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {

                wrapper.fadeOut(300, function() {
                    $(this).remove();

                    // لو الجدول فاضي
                    if ($('tbody tr.ticket-row').length === 0) {
                        $('tbody').html(
                            '<tr><td colspan="3" class="text-center">Your wishlist is empty</td></tr>'
                        );
                    }
                });

                $('.wishlist_count').text(res.count);

                toastr.success(res.message);
            }
        });
    });

    $(document).on('click', '.remove-product', function() {

        let btn = $(this);
        let productId = btn.data('id');
        let td = btn.closest('td');
        let index = td.index();

        $.ajax({
            url: '/compare/remove',
            type: 'DELETE',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {

                // امسح العمود كله من كل الصفوف
                $('table tr').each(function() {
                    let cell = $(this).find('td').eq(index);

                    cell.slideUp(300, function() {
                        $(this).remove();
                    });
                });

                // استنى الأنيميشن تخلص
                setTimeout(() => {
                    if ($('tr.cart-top td.cart-center').length === 0) {
                        $('tbody').html(
                            '<tr><td colspan="3" class="text-center">Your compare is empty</td></tr>'
                        );
                    }
                }, 350);

                $('.compare_count').text(res.count);

                toastr.success(res.message);
            }
        });
    });
</script>
