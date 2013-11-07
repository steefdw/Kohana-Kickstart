$().ready(function(){
    
    // (non)JS specific content
    $('.nojs').hide();
    $('.jsonly').show();

    // messages after page title
    if($('.alert + h2').length != 0)
    {
        var message = $('.alert');
        $('.alert + h2').after(message);
    }
    
    $(".alert .close").click(function(){
         $(this).parent().fadeOut();                        
         return false;
    });
    
    // auto hide messages after 10sec    
    $('.message').animate({opacity: 0.8}, 10000).fadeOut();
    
    // Styling current form fieldrow
    $("input,select,textarea").focus(function() {
        $(this).parent().parent().addClass("cur_focus");
    });
    $("input,select,textarea").blur(function() {
        $(this).parent().parent().removeClass("cur_focus");
    });

    if($('.subnav').length != 0) {
      $('.subnav').scrollspy();
      $('body').attr({
        'data-spy'   : 'scroll',
        'data-target': '.subnav',
        'data-offset': '40'
      }).addClass('scrollspy');
    }
    
    // fix sub nav on scroll
    var $win = $(window)
      , $nav = $('.subnav')
      , offset  = ($('.navbar-fixed-top').length != 0) ? 40 : 0
      , classes = ($('.navbar-fixed-top').length != 0) ? 'subnav-fixed' : 'subnav-fixed solo'
      , navTop  = $('.subnav').length && $('.subnav').offset().top - offset
      , isFixed = 0
      , $dummy    = '<div class="dummy_element" style="background:transparent;height:'+$nav.outerHeight(true)+'px;"></div>';

    processScroll();

    $win.on('scroll', processScroll);

    function processScroll() {
      var scrollTop = $win.scrollTop();
      if (scrollTop >= navTop && !isFixed) {
        isFixed = 1;
        $nav.addClass(classes);
        $nav.after($dummy);
      } else if (scrollTop <= navTop && isFixed) {
        isFixed = 0;
        $nav.removeClass(classes);
        $('.dummy_element').remove();
      }
    }

    /* animate sectionheader after clicking on a subnav link for visual cue */
    $('.subnav a').click(function(){
         $($(this).attr("href")).find(".section-header").css('opacity','0.3').animate({'opacity':'1'},300);
    });
    
    prettyPrint();
    
});