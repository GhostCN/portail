$(function () {
    $('.btn-txte').click(function (e) {
        e.preventDefault();
        $btn = $(this);
        $page = $btn.data('next');
        if($page !== '0'){
            $('.tuto').fadeOut('fast');
            $('.page-'+$page+'').delay(500).fadeIn('slow');
        }
        if($page === 'n'){
            $('.divivre').fadeOut('fast');
            //window.wirewax.triggerEvent(window.wirewax.events.triggers.PLAY);
        }
    });
    var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
    if(iOS){
        $('.overlay').fadeIn();
    }

    $('.exist').click(function () {
        $('.overlay').fadeOut();
    });
});