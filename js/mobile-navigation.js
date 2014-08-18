;(function(api, $){
  var tuhh = '<li class="tuhh"><span class="tuhh-logo"></span><a href="http://www.tuhh.de">ZUR TUHH</a></li>';
  
  var add_nav_buttons = function(){
    var menus = $('#mobile-navigation a~ul');
    menus.siblings('a').addClass('has-submenu').before('<span class="show-submenu"></span>');
    menus.each(function(i, e){
      var menu, link, top;
      menu = $(e);
      link = menu.siblings('a').first();
      top = $('<div>').append($('<a></a>').attr('href', link.attr('href')).text(link.text()));
      menu.prepend('<li class="back"><span class="hide-submenu"></span>' + top.html() + '</li>');
    });
  };
  
  var add_nav_actions = function(){
    $('#mobile-navigation').on('click', '.hide-submenu', function(e){
      var target = $(e.target || e.srcElement);
      target = target.parent('li').parent('ul');
      target.removeClass('show');
      target.siblings('a').removeClass('is-parent');
    })
    $('#mobile-navigation').on('click', '.show-submenu', function(e){
      var target = $(e.target || e.srcElement)
      target.siblings('ul').addClass('show');
      target.siblings('a').addClass('is-parent');
      $('#mobile-navigation').scrollTop(0)
    });
  };

  var find_place_in_nav = function(){
    var active_link = $('#top-navigation .parent-of-selected,#sidebar-navigation .selected').last().attr('href');
    if(active_link){
      var select = $('#mobile-navigation a[href="'+active_link+'"]').last().parents('ul');
      for(var i = select.length; i > 0; i--){
        $(select[i-1]).siblings('span').click();
      }
    }
  };

  api.initialize_mobile_navigation = function(){
    if($('html').hasClass('has-mobile-nav')) return;
    
    $('html').addClass('has-mobile-nav').addClass('loading-mobile-nav');
    var remote_url = $('body').data('url');
    var when_done = function(){
      add_nav_buttons();
      add_nav_actions();
      find_place_in_nav();
      $('html').removeClass('loading-mobile-nav');
    };
    api.load_navigation(function(nav){
      $('#mobile-navigation').html('<ul class="top-layer">' + tuhh + nav + '</ul>');
      when_done();
    });
  };

  api.toggle_mobile_navigation = function(){
    initialize_mobile_navigation();
    html = $('html');
    html.toggleClass('pushed');
    if(Modernizr.sessionstorage){
      if(html.hasClass('pushed')){ 
        sessionStorage.pushed = 'yes'; 
      } else { 
        sessionStorage.pushed = 'no'; 
      }
    }
  };
})(window, jQuery);

jQuery(function($){
  if(/(iPad|iPhone|iPod)/g.test( navigator.userAgent )){
    $('html').addClass('ios');
  }
  if($('html').hasClass('pushed')){
    initialize_mobile_navigation();
  }
  $('#show-mobile-navigation').click(function(){
    toggle_mobile_navigation();
  });
  
  // webkit touch scroll fix
  // see: http://stackoverflow.com/questions/18736297/webkit-overflow-scrolling-touch-broken-in-ios7
  $('#mobile-navigation').on('touchstart', function(event){});
});
