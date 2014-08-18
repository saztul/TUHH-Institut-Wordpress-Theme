;(function(api, $){
  
  // create a column group and apply all the attributes from the node
  var create_column_group = function(node){
    var group = $('<div/>');
    return group;
  };
  
  // create an ul-element with classes
  var create_list = function(classes){
    var list = $('<ul/>');
    list.attr('class', classes);
    return list;
  };
  
  //find the best way to split a tree
  var find_tipping_point = function(complete_count, tree_sizes){
    var optimal = Math.floor(complete_count / 2);
    var scope = 0;
    var current_size = 0;
    // add until we step over the middle
    for(var i = 0; i < tree_sizes.length; i++){
      scope = i;
      current_size += tree_sizes[i];
      if(current_size >= optimal) break;
    }
    // select the scope with the smallest difference to the optimal value
    var best_over = Math.abs(optimal - current_size);
    var best_under = Math.abs(optimal - (current_size - tree_sizes[scope]));
    if(best_under < best_over && scope > 0){
      scope--;
    }
    return scope;
  };
  
  // copy the first node from node to a and the rest to b
  var spilt_tree = function(node, last_in_a, a, b){
    var target = a;
    node.children('li').each(function(i, e){
      target.append($(e).clone());
      if(i == last_in_a){
        target = b;
      }
    });
  };
  
  // fill a and b with the entries from node
  var arrange_entries = function(node, a, b){
    // count menu items
    var first_level_nodes = node.children('li');
    var complete_count = node.find('li').length;
    api.log('node count '+complete_count);
    
    // count tree size
    var tree_sizes = [];
    first_level_nodes.each(function(i, e){
      // +1 for the first level node
      tree_sizes[i] = $(e).find('li').length + 1;
      api.log('node '+i+' sub count '+tree_sizes[i]);
    });
    
    var overflow_after = find_tipping_point(complete_count, tree_sizes);
    spilt_tree(node, overflow_after, a, b);
  };

  // create two lists from one
  api.balance_node = function(node){
    // create group
    var balanced_node = create_column_group(node);
    
    // create a-col
    var a = create_list("first-column");
    balanced_node.append(a)
    
    // create b-col
    var b = create_list("second-column");
    balanced_node.append(b)
    
    // arrange(node, a, b)
    arrange_entries(node, a, b);
    
    return balanced_node;
  };

})(window, jQuery);

;(function(api, $){
  var flag = 'expanding';
  
  // add the jquery wrapper to the nav html
  var create_src_node = function(nav_html){
    return $('<ul/>').html(nav_html);
  };
  
  // create the navigation replacement node
  var create_target_node = function(){
    return $('<nav id="top-navigation" class="main-navigation mega-menu" />');
  };
  
  // create list elements from the source-node
  var extract_top_elements = function(src_node){
    var ret = [];
    src_node.children('li').each(function(i, e){
      var sub = $(e).children('a').first().clone();
      sub.attr('data-submenu', 'sub-'+i);
      ret.push($('<li/>').append(sub));
    });
    return ret;
  };
  
  var close_menu = function(){ };
  
  var toggle_menu_expand = function(e, target_node){
    var clicked = $(e.target || e.srcElement);
    // remove flag from all menu openers
    if(clicked.hasClass(flag)){
      // close menu
      target_node.find('.mega-folder').removeClass(flag);
      target_node.removeClass('open-menu');
    }
    else{
      // show menu 
      target_node.find('.mega-folder').removeClass(flag);
      target_node.addClass('open-menu');
      target_node.find('.sub-menu').hide();
      // mark clicked menu opener as active
      clicked.addClass(flag);
      target_node.find('#'+clicked.data('for')).show();
    }
    e.preventDefault();
    e.cancel();
    return false;
  };
  
  var build_expand_arrow = function(index, target_node){
    return $('<a href="#" class="mega-folder"/>')
      .attr('data-for', 'sub-'+index)
      .addClass('for-'+index)
      .html('&nbsp;')
      .click(function(e){ return toggle_menu_expand(e, target_node); })
      .hide();
  };
  
  // build the navi and append it to the output node
  var build_top_navi = function(target_node, top_elemets){
    var container = $('<ul id="top-level"/>');
    $.each(top_elemets, function(i, item){
      container.append(item.append(build_expand_arrow(i, target_node)));
    });
    // container.append(top_elemets);
    target_node.append(container);
  };
  
  // build the sub-navi container and append it to the output
  var build_sub_navi_container = function(target_node){
    var container = $('<div id="mega-menu-container"/>');
    target_node.append(container);
    return container;
  };
  
  // import sub-menus  into the sub-navi node
  var build_sub_navis = function(target_node, src_node, container_node){
    src_node.children('li').each(function(i, e){
      var sub = $(e).children('ul').first();
      if(sub.find('li').length > 0){
        var menu = api.balance_node(sub);
        menu.attr('id', 'sub-'+i);
        menu.addClass('sub-menu');
        target_node.find('.for-'+i).attr('style', null);
        container_node.append(menu);
      }
    });
  };
  
  var build_menu_closer = function(target_node){
    close_menu = function(){
      if(target_node.hasClass('open-menu')){
        target_node.find('.mega-folder').removeClass(flag);
        target_node.removeClass('open-menu');  
      }
    };
  };
  
  var register_event_handlers = function(){
    $(document).keyup(function(e) {
      if (e.keyCode == 27) { close_menu(); }   // esc
    });
    $('html').click(function() {
      close_menu();
    });
    $('#top-navigation').click(function(event){
        event.stopPropagation();
    });
  };
  
  var select_submenu_entry = function(){
    var selected = $('#sidebar-navigation .selected').first();
    if(selected.length > 0){
      href = selected.attr('href');
      select = $('#mega-menu-container').find('a[href="'+href+'"]');
      select.addClass('selected');
    }
  };

  var init = function(nav_html){
    //convert to jquery object
    var src_node = create_src_node(nav_html);
    var target_node = create_target_node();
    
    build_menu_closer(target_node);
    
    //make sure top navi is as desired
    //the ajax loaded map could differ from the current version
    build_top_navi(target_node, extract_top_elements(src_node));
    
    //move sub navis in their container
    var sub_container_node = build_sub_navi_container(target_node);
    build_sub_navis(target_node, src_node, sub_container_node);
    
    //cache html
    $('#top-navigation').replaceWith(target_node);
    $('#sidebar-navigation').hide();
    select_submenu_entry();
    register_event_handlers();
  } 
  
  api.init_mega_menu = function(){
    //try cached
    api.load_navigation(function(sitemap){
      init(sitemap);
    });
  };
})(window, jQuery);

jQuery(function(){
  init_mega_menu();
});
