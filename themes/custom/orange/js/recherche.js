(function ($, Drupal) {
  "use strict";
var swiper = new Swiper('.swiper-container-recherche', {
  slidesPerView: 'auto',
  spaceBetween: 10
});

var swiper = new Swiper('.swiper-container-associated', {
  slidesPerView: 'auto',
  spaceBetween: 10
});

$('.carousel').carousel({
  interval: false
})


$(document).ready(function() {
    $(".mat-input").focus(function () {
      $(this).parent().addClass("is-active is-completed");
    });
  
    $(".mat-input").focusout(function () {
      if ($(this).val() === "")
        $(this).parent().removeClass("is-completed");
      $(this).parent().removeClass("is-active");
    });

    $('.carousel').on('slide.bs.carousel', function () {
      // alert(12)
    })

    $(".toggle-tab").on("click", function(){
      $(".items-tab").hide();
      $("#"+ $(this).data("toggle") +"").fadeIn();
    });

  $('#search').click(function () {
    $('form').submit();
  });

  $(".list-results").each(function(){
    let res = $(this).find(".result");
    if(res.length > 10){
      $(this).find(".show-more").show();
    }
  });

  $(".show-more").on("click", function(){
    let parent = $(this).parent();

    parent.data("shown", parent.data("shown") + 10);
    parent.find(".result").show();
    parent.find(".result:nth-of-type(n+ "+ parent.data("shown") +")").hide();

    if(parent.find(".result").length <= parent.data("shown")){
      $(this).hide();
    }
  })
});
})(window.jQuery, window.Drupal);
