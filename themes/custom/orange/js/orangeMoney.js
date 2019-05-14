 $(document).ready(function(){

    $(".mat-input").focus(function(){
        $(this).parent().addClass("is-active is-completed");
    });

    $(".mat-input").focusout(function(){
        if($(this).val() === "")
            $(this).parent().removeClass("is-completed");
        $(this).parent().removeClass("is-active");
    });

    $(".link-page div").click(function() {
        $("#fixeOnscrool").addClass("fixed-top")
        $('html, body').animate({
            scrollTop: $("#" + $(this).data("link")).offset().top
        }, 2000);
        $(".link-page div").removeClass("active");
        $(this).addClass("active");
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


    });

   if ( $( window ).width() > 768) {
     function isScrolledIntoView(elem) {
       var $elem = $(elem);
       var $window = $(window);

       var docViewTop = $window.scrollTop();
       var docViewBottom = docViewTop + $window.height();

       var elemTop = $elem.offset().top;
       var elemBottom = elemTop + $elem.height();

       return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
     }

     $(window).scroll(function () {
       if (!isScrolledIntoView($("#fixeOnscrool"))) {
         $("#fixeOnscrool").addClass("fixed-top");
         $("#linkPageImg").show();
       }

       if (isScrolledIntoView($("#bg-title"))) {
         $("#fixeOnscrool").removeClass("fixed-top");
         $("#linkPageImg").hide();
       }

     });
   }
 });

 var swiper = new Swiper('.swiper-container-kwom', {
     slidesPerView: 'auto',
     spaceBetween: 10,
 });

 var swiper = new Swiper('.swiper-container-calc', {
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
