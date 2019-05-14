(function ($, Drupal) {

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
$(document).ready(function(){
    /*$("#icone-search").click(function(){
        $( ".search" ).slideToggle( "slow" );
    })*/

    $(".panier-header").hide();

  function responsivite () {
    if ( $( window ).width() <= 768) {
      $('#mega-level-1-collapse').css({
        'display': 'none'
      });
    } else {
      $('#mega-level-1-collapse').removeAttr('style');
    }
  }

  responsivite();
  $( window ).resize(function() {
    responsivite();
  });
  $('header').navbar({ sticky: false, hideSupra: true });
  // default init
  if( window.innerWidth < 768 ) {
    $('#collapsing-navbarHead').megamenu();
  }



// Surcharge des valeurs du script de la toolbar
accessibilitytoolbar_custom = {
  idLinkModeContainer: "id-li-for-cdu",
  cssLinkModeClassName: "nav-item-cdu"
};

var swiper = new Swiper('.swiper-container-footer', {
  slidesPerView: 'auto',
  spaceBetween: 0,
});



document.body.onload = function(){
  document.body.style.visibility = "visible";
};


// Surcharge des valeurs du script de la toolbar
accessibilitytoolbar_custom = {
  idLinkModeContainer: "id-li-for-cdu",
  cssLinkModeClassName: "nav-item-cdu"
};

var swiper = new Swiper('.swiper-container-footer', {
  slidesPerView: 'auto',
  spaceBetween: 0,
});

var  isOpen = false;
var  isOpen1 = false;

  $("#mega-menu-button").on("mouseover", function () {
    $("#mega-level-1-collapse").slideDown();
    $("#mega-level-1-collapse").attr("aria-expanded","true");

    $("#mega-menu-button").attr("aria-expanded", "true");
    $("#mega-menu-button").removeClass("collapsed");
  });

  $("#mega-menu-close").on("click", function () {
    $("#mega-level-1-collapse").slideUp();
    $("#mega-level-1-collapse").attr("aria-expanded","false");

    $("#mega-menu-button").attr("aria-expanded", "false");
    $("#mega-menu-button").addClass("collapsed");
  });

  $("#toggle-menu").on("click", function () {
    /*if($("#menu-extensible").hidden){
      $("#menu-extensible").show();
      $(".ext-rectangle").show();
      if($(this).find("img").attr("src") == "/sites/default/files/icones/commandes-black.svg"){
        $(this).find("img").attr("src", "/sites/default/files/icones/commandes-orange.svg");
      }else{
        $(this).find("img").attr("src", "/sites/default/files/icones/commandes-black.svg");
      }
    }*/
    /*if(isOpen){
      isOpen = false;
    } else {
      isOpen = true;
    }*/
  });

  $(".icone-search img").hover(function () {
    $(".search").show();
  })

  $(".icone-search").on("click", function () {
    if ($(".q").val() != "")
      $("#form-seach").submit();
  })

  $("header").hover(function () {
    $("#mega-level-1-collapse").slideUp();
  })

  $("#toggle-menu-image").on("mouseenter", function () {
    if(!isOpen){
      isOpen = true;
      $("#menu-extensible").show();
      $(".ext-rectangle").show();
      if($("#toggle-menu").find("img").attr("src") == "/sites/default/files/icones/commandes-black.svg"){
        $("#toggle-menu").find("img").attr("src", "/sites/default/files/icones/commandes-orange.svg");
      }else{
        $("#toggle-menu").find("img").attr("src", "/sites/default/files/icones/commandes-black.svg");
      }
    }
  });

  $("#menu-extensible").on("mouseleave", function () {
    //if(!isOpen){
      isOpen=false;
      $("#menu-extensible").hide();
      $(".ext-rectangle").hide();
      if($("#toggle-menu").find("img").attr("src") == "/sites/default/files/icones/commandes-black.svg"){
        $("#toggle-menu").find("img").attr("src", "/sites/default/files/icones/commandes-orange.svg");
      }else{
        $("#toggle-menu").find("img").attr("src", "/sites/default/files/icones/commandes-black.svg");
      }
    //}
  });

  $("#toggle-menu-mobile").on("click", function () {
    $("#menu-extensible").toggle();
    $(".ext-rectangle").toggle();
      if($(this).find("img").attr("src") == "/sites/default/files/icones/commandes-black.svg"){
          $(this).find("img").attr("src", "/sites/default/files/icones/commandes-orange.svg");
      }else{
          $(this).find("img").attr("src", "/sites/default/files/icones/commandes-black.svg");
      };
  });
  var swiper = new Swiper('.swiper-container-header-M', {
    slidesPerView: 'auto',
    spaceBetween: 10,
  });

  var sr = "";
  $(".ft-icone-hover").hover(function(){
    sr = $(this).find("img").attr('src')
    $(this).find("img").attr("src", "/sites/default/files/icones/" + $(this).data("hover"));
  }, function(){
    $(this).find("img").attr("src", sr);
  })

    $("#menu").on("click", function () {
      $(".scrollbar,.collapse.show").height($(window).innerHeight());
        $("#navbarToggleExternalContent").height($(window).innerHeight());

        if(!$("#navbarToggleExternalContent").hasClass("show")){
          $("body").css({"height: ": ""+$(window).innerHeight()+"", "overflow": "hidden"});

        }
        else{
            $("body").css({"height: ":"unset", "overflow": "unset"});
        }
    })

});
})(window.jQuery, window.Drupal);

