$("#testUp").hide();

$(document).ready(function() {
  $(".mat-input").focus(function () {
    $(this).parent().addClass("is-active is-completed");
  });

  $(".mat-input").focusout(function () {
    if ($(this).val() === "")
      $(this).parent().removeClass("is-completed");
    $(this).parent().removeClass("is-active");
  });

  var swiper = new Swiper('.swiper-container-offre-internet', {
    slidesPerView: 'auto',
    spaceBetween: 10,
  });

  var swiper = new Swiper('.swiper-container-tv', {
    slidesPerView: 'auto',
    spaceBetween: 10,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    }
  });

  $("#testDow").on("click", function () {
    $(".test-card-body-internet").slideDown("slow");
    $(".test-b").toggle();
  });

  $("#testUp").on("click", function () {
    $(".test-card-body-internet").slideUp("slow");
    $(".test-b").toggle();
  })
});
