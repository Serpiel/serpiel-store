document.addEventListener("DOMContentLoaded", function () {
    new Swiper(".swiper-container", {
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        slidesPerView: 1,
        spaceBetween: 0,
        effect: "slide",
    });
});