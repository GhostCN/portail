$(document).ready(function() {

  $(".form-selc-in").hide();

  $("#hide").click(function() {
    $(".cde").hide();
    $(".form-selc-in").show();

  });

  $(".form-selc-ine").hide();

  $("#hidee").click(function() {
    $(".cde").hide();
    $(".form-selc-in").show();

  });

  $(".form-selc-ine").hide();

  $("#hideee").click(function() {
    $(".cdee").hide();
    $(".form-selc-ine").show();

  });


  //Initialize tooltips
    //$('.nav-tabs > li a[title]').tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {

        var $target = $(e.target);

        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    /*$(".next-step").click(function(e) {
        var $active = $('.nav-tabs li>a.active'),
            $aActive = $('.nav-tabs li>a.encours');
        $active.parent().next().removeClass('disabled');

        $aActive.parent().find('.cercle-numb').addClass('cercle-numb-prec');
        $aActive.parent().find('.text-numb').addClass('text-numb-prec ');
        $aActive.parent().find('.nav-link-pr').addClass('a-prec');

        $aActive.removeClass('encours');
        $aActive.parent().next().find('a.nav-link').addClass('encours');
        if ($('.encours').data('lestep') == 'step2') {
            $('#sectionTab2').removeClass('pas-intt');
        } else {
            $('#sectionTab2').addClass('pas-intt');
        }

        $active.parent().next().find('.cercle-numb').addClass('active');
        $active.parent().next().find('.text-numb').addClass('active');


        nextTab($active);

    });*/

    $(".prev-step").click(function(e) {
        var $active = $('.nav-tabs li>a.active');
        prevTab($active);

    });
    $(".efface").click(function(e) {
        var $block = $('.pas-interesse-block');
        $block.parent().next().find('.pas-intt').removeClass('pas-intt');
        nextTab($block);

    });

  $(".mat-input").focus(function() {
    $(this).parent().addClass("is-active is-completed");
  });

  $(".mat-input").focusout(function() {
    if ($(this).val() === "")
      $(this).parent().removeClass("is-completed");
    $(this).parent().removeClass("is-active");
  });
});


function nextTab(elem) {
    $(elem).parent().next().find('a[data-toggle="tab"]').click();



    // $(".cercle-numb").addClass('active');
}

function prevTab(elem) {
    $(elem).parent().prev().find('a[data-toggle="tab"]').click();
}

var mySwiper = new Swiper('.swiper-container', {
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
