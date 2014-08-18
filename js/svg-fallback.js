jQuery(function($){
  if(!Modernizr.svg){
    $('img[data-fallback]').each(function(i, e){
      var img = $(e);
      img.attr('src', img.data('fallback'));
    });
  }
});
