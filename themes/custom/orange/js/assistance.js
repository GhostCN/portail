function h() {
    let date = new Date();
    let heure = date.getHours();

    if ((heure > 19 && heure < 7)){
        $(".bandeau-desk").addClass("nuit");
        $(".bandeau-desk .ibou").attr("src", "/sites/default/files/images/assistance/group-22-night.svg")
    }
    else{
        $(".bandeau-desk").removeClass("nuit");
    }
}

h();

var swiper = new Swiper('.swiper-container-ass-ho', {
    slidesPerView: 'auto',
    spaceBetween: 10
});

$(document).ready(function () {
    let inp = $(".input-search")
    inp.on("input", function () {
        let val = $(this).val();
        if (val.length > 3){
            $(".block-res").show();
            if ( $( window ).width() > 768){
                $('html, body').animate({scrollTop:400}, 'slow');
            }
            else
                $('html, body').animate({scrollTop:200}, 'slow');

            $(".img-rech").attr("src", "/sites/default/files/images/assistance/close-black.svg");
        }
        else{
            $(".img-rech").attr("src", "/sites/default/files/images/assistance/rechercher-black.svg");
            $(".block-res").hide();
        }

        // couleur du mot concerné par la recherche

        $.each($(".listfaq .item-faq"), function () {
            wordIn($(this).find("div"));
        })

    });

    if ( $( window ).width() < 768)
        inp.focus(function () {
            $('html, body').animate({scrollTop:200}, 'slow');
        });

    $(document).click(function(event) {
        if(!$(event.target).closest('.block-res').length && !$(event.target).closest('.input-search').length){
            $('.block-res').hide();
            $(".img-rech").attr("src", "/sites/default/files/images/assistance/rechercher-black.svg");
        }
    });

    $(".lnk-offr .links").hover(function () {
        let img = $(this).find("img");
        img.animate({
            marginRight: "-10",
        }, 500, function() {
            // Animation complete.
        });
    }, function () {
        let img = $(this).find("img");
        img.animate({
            marginRight: "0",
        }, 500, function() {
            // Animation complete.
        });
    });

    $(".list-contrib-mobil").slick({
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1
    });


    // couleur du mot concerné par la recherche

    function wordIn(div) {
        let contents = div.text().split(" ");

        let modText = '';

        let valInp  = $(".input-search").val().toLocaleLowerCase();
        valInp = valInp.split(' ')

        for (let i = 0; i < contents.length; i++) {
            if (valInp.includes(contents[i].toLocaleLowerCase()))
                modText += '<span class="color-orange">' + contents[i] + '</span> ';
            else
                modText += '<span>' + contents[i] + '</span> ';
        }

        div.html(modText);


    }
})