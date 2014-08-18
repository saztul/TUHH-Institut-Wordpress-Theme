(function(api, $){
  var slider_html = '<div id="bg-slider"><span class="current-bg"/><span class="incoming-bg"/></div>';
  
  // store teaser position in session storage
  var store_pos = function(pos){
    if(Modernizr.sessionstorage){
      sessionStorage.teaser_pos = pos;
    }
  };
  
  // load teaser position from session storage
  var teaser_pos = function(){
    if(Modernizr.sessionstorage){
      return parseInt(sessionStorage.teaser_pos, 10) || 1;
    } else {
      return 1;
    }
  };
  
  var background_from = function(element){
    var img = element.data('background');
    if(!img) return false;
    return "url('" + img + "') 100% 40% no-repeat";
  };
  
  var tick = function(){
    if($('html.paused').length == 0){
      // #teaser:hover
      go_forward();
    }
  };
  
  var animate_transition = function(next, before_current, after_current){
    var current = $('#teaser .current');
    next.addClass(after_current);
    setTimeout(function(){
      $('#teaser article').attr('class', '');
      current.attr('class', before_current);
      next.attr('class', 'current');
      store_pos(1 + next.index());
      slide_in(background_from(next));
      select_matching_number();
      set_tabindex();
    }, 10);
  };
  
  var set_tabindex = function(){
    $('#teaser article a').attr('tabindex', '-1')
    $('#teaser .current a').removeAttr('tabindex')
  };
  
  var go_forward = function(){
    animate_transition($('#teaser .current').nextOrFirst(), 'previous', 'next');
  };
  
  var go_backward = function(){
    animate_transition($('#teaser .current').prevOrLast(), 'next', 'previous');
  };
  
  var go_to = function(element_nr){
    var to = $("#teaser article:nth-child(" + parseInt(element_nr, 10) + ")");
    if(!to || to.hasClass('current')) return;
    animate_transition(to, 'previous', 'next');
  };
  
  var make_numbers = function(){
    var nr_of_links = $('#teaser article').length;
    $('#teaser').addClass("with-" + nr_of_links + "-items").append('<nav id="numbers"/>');
    links = '';
    for(var i = 0; i < nr_of_links; i++){
      links = links + "<a href=\"#\">" + (i + 1) + "</a>";
    }
    $('#numbers').append(links);
    select_matching_number();
    $('#numbers').click(function(e){
      var clicked = $(e.srcElement || e.target);
      if(clicked.is('a')){
        go_to(clicked.index() + 1);
      }
      e.preventDefault();
      return false;
    });
  };
  
  var select_matching_number = function(){
    var nr = 1 + $('#teaser .current').index();
    $('#numbers a').removeClass('active');
    $("#numbers a:nth-child(" + nr + ")").addClass('active');
  };
  
  var slide_in = function(background){
    if(!background)return;
    var current_frame = $('#teaser .current-bg');
    var next_frame = $('#teaser .incoming-bg');
    next_frame.css({ background: background }).addClass('show');
    setTimeout(function(){
      next_frame.attr('class', 'current-bg');
      current_frame.attr('class', 'incoming-bg');
    }, 300);
  };
  
  api.animate_teaser_forward = function(){ 
    go_forward(); 
  };
  
  api.animate_teaser_backward = function(){ 
    go_backward(); 
  };
  
  api.animate_teaser_to = function(element_nr){ 
    go_to(element_nr); 
  };
  
  api.play = function(){
    $('html').removeClass('paused');
    if(Modernizr.sessionstorage){ sessionStorage.teaser_paused = "no"; }
  };
  
  api.pause = function(){
    $('html').addClass('paused');
    if(Modernizr.sessionstorage){ sessionStorage.teaser_paused = "yes"; }
  };
  
  api.toggle_play = function(){
    if($('html').hasClass('paused')){ api.play(); }
    else{ api.pause(); }
  };
  
  api.init_teaser = function(){
    var time = 7500;
    var duration;
    // restore last position
    var current = $("#teaser article:first-child, #teaser article:nth-child(" + teaser_pos() + ")").last();
    // stop if there are no articles to animate
    if(current.length > 0){
      // set up teaser
      current.addClass('current');
      current.prevOrLast().attr('class', 'previous');
      current.nextOrFirst().attr('class', 'next');
      $('#teaser').addClass('running').append($(slider_html));
      $('.current-bg').css({ background: background_from(current) });
      $('#play-pause-button').click(function(e){
        toggle_play();
        e.preventDefault();
        return false;
      });
      set_tabindex();
    }
    make_numbers();
    if($('#slider article').length > 1){
      duration = $('#teaser').data('duration');
      if(duration){
        time = parseInt(duration, 10) * 1000;
      }
      setInterval(tick, time);
    }
    if(Modernizr.sessionstorage && sessionStorage.teaser_paused == "yes"){
      api.pause();
    }
  };
  
})(window, jQuery);
jQuery(function(){
  init_teaser();
});