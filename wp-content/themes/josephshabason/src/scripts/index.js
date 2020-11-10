(function($) {
  $(document).ready(function() {
    $('.mobile-toggle').on('click', function() {
      $('html').toggleClass('menu-active');
    })

    var currentScrollPosition;

    $('.post-link').on('click', function(event) { 
      $('.embed').hide();
      
      $target = $(`div[data-id="${$(this).attr('data-target')}"]`);

      $iframe = $target.find('iframe').first();
      var frameWidth = $iframe.width();

      $content = $target.find('.content').first();
      $content.width(frameWidth);

      $target.show();
      $('.modal').css('display', 'flex');
      
      currentScrollPosition = window.scrollY;

      $('body').css({
        position: 'fixed',
        top: (currentScrollPosition * -1) + 'px'
      })
    });

    $('.modal').not('iframe').on('click', function() {
      $('.embed:visible').each(function() {
        var $embed = $(this).find('iframe');
        $embed.attr('src', $embed.attr('src')); // reload the iframe to stop it from playing 🤡
      })

      $('.embed').hide();
      $('.modal').hide();

      $('body').css({
        position: 'relative',
        top: 'unset'
      })
      window.scroll(0, currentScrollPosition);
    })
  })

  var previousWidth = $(window).width();
  var breakpoint = 800;

  $(window).on('resize', function() {
    if ($(window).width() >= breakpoint && previousWidth < breakpoint) {
      $('html').removeClass('menu-active');
    }
  })
})(jQuery);