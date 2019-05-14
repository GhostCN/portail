(function ($, Drupal) {
"use strict";
$(document).ready(function () {
  $('.abonnement').click(function () {
    $('div#resultat').hide();
    $('div#contenu').show();
    $('#sabonner').click(function () {
    var data = {};
      $.each($('form').serializeArray(), function() {
        data[this.name] = this.value.trim();
      });
      if (isNaN(data.tel) || !['S','M'].includes(data.duree) || !['AMOUR','KARELLE','MAKEUP','FEMME','NUTRIFIT','COACHING'].includes(data.service)) {
      return false;
    }
    else {
      $.ajax({
        type: 'POST',
        url: '/services-portail-magik/subcription',
        data: data,
        success: function (response) {
          var message = 'Service indisponible!';
          if(response.message) {
            message = response.message;
          }

          $('div#resultat').show().html('<div style="text-align: center"><b>'+message+'</b></div>');
        },
        beforeSend: function () {
          $('div#contenu').hide();
          $('div#resultat').show().html('<div style="text-align: center"><p>Merci de patienter ...</p><img src="/sites/default/files/images/loader.gif" width="50px" /></div> ');
        }
      });
      /*$.post(
        '/services-portail-magik/subcription',
        data,
        function () {
        },
        'json').done(function (response) {
          var message = response.message;
          $('div#resultat').show().html('<b>'+message+'</b>');
          $('div#contenu').hide();
      }).fail(function (error) {
        
      });*/
    }
  });

  });
});

})(window.jQuery, window.Drupal);
