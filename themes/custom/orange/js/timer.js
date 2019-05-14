function contDown(){
  var date_event =  document.getElementById('date_event').value;
    var now = new Date();
    var eventDate = new Date(date_event);
    //var eventDate = new Date(2018, 9, 30);

    var currentTime = now.getTime();
    var eventTime = eventDate.getTime();

    var diff = eventTime - currentTime;


    var s = Math.floor(diff/1000);
    var m = Math.floor(s/60);
    var h = Math.floor(m/60);
    var j = Math.floor(h/24);

    h %= 24;
    m %= 60;
    s %= 60;

    h = (h <10 ) ? "0" + h : h;
    m = (m <10 ) ? "0" + m : m;
    s = (s <10 ) ? "0" + s : s;

    if(m > 0) {
      document.getElementById('u-jj').innerHTML = j % 10;
      document.getElementById('d-jj').innerHTML = Math.floor(j / 10);

      document.getElementById('u-hh').innerHTML = h % 10;
      document.getElementById('d-hh').innerHTML = Math.floor(h / 10);

      document.getElementById('u-mn').innerHTML = m % 10;
      document.getElementById('d-mn').innerHTML = Math.floor(m / 10);

      document.getElementById('u-ss').innerHTML = s % 10;
      document.getElementById('d-ss').innerHTML = Math.floor(s / 10);
      setTimeout(contDown, 1000);
    }
    else {
      if(document.getElementById('block-timer')) {
        document.getElementById('block-timer').style.display = 'none';
      }
    }
}
(function ($, Drupal) {
  //$(document).ready(function(){
    contDown();
  //});
})(window.jQuery, window.Drupal);
