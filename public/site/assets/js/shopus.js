AOS.init();
let submenu = document.getElementById("subMenu");
let empt = document.querySelector(".empty");
function tooglmenu() {
    submenu.classList.toggle("open-dropdown");
    empt.classList.toggle("active");
}
function heightanimation(ele) {
    const els = document.querySelectorAll(`#${ele}`);
    els.forEach((item) => {
        const height = item.scrollHeight;
        item.style.setProperty("--max-height", `${height}px`);
    });
}
heightanimation("subMenu");
var swiper = new Swiper(".hero-swiper", {
    spaceBetween: 30,
    centeredSlides: true,
    effect: "fade",
    autoplay: { delay: 2500 },
    pagination: { el: ".swiper-pagination", clickable: true },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
var swiper = new Swiper(".about-swiper", {
    spaceBetween: 30,
    slidesPerView: 3,
    roundLengths: true,
    loopAdditionalSlides: 30,
    pagination: { el: ".swiper-pagination", clickable: true },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        320: { slidesPerView: 1 },
        640: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 2, spaceBetween: 30 },
        1260: { slidesPerView: 3 },
    },
});
var swiper = new Swiper(".product-bottom", {
    loop: true,
    spaceBetween: 10,
    slidesPerView: 4,
});
var swiper2 = new Swiper(".product-top", {
    loop: true,
    spaceBetween: 10,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: { swiper: swiper },
});

function switchDashboard() {
    const toggleBtn = document.querySelector(".switch-icon");
    toggleBtn.classList.toggle("active");
}
function modalAction(elemnt) {
    const moalMain = document.querySelector(elemnt);
    if (moalMain.classList.contains("active")) {
        moalMain.classList.remove("active");
    } else {
        moalMain.classList.add("active");
    }
}
let uploadImg = document.querySelector("#upload-img");
let inputFile = document.querySelector("#input-file");
if (inputFile) {
    inputFile.onchange = function () {
        uploadImg.src = URL.createObjectURL(inputFile.files[0]);
    };
}
let coverImg = document.querySelector("#cover-img");
let coverFile = document.querySelector("#cover-file");
if (coverFile) {
    coverFile.onchange = function () {
        coverImg.src = URL.createObjectURL(coverFile.files[0]);
    };
}
