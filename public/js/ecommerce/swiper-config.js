// Main menu
var swiper = new Swiper(".SlideMain", {
    grabCursor: true,
    pagination: {
        el: ".SlideMain .swiper-pagination",
        clickable: true,
    },
    mousewheel: true,
    keyboard: true,
    autoplay: {
        delay: 5000,
    },
});

// Brand row
var swiper = new Swiper(".BrandLatest", {
    slidesPerView: 5,
    spaceBetween: 0,
    grabCursor: true,
    autoplay: {
        delay: 3000,
    },
    navigation: {
        nextEl: ".brand-row-header__btn--prev",
        prevEl: ".brand-row-header__btn--next",
    },
    breakpoints: {
        "@0.00": {
            slidesPerView: 1,
            spaceBetween: 0,
        },
        "@0.65": {
            slidesPerView: 2,
            spaceBetween: 0,
        },
        "@1.00": {
            slidesPerView: 3,
            spaceBetween: 0,
        },
        "@1.65": {
            slidesPerView: 4,
            spaceBetween: 0,
        },
        "@2.00": {
            slidesPerView: 5,
            spaceBetween: 0,
        },
    }
});

// Product row
var swiper = new Swiper(".ProductLatest", {
    slidesPerView: 5,
    spaceBetween: 5,
    grabCursor: true,
    navigation: {
        nextEl: ".ProductHeaderNavBtn_Prev",
        prevEl: ".ProductHeaderNavBtn_Next",
    },
    breakpoints: {
        "@0.00": {
            slidesPerView: 1,
            spaceBetween: 5,
        },
        "@0.65": {
            slidesPerView: 2,
            spaceBetween: 5,
        },
        "@1.00": {
            slidesPerView: 3,
            spaceBetween: 5,
        },
        "@1.65": {
            slidesPerView: 4,
            spaceBetween: 5,
        },
        "@2.00": {
            slidesPerView: 5,
            spaceBetween: 5,
        },
    }
});

// Post row
var swiper = new Swiper(".post__latest", {
    slidesPerView: 5,
    spaceBetween: 5,
    grabCursor: true,
    navigation: {
        nextEl: ".PostHeaderNavBtn_Prev",
        prevEl: ".PostHeaderNavBtn_Next",
    },
    breakpoints: {
        "@0.00": {
            slidesPerView: 1
        },
        "@0.65": {
            slidesPerView: 2,
            // spaceBetween: 20,
        },
        "@1.00": {
            slidesPerView: 3,
            // spaceBetween: 25,
        },
        "@1.65": {
            slidesPerView: 4,
            // spaceBetween: 25,
        },
        "@2.00": {
            slidesPerView: 5,
            // spaceBetween: 30,
        },
    }
});

// Detail
var swiper = new Swiper(".product__detail .product-detail-left__thumbslide", {
    spaceBetween: 5,
    slidesPerView: 5,
    freeMode: true,
    watchSlidesProgress: true,
});

var swiper2 = new Swiper(".product__detail .product-detail-left__featuredslide", {
    spaceBetween: 5,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    thumbs: {
        swiper: swiper,
    },
});