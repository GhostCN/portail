(function ($) {
  $.fn.loading = function () {
    var DEFAULTS = {
      backgroundColor: '#b3cef6',
      progressColor: '#4b86db',
      percent: 75,
      duration: 2000,
      text: "Home"
    };

    $(this).each(function () {
      var $target  = $(this);

      var opts = {
        backgroundColor: $target.data('color') ? $target.data('color').split(',')[0] : DEFAULTS.backgroundColor,
        progressColor: $target.data('color') ? $target.data('color').split(',')[1] : DEFAULTS.progressColor,
        percent: $target.data('percent') ? $target.data('percent') : DEFAULTS.percent,
        duration: $target.data('duration') ? $target.data('duration') : DEFAULTS.duration,
        text: $target.data('text') ? $target.data('text') : DEFAULTS.text
      };
      // console.log(opts);

      $target.append('<div class="background"></div><div class="rotate"></div><div class="left"></div><div class="right"></div><div class=""><span>' + opts.text + '</span></div>');

      $target.find('.background').css('background-color', opts.backgroundColor);
      $target.find('.left').css('background-color', opts.backgroundColor);
      $target.find('.rotate').css('background-color', opts.progressColor);
      $target.find('.right').css('background-color', opts.progressColor);

      var $rotate = $target.find('.rotate');
      setTimeout(function () {
        $rotate.css({
          'transition': 'transform ' + opts.duration + 'ms linear',
          'transform': 'rotate(' + opts.percent * 3.6 + 'deg)'
        });
      },1);

      if (opts.percent > 50) {
        var animationRight = 'toggle ' + (opts.duration / opts.percent * 50) + 'ms step-end';
        var animationLeft = 'toggle ' + (opts.duration / opts.percent * 50) + 'ms step-start';
        $target.find('.right').css({
          animation: animationRight,
          opacity: 1
        });
        $target.find('.left').css({
          animation: animationLeft,
          opacity: 0
        });
      }
    });
  }

  var view = true;

  function isScrolledIntoView(elem){
    var $elem = $(elem);
    var $window = $(window);

    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height();

    var elemTop = $elem.offset().top;
    var elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
  }

  $(window).scroll(function(){
    $('.progress-bar').each(function(){
      if(isScrolledIntoView($(this))){
        if(view){
          $(".progress-bar").loading();
          view = false;
        }
      }

    });
  });

  $(".test-fast").on("click", function(){
    $(".test-fast").removeClass("active");
    $(this).addClass("active");
    $(".progress-bar").html('')

    $(".vfibre").data("duration", $(this).data("vfbr"));
    $(".vfibre").data("text", $(this).data("tfibre"));

    $(".vadsl").data("duration", $(this).data("vadsl"));
    $(".vadsl").data("text", $(this).data("tadsl"));


    $(".progress-bar").loading();
  })
})(jQuery);
