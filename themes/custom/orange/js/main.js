(function ($, Drupal) {

  // It's best practice to use strict mode, can help avoid some browser issues.
  'use strict';
  $(document).ready(function(){

  if( /Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    $('.desktop_menu').css('display', 'none');
  }
  else {
    $('.mobile_menu').css('display' ,'none');
  }

  $('.menu_mobile').click(function (el) {
    el.stopPropagation();
    var id = $(this).attr('id');
    if($('div.'+id).hasClass('show')) {
      $('div.' + id).removeClass('show');
    }
    else {
      $('div.' + id).addClass('show');
    }

  });
  $(window).scroll(function() {
    var height = $(window).scrollTop();
    if (height > 500) {
      $('#scrollToTop').fadeIn  ();
    }
    else {
      $('#scrollToTop').fadeOut();
    }
  });

  $("#scrollToTop").on("click", function(){
        $('html, body').animate({scrollTop:0}, 'slow');
    });


    $("#internet-4g").hover(function(){
      $(this).find("img").attr("src", "assets/images/internet-4-g-orange.svg")
    }, function(){
      $(this).find("img").attr("src", "assets/images/internet-4-g-black.svg")
    });

    $("#image-sim").hover(function(){
      $(this).find("img").attr("src", "assets/images/offres-services-orange.svg")
    }, function(){
      $(this).find("img").attr("src", "assets/images/offres-services-black.svg")
    });

    $("#services").hover(function(){
      $(this).find("img").attr("src", "assets/images/services-orange.svg")
    }, function(){
      $(this).find("img").attr("src", "assets/images/services-black.svg")
    });

    $("#autes-questions").hover(function(){
      $(this).find("img").attr("src", "assets/images/autres-questions-orange.svg")
    }, function(){
      $(this).find("img").attr("src", "assets/images/autres-questions-black.svg")
    });
    $(".lien-direct").hover(function(){
      $(this).find(".icone-lien-direct").attr("src", "/sites/default/files/images/keyboard-arrow-up-orange.svg");
    }, function(){
      $(this).find(".icone-lien-direct").attr("src", "/sites/default/files/images/keyboard-arrow-up.svg");
    });



      var swiper = new Swiper('.swiper-container', {
          pagination: {
              el: '.swiper-pagination',
              clickable: true,
          },
          autoplay: {
              delay: 2500,
              disableOnInteraction: false,
          },
      });


var swiper = new Swiper('.swiper-container-detail', {
  slidesPerView: 'auto',
  spaceBetween: 10
});

var swiper = new Swiper('.swiper-container-offre', {
    slidesPerView: 'auto',
      spaceBetween: 10,
});

setTimeout(function () {
    $("#menu-extensible").hide();
    $(".ext-rectangle").hide();

}, 5)

var swiper = new Swiper('.swiper-container-index', {
  slidesPerView: 'auto',
    spaceBetween: 10,
});

  var swiper = new Swiper('.swiper-container-new-plan', {
    slidesPerView: 'auto',
    spaceBetween: 10,
  });

var swiper = new Swiper('.swiper-container-tv', {
    slidesPerView: 'auto',
      spaceBetween: 30,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      }
});


// Surcharge des valeurs du script de la toolbar


var swiper = new Swiper('.swiper-container-footer', {
  slidesPerView: 'auto',
  spaceBetween: 0,
});

var swiper = new Swiper('.swiper-container-hub-actu', {
    slidesPerView: 'auto',
    spaceBetween: 10,
});



function responsivite () {
  if ( $( window ).width() <= 768) {
    $('#mega-level-1-collapse').css({
      'display': 'none'
    });
  } else {
    $('#mega-level-1-collapse').removeAttr('style');
  }

  if ( $( window ).width() < 768) {
    $('.element_menu').css({
      'display': 'none'
    });
    $('.nav_mobile').css({
      'display': 'block'
    });

  } else {
    $('.element_menu').css({
      'display': 'block'
    });
    $('.nav_mobile').css({
      'display': 'none'
    });
  }
}

//$(document).ready(function () {
  responsivite();
  $( window ).resize(function() {
    responsivite();
  });

  $("#menu").on('click', function(e){
    e.preventDefault();
    if ($(this).find("img").attr("src").endsWith("icones/bars.svg")  ) {
      $(this).find("img").attr("src", "/sites/default/files/icones/close-orange.svg");
    } else {
      $(this).find("img").attr("src", "/sites/default/files/icones/bars.svg");

    }
    // $(this).replace("../assets/icones/close-orange.svg","../assets/icones/bars.svg");
  });

    $("#element_menu .sg-link-nav a").each(function() {
      if (this.href == window.location.href) {
        $("#element_menu .sg-link-nav a").removeClass("active");
        $(this).addClass("active");
      }
    });

});

})(window.jQuery, window.Drupal);
