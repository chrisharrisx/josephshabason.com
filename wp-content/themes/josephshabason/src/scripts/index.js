(function($) {
  $(document).ready(function() {
    $('.mobile-toggle').on('click', function() {
      $('html').toggleClass('menu-active');
    })

    var currentScrollPosition;

    $('.post-link').on('click', function(event) { 
      $('.embed').hide();
      
      $target = $(`div[data-id="${$(this).attr('data-target')}"]`);

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
        $embed.attr('src', $embed.attr('src')); 
        // when modal is dismissed, reload the iframe to stop it from playing 🤡
      })
      
      $('.embed').hide();
      $('.modal').hide();

      $('body').css({
        position: 'relative',
        top: 'unset'
      })
      window.scroll(0, currentScrollPosition);
    })

    if (document.body.classList.contains('news') || document.body.classList.contains('shows')) {
      $('.nav-main-left-desktop').find('.nav-main-link[href*=news]').addClass('active parent');
    }

    $('.category-nav a').on('click', function() {
      event.preventDefault();
      $target = $('#' + $(this).data('target'));

      jQuery('html, body').animate({
        scrollTop: ($target.offset().top - 300)
      }, 500);
    });
  })

  var previousWidth = $(window).width();
  var breakpoint = 802;

  $(window).on('resize', function() {
    if ($(window).width() >= breakpoint && previousWidth < breakpoint) {
      $('html').removeClass('menu-active');
    }
    previousWidth = $(window).width();
  })
})(jQuery);