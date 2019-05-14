/*
$(document).ready(function(){
  $("#menu").on('click', function(e){
    e.preventDefault();
    console.log($(this).find("img").attr("src"));
    if ($(this).find("img").attr("src").endsWith("icones/bars.svg")  ) {
      $(this).find("img").attr("src", "/sites/default/files/icones/close-orange.svg");
    } else {
      $(this).find("img").attr("src", "/sites/default/files/icones/bars.svg");

    }
    // $(this).replace("../assets/icones/close-orange.svg","../assets/icones/bars.svg");
  });
});
*/

/* $(document).ready(function(){
    $("#menu").on('click', function(e){
        e.preventDefault();
        if ($(this).find("img").attr("src") == "../assets/icones/bars.svg" ) {
            var height = screen.height - 60;
            console.log(height + ' ' + screen.height + ' ' + $('#mega-menu-mobile').height());
            $('#footer-menu-mobile').css({
                width: '100%',
                position: 'relative',
                top: height, right: 0,
                'z-index': 3
            });
            $(this).find("img").attr("src", "../assets/icones/close-orange.svg");
        } else {
            $('#mega-menu-mobile').height('auto');
            $(this).find("img").attr("src", "../assets/icones/bars.svg");

        }
        // $(this).replace("../assets/icones/close-orange.svg","../assets/icones/bars.svg");
    });

    $("#menu").on('dblclick', function(e){
        e.preventDefault();
    });

}); */