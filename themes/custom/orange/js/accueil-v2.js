$(".list-slider").slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,

  autoplay: true,
  autoplaySpeed: 2000,

  dots: true,
});

$(".list-ori").slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,

  autoplay: true,
  autoplaySpeed: 5000,

  //dots: true,
  fade: true,
  cssEase: 'linear'
});

var swiper = new Swiper('.swiper-container-fen-acc', {
  slidesPerView: 'auto',
  spaceBetween: 10
});

var swiper = new Swiper('.swiper-container-act', {
  slidesPerView: 'auto',
  spaceBetween: 10
});

var swiper = new Swiper('.swiper-container-flh', {
  slidesPerView: 'auto',
  spaceBetween: 10
});

$(document).ready(function(){
  $(".item-fenetre").hover(function () {
    let img = $(this).find(".desc-fen img");
    img.animate({
        marginRight: "-10",
    }, 500, function() {
        // Animation complete.
    });
}, function () {
    let img = $(this).find("img");
    img.animate({
        marginRight: "0",
    }, 500, function() {
        // Animation complete.
    });
});
})
