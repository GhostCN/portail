$("#max").hide();
$("#allo").hide();

$(document).ready(function () {
  $("#scool .next").on("click", function () {
    $(".pass-mobil").hide();
    $("#max").fadeIn();
  });

  $("#max .next").on("click", function () {
    $(".pass-mobil").hide();
    $("#allo").fadeIn();
  });

  $("#max .prev").on("click", function () {
    $(".pass-mobil").hide();
    $("#scool").fadeIn();
  })

  $("#allo .prev").on("click", function () {
    $(".pass-mobil").hide();
    $("#max").fadeIn();
  });
})
