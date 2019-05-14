        var mySwiper = new Swiper('.swiper-container-main', {
            // enable accessibility
            a11y: true,
            keyboard: {
                enabled: true,
                onlyInViewport: false
            },

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
                clickable: true
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            spaceBetween: 10,
            slidesPerView: 'auto',
            centeredSlides: false,
            freeMode: false,

            breakpoints: {
                767: {
                    // If we need pagination
                    pagination: {
                        clickable: false
                    },
                    freeMode: true, // disable for centered mode
                    freeModeMomentumRatio: .5,
                    centeredSlides: false, // enable for centered mode
                    slideToClickedSlide: false // enable for centered mode
                }
            }
        })
        
$(document).ready(function () {
    $('.list-pays').select2();

    $(".list-pays").on("change", function () {
        window.location.replace($(this).val());
        console.log($(this).val());
    })
})