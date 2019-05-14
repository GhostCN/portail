$(document).ready(function (){
  $('footer').remove();
  $('#main-content').remove();
  $('div.usabilla_live_button_container').remove();

  $('meta').each(function () {
    $(this).remove();
  });

  $('header').find('li').css('height', 'inherit');

  $('header').find('img').each(function () {
    var src = $(this).attr('src');
    $(this).attr('src', 'https://www.orange.sn/'+src);
  });
});
