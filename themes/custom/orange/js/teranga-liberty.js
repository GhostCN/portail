var swiper = new Swiper('.swiper-container-passL', {
    slidesPerView: 'auto',
    spaceBetween: 10
});

$(document).ready(function () {
    let avec = true;
    $(".select-orange").on("click", function(){
        if (avec){
            $(".select-orange .oval").animate({
                right: "5",
                left: ($( window ).width() > 768) ? "35" : "25"
            }, 500, function() {
                $(".select-orange").toggleClass("k-eng");
            });

            $(".eng").hide();
            $(".sans-eng").fadeIn();

            avec = !avec;
        }
        else{
            $(".select-orange .oval").animate({
                left: "5"
            }, 500, function() {
                $(".select-orange").toggleClass("k-eng");
            });
            $(".eng").hide();
            $(".avec-eng").fadeIn();

            avec = !avec;
        }
    });
})