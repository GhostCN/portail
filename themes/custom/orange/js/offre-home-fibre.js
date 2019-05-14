$("#testUp").hide();

$(document).ready(function() {
    $(".btn-test").on("click", function() {
        $(".form-test-fibre").slideToggle("slow");
        $(".btn-test").toggle();
    });

    $(".mat-input").focus(function() {
        $(this).parent().addClass("is-active is-completed");
    });

    $(".mat-input").focusout(function() {
        if ($(this).val() === "")
            $(this).parent().removeClass("is-completed");
        $(this).parent().removeClass("is-active");
    })
});

var swiper = new Swiper('.swiper-container-offre-fibre', {
    slidesPerView: 'auto',
    spaceBetween: 10,
});

var swiper = new Swiper('.swiper-container-offre-fibre-op', {
    slidesPerView: 'auto',
    spaceBetween: 30,
});