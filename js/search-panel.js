jQuery(function($){
  // #search-panel
  $('#search-link').click(function(e){
    $('#search-link').toggleClass('showing');
    $('#search-panel').toggleClass('show');
    $('#search-field').focus();
    e.preventDefault();
    return false;
  });
  $('#phantom-search-link').click(function(){
    $('#search-link').addClass('showing');
    $('#search-panel').addClass('show');
    setTimeout(function(){ $('#search-field').focus(); }, 100)
  });
});
