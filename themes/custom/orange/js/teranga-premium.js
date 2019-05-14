$(document).ready(function () {

    $(".lnk-offr .links").hover(function () {
        let img = $(this).find("img");
        img.animate({
            marginRight: "-10",
        }, 500, function() {
            // Animation complete.
        });
    });

    let tel = true;

    $(".select-orange.tel").on("click", function () {
        let oval = $(this).find(".oval");

        if (!tel){
            oval.animate({
                left: "5",
            }, 500, function() {
                $(".filtreTel").toggleClass("color-orange");

                $(".fl-pre").hide();

                $("#avec-tel").fadeIn();
            });
        }

        else {
            oval.animate({
                right: "5",
                left: "35"
            }, 500, function() {
                $(".filtreTel").toggleClass("color-orange");
                $(".fl-pre").hide();

                $("#sans-tel").fadeIn();
            });
        }

        tel = !tel;

    })

    $(".filtreTel").on("click", function(){
        let $this = $(this);
        if ($this.data("filter")){
            $(".select-orange.tel .oval").animate({
                left: "5",
            }, 500, function() {
                $(".filtreTel").removeClass("color-orange");
                $this.addClass("color-orange");

                $(".fl-pre").hide();

                $("#avec-tel").fadeIn();
                tel = true;
            });
        }
        else {
            $(".select-orange.tel .oval").animate({
                right: "5",
                left: "35"
            }, 500, function() {
                $(".filtreTel").removeClass("color-orange");
                $this.addClass("color-orange");

                $(".fl-pre").hide();

                $("#sans-tel").fadeIn();

                tel = false;
            });
        }
    })

    $(".close").on("click", function(){
        
        $(".premium").removeClass("detailed");
        $(".list-premium").removeClass("detail");
    })

    if ( $( window ).width() > 768) {

        $(".desc-pre").on("click", function(){
            $(".premium").removeClass("detailed");
            $(".list-premium").removeClass("detail");

            $(this).parent().addClass("detailed");
            $(this).parent().parent().addClass("detail");

            let det = $(this).parent();
            $(this).parent().parent().prepend(det);


            let top = $(this).parent().offset().top;

            $('html, body').animate({
                scrollTop: top -30
            }, 500 );
        })

    }
    else{
        $(".desc-pre").on("click", function(){
            $(this).parent().find(".md-effect-1").addClass("md-show");
            $("body").css("overflow", "hidden");
        });
    
        $(".md-close").on("click", function(){
            $(".md-effect-1").removeClass("md-show");
            $("body").css("overflow", "unset");
        })
    }

    $(".ch-mobile").on("click", function(){
        $(this).find(".drop-dow").toggle();
    })

    $(".dtel").on("click", function(){

        let act = $(this).parent().find(".act").text();

        let otr = $(this).text();

        $(this).parent().find(".act span").text(otr);
        $(this).text(act)
        $(".fl-pre").fadeToggle();
    })

    // filtre mois

    let durre = true;

    $(".select-orange.durr").on("click", function () {
        let oval = $(this).find(".oval");

        if (!durre){
            oval.animate({
                left: "5",
            }, 500, function() {
                $(".filtreDurr").toggleClass("color-orange");

                $(".fl-duree").hide();

                $(".f24").fadeIn();
            });
        }

        else {
            oval.animate({
                right: "5",
                left: "35"
            }, 500, function() {
                $(".filtreDurr").toggleClass("color-orange");
                $(".fl-duree").hide();

                $(".f12").fadeIn();
            });
        }

        durre = !durre;

    })

    $(".filtreDurr").on("click", function(){
        let $this = $(this);
        if ($this.data("filter")){
            $(".select-orange.durr .oval").animate({
                left: "5",
            }, 500, function() {
                $(".filtreDurr").removeClass("color-orange");
                $this.addClass("color-orange");

                $(".fl-duree").hide();

                $(".f24").fadeIn();
                durre = true;
            });
        }
        else {
            $(".select-orange.durr .oval").animate({
                right: "5",
                left: "35"
            }, 500, function() {
                $(".filtreDurr").removeClass("color-orange");
                $this.addClass("color-orange");

                $(".fl-duree").hide();

                $(".f12").fadeIn();

                durre = false;
            });
        }
    });

    $(".dmois").on("click", function(){

        let act = $(this).parent().find(".act").text();

        let otr = $(this).text();

        $(this).parent().find(".act span").text(otr);
        $(this).text(act)
        $(".fl-duree").fadeToggle();
    })
})