;(function(api, $){
  api.log = function(){};
  // if(console && console.log){
  //   api.log = function(msg){
  //     // console.log(msg);
  //   };
  // }
})(window, jQuery);

;(function(api, $){
    
  ////////////
  // CACHE
  ////////////

  var _cache_key;
  var cache_key = function(){
    if(!_cache_key){
      _cache_key = $('body').data('cache-key-prefix') || '';
      _cache_key += '_N_C_140627';
    }
    return _cache_key;
  };
  
  var can_cache = function(){
    return Modernizr.sessionstorage;
  };
  
  var is_cached = function(){
    return can_cache() && sessionStorage.getItem(cache_key()) !== null
  };

  var cache_fill = function(callback, update){
    if(can_cache()){
      if(update && typeof update == "string" && update.length > 8){
        sessionStorage.setItem(cache_key(), update);
      }
      if(callback && typeof callback == "function"){
        callback(sessionStorage.getItem(cache_key()));
      }
    }
    else{
      callback(update);
    }
  };

  ////////////
  // local
  ////////////
  
  var load_local = function(load_callback){
    //create doc fragment
    var nav = $('<ul/>');
    //copy top-nav to fragment 
    nav.html($('#top-navigation ul').html())
    //append sub-menus
    nav.find('a[data-submenu]').each(function(index, element){
      //jquery wrapper
      var node = $(element);
      //what menu to append to the node
      var menu = $('#' + node.data('submenu'));
      if(menu.length){
        // append sub-menu html to node
        node.after("<ul>" + menu.html() + "</ul>");
      }
    });
    nav.find('a').removeClass('selected');
    nav.find('a').removeClass('parent-of-selected');
    load_callback(nav.html());
  };
  
  ////////////
  // remote
  ////////////
  
  var remote_url = function(){ 
    return $('body').data('url'); 
  };
  
  var is_remote = function(){
    return !!remote_url();
  };

  var parse_remote_data = function(data){ 
    data = data.split(/\n/)[1];
    return $(data).find('ul ul').first().html(); 
  };

  var load_remote = function(load_callback){
    $.ajax(remote_url()).done(function(data){
      load_callback(parse_remote_data(data));
    });
  };
  
  ////////////
  // API
  ////////////
  api.load_navigation = function(nav_did_load){
    var load_callback = function(update_data){
      cache_fill(nav_did_load, update_data);
    };
    if(is_cached()){
      cache_fill(nav_did_load);
    }
    else if(is_remote()){
      load_remote(load_callback);
    }
    else{
      load_local(load_callback);
    }
  };

  api.clear_navigation_cache = function(){
    if(can_cache()){
      sessionStorage.removeItem(cache_key());
    } 
  };
    
  
})(window, jQuery);