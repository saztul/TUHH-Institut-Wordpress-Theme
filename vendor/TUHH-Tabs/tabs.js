(function(Api, $){
  
  var remember = function(view, tab){
	  if(view.data('remember-as') && sessionStorage && sessionStorage.setItem){
		  sessionStorage.setItem(view.data('remember-as'), tab);
	  }
  };
	
  // handle tab selection
  var click_handler = function(e){
    var clicked = $(this);
    var view = $(clicked.parents('.tab-view'));
    // select tab
    view.find('.default-tab').removeClass('default-tab');
    view.find('.tab').hide();
    view.find('.tab:nth-child('+clicked.data('tab')+')').show();
    remember(view, clicked.data('tab'));
    // select header
    view.find('.tab-header a').removeClass('active');
    clicked.addClass('active');
    e.preventDefault();
    return false;
  };
  
  // create html for tabs
  var build_tab_view = function(view){
	var remembered = 0;
	var view_name = view.data('remember-as');
    if(view_name && sessionStorage && sessionStorage.getItem){
    	var remembered = sessionStorage.getItem(view_name);
    }
    var header = $('<div class=tab-header/>')
    view.find('.tab').each(function(i, e){
      var tab = $('<a href="#"/>').
                text($(e).data('title')).
                attr('data-tab', 1+i).
                click(click_handler);
      if(remembered == 0 && $(e).hasClass('default-tab')){
        tab.addClass('active');
      }else if(remembered == i+1){
    	tab.addClass('active');
      }
      header.append(tab);
    });
    view.prepend(header);
  };
  
  var pause_handler = function(e){
    if(is_paying){
      stop_tab_autoplay();
    }
    else{
      start_tab_autoplay();
    }
    e.preventDefault();
    return false;
  };
  
  // create pause button
  var build_pause_button = function(view){
    view.addClass('has-pause-button');
    var pause_button = $('<a href="#" class="pause-button"/>').attr('title', button_caption_play).click(pause_handler);
    view.prepend(pause_button);
  };
  
  // set defaults for tab divs
  var initialize_tabs = function(view){
    view.addClass('activated');
    if(view.find('.default-tab').length == 0){
      view.find('.tab:first-child').addClass('default-tab');
    }
  };
  
  var select_next_tab = function(view){
    var next = view.find('.tab-header a.active').next();
    if(!next.length){
      next = view.find('.tab-header a:first-child');
    }
    $(next).click();
  };
  
  var tab_autoplay_tick = function(){
    // find all tab-views 
    if($('.tab-view:hover').length){
      // tabs nicht weiterblaettern wenn maus drueber ist
      return;
    }
    $('.tab-view[data-auto-rotate]').each(function(i, _view){
      var view = $(_view); 
      var rotate_after = view.data('auto-rotate');
      var time;
      if(rotate_after){
        time = view.data('timer') || 1;
        if(time > rotate_after){
          time = 1;
          select_next_tab(view);
        }
        else{
          time++;
        }
        view.data('timer', time);
      }
    })
  };
  
  var tab_autoplay_timer;
  var is_paying = false;
  
  Api.start_tab_autoplay = function(){
    is_paying = true;
    $('.tab-view .pause-button').attr('class', 'pause-button playing').attr('title', button_caption_pause);
    tab_autoplay_timer = setInterval(function(){
      tab_autoplay_tick();
    }, 1000);
  };
  
  Api.stop_tab_autoplay = function(){
    is_paying = false;
    $('.tab-view .pause-button').attr('class', 'pause-button paused').attr('title', button_caption_play);
    clearInterval(tab_autoplay_timer);
  };
  var caption_play, caption_pause;
  // find and init tab views
  Api.init_tab_views = function(play_text, pause_text){
    button_caption_play = play_text;
    button_caption_pause = pause_text;
    $('.tab-view').each(function(i, _view){
      var view = $(_view); 
      initialize_tabs(view);
      build_tab_view(view);
      if(view.data('auto-rotate')){
        build_pause_button(view);
      }
    });
    start_tab_autoplay();
  }; 

})(window, jQuery);

jQuery(function(){
  init_tab_views('Abspielen', 'Anhalten');
});
