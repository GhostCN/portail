"use strict";
        var mySwiper = new Swiper('.swiper-container-mobile', {
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
        });
function isNumber(event) {
  var keycode = event.keyCode;
  if(keycode >= 48 && keycode <= 57) {
    return true;
  }
  return false;
}

$(".mat-input").focus(function(){
    $(this).parent().addClass("is-active is-completed");
});

$(".mat-input").focusout(function(){
    if($(this).val() === "")
        $(this).parent().removeClass("is-completed");
    $(this).parent().removeClass("is-active");
});
