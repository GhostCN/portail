$(".swiper-container-cadeau").each(function () {
    var swiper = new Swiper($(this), {
        slidesPerView: 'auto',
        spaceBetween: 10
    });
});

$(document).ready(function() {
    $('.carousel').carousel({
        interval: false
    })

    $('.cadeaux-filtre').each( function(i){
        $('#' + $(this).data("filtre")).slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 3
        });
    });

    function fadeInto(){
        $('.listckw').each( function(i){

            let bottom_of_object = $(this).position().top + $(this).outerHeight();
            let bottom_of_window = $(window).scrollTop() + $(window).height();

            /* If the object is completely visible in the window, fade it it */
            if( bottom_of_window > bottom_of_object ){

                $(this).animate({'opacity':'1'},2000);

            }

        });
    }

    function isScrolledTo(elem) {
        let bottom_of_object = $("#" + elem).position().top + $("#" + elem).outerHeight();
        let bottom_of_window = $(window).scrollTop() + $(window).height() + 300;

        if( bottom_of_window > bottom_of_object ){
            return true;
        }
        return false
    }

    fadeInto();

    /* Every time the window is scrolled ... */
    $(window).scroll( function(){

        fadeInto();
        $(".item-list").each(function () {
            if ($(this).data("link")){
                if(isScrolledTo($(this).data("link"))){
                    $(".item-list").removeClass("active");
                    $(this).addClass("active");
                }
            }
        })

    });

    $(".filter-mobile").on("click", function () {
        $(".filter-option").toggle();
    });

    $(".filter-option div").on("click", function () {
        $(".filter-option").fadeOut();

        $(".filter-mobile-active div").text($(this).text());

        $(".mob").hide();
        $("#" + $(this).data("filter")).fadeIn();
    })


    function hideFiltre(id){
        $(".list-cadeau-items").find(".slick-arrow").hide();
        $("#" + id).find(".slick-arrow").show();
    }

    hideFiltre($(".list-cadeau-items").attr("id"))
    
   // $(".filtre-dest").hide();

    $(".cadeaux-filtre").on("click", function () {

        $(".cadeaux-filtre").removeClass("active");
        $(".cadeaux-filtre").find("img").attr("src", "/sites/default/files/images/sargal/group-14-copy-12.svg");
        $(this).addClass("active");
        $(this).find("img").attr("src", "/sites/default/files/images/sargal/group-14-copy-6.svg");

        $(".list-cadeau-items").removeClass("active");
        $("#" + $(this).data("filtre")).addClass("active");

        hideFiltre($(this).data("filtre"));

    });

    $(".item-list").click(function() {
        let tp = $("#" + $(this).data("link")).offset().top;
        let $this = $(this)
        tp -= 60;

        $('html, body').animate({
            scrollTop: tp
        }, 2000, function () {
                $(".item-list").removeClass("active");
                $this.addClass("active");
            }
        );
    });

    setTimeout(function () {
        $(".kdo-mobile").hide();
    }, 100);
})

