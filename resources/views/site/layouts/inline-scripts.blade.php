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
                                <h5>الرجاء تسجيل الدخول أو الإنضمام للموقع</h5>
                                <div class="swal-custom-buttons">
                                    <a href="{{ route('login') }}" class="swal-btn swal-btn-login">دخول الموقع</a>
                                    <a href="{{ route('register') }}" class="swal-btn swal-btn-register">الإنضمام للموقع</a>
                                    <a href="javascript:void(0);" class="swal-btn swal-btn-later">شكراً ... ربما لاحقاً</a>
                                </div>
                            `,
                            showConfirmButton: false,
                        })

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
                    availability.innerText = "Out of stock";
                    availability.classList.add("text-danger");

                    addToCartBtns.forEach(btn => {
                        btn.classList.add("disabled");
                        btn.setAttribute("disabled", true);
                        btn.removeAttribute("data-stock");
                    });

                } else {
                    availability.innerText = "In Stock";
                    availability.classList.remove("text-danger");

                    addToCartBtns.forEach(btn => {
                        btn.classList.remove("disabled");
                        btn.removeAttribute("disabled");
                        btn.setAttribute("data-stock", data.stock_id);
                    });
                }

            });
    }



    // ===============================
    // زر "Add to Cart"
    // ===============================
    $(document).on('click', '.add_to_cart', function(e) {
        e.preventDefault();

        let product_id = $(this).data('product');
        let stock_id = $(this).data('stock');
        let quantity = 1;

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
</script>
