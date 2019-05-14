$('#google-maps').css('display', 'none');
// variabel global marker
var marker;
function taruhMarker(peta, posisiTitik) {
  if (marker) {
    // pindahkan marker
    marker.setPosition(posisiTitik);
  } else {
    // buat marker baru
    marker = new google.maps.Marker({
      position: posisiTitik,
      map: peta,
    });
  }
  // animasi sekali
  marker.setAnimation(google.maps.Animation.BOUNCE);
  setTimeout(function() {
    marker.setAnimation(null);
  }, 750);
  // kirim nilai koordinat ke input
  $("input[name=code_gps]").val(posisiTitik.lat()+","+posisiTitik.lng());
}
function initialize() {
  var propertiPeta = {
    center: new google.maps.LatLng(14.714119, -17.471096),
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var peta = new google.maps.Map(document.getElementById("google-maps"), propertiPeta);
  // even listner ketika peta diklik
  google.maps.event.addListener(peta, 'click', function(event) {
    taruhMarker(this, event.latLng);
  });
  // marker.setMap(peta);
}
// event jendela di-load
google.maps.event.addDomListener(window, 'load', initialize);

$("input[name=code_gps]").click(function () {
  $('#google-maps').css('display', 'block');
});
