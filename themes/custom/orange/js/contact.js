$(document).ready(function(){
    $(".list-answer .answer").on("click", function () {
        $(".list-answer .answer").removeClass("active");
        $(".list-answer .answer").find("img").attr("src", "/sites/default/files/images/contact/keyboard-arrow-up.svg");
        $(this).addClass("active");
        $(this).find("img").attr("src", "/sites/default/files/images/contact/keyboard-arrow-up-orange.svg");

        $(".div-loading").show();
        $(".messages").hide();
        $(".thd-lst").hide();

        scrollBAs();

        setTimeout(function () {
            $(".div-loading").hide();
            $(".messages").show();

            scrollBAs();

        }, 1000);

        
    })
    
    $(".scn-list-answer .scn-answer").on("click", function () {
        $(".scn-list-answer .scn-answer").removeClass("active");
        $(".scn-list-answer .scn-answer").find("img").attr("src", "/sites/default/files/images/contact/keyboard-arrow-up.svg");

        $(this).addClass("active");
        $(this).find("img").attr("src", "/sites/default/files/images/contact/keyboard-arrow-up-orange.svg");

        $(".scn-messages").show();

        $(".scn-messages .div-loading").show();
        $(".thd-lst").hide();

        scrollBAs()

        setTimeout(function () {
            $(".div-loading").hide();
            $(".thd-lst").show();

            scrollBAs();

        }, 1000);

    })

    
});

function scrollBAs(){
    var chat = document.getElementById("chat-content");
    chat.scrollTop = chat.scrollHeight;
 };
