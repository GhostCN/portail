$('.firmware').click(function (e) {
  e.preventDefault();
  $('.pop-over').show();
});
$('.slider-nav').slick({
  slidesToShow: 2,
  slidesToScroll: 1,
  dots: false,
  centerMode: true,
  focusOnSelect: true,
  arrows: false
});
