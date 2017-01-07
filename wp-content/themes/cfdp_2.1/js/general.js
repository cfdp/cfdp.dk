jQuery(document).ready(function($) {

  $("#SnapABug_bImg").hover(function(){
        $("#SnapABug_bImg").attr("src","http://www.cfdp.dk/img/contact_us_over.png");
  },function(){
        $("#SnapABug_bImg").attr("src","http://www.cfdp.dk/img/contact_us.png");
   });

  $(".menu-item-15510").click(function(e){
    e.preventDefault()
    SnapABug.startLink();
  });

  // https://github.com/artberri/sidr
  $('#toggle-menu-button').sidr({
    name: 'mobile-menu',
    side: 'right'
  });

  // If no thanks link is click hide newsletter form

  $('.action--dismiss-module').click(function(e){
    e.preventDefault();
    $('#module--newsletter').fadeOut('slow');
    Cookies.set('newsletterForm', 'hide');
  });

  // If cookie is set then hide newsletter form
  if( Cookies.get('newsletterForm') == 'hide' ){
    $('#module--newsletter').hide();
  }
});