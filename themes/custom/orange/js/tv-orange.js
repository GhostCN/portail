$(document).ready(function(){

  $('.vod-tv').slick({
    infinite: false,
    slidesToShow: 6,
    slidesToScroll: 3
  });
                    
  $(window).on('load', function(){
      $(".slide-to").on("click", function(){
          actS($(this));
      });

      setInterval(function(){
          var index =  $('#carouselExampleIndicators .active').index();
          var slideT = $(".slide-to");

          actS($(slideT[index]));
      }, 1000);

      function actS(activeSlide){
          $(".slide-to").find(".desc-indicator").addClass("anactive");
          activeSlide.find(".desc-indicator").removeClass("anactive");
      }

      var $container = $('.gallery');
      $container.isotope({
          filter: '*',
          animationOptions: {
              duration: 750,
              easing: 'linear',
              queue: false
          }
      });

      $('.d-flex.galleryF div').click(function(){
          $('.galleryF .current').removeClass('current');
          $(this).addClass('current');

          var selector = $(this).attr('data-filter');
          $container.isotope({
              filter: selector,
              animationOptions: {
                  duration: 750,
                  easing: 'linear',
                  queue: false
              }
          });
          return false;
      });
      
      $('.swiper-container-bq .swiper-wrapper div').click(function(){
          $('.swiper-container-bq .swiper-wrapper .current').removeClass('current');
          $(this).addClass('current');

          var selector = $(this).attr('data-filter');
          $container.isotope({
              filter: selector,
              animationOptions: {
                  duration: 750,
                  easing: 'linear',
                  queue: false
              }
          });
          return false;
      });

        var swiper = new Swiper('.swiper-container-offre-fibre', {
              slidesPerView: 'auto',
              spaceBetween: 10,
          });
          var swiper = new Swiper('.swiper-container-vod', {
              slidesPerView: 'auto',
              spaceBetween: 10,
          });

          var swiper = new Swiper('.swiper-container-bq', {
              slidesPerView: 'auto',
              spaceBetween: 10,
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

          $(document).click(function(event) { 
              if(!$(event.target).closest('.vod-tv-img').length){
                  $('.vod-tv-img').find('.prop').hide();
              }
          });

      $('.vod-tv-img').on("click", function(){
          $('.vod-tv-img').find('.prop').hide();
          $(this).find('.prop').show();
      })
  })
});
