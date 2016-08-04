jQuery(document).ready(function($) {

  $('a.topLink').click(function(){
     $('html, body').animate({scrollTop: '0px'}, 300);
     return false;
	});

  $("#SnapABug_bImg").hover(function(){
        $("#SnapABug_bImg").attr("src","http://www.cfdp.dk/img/contact_us_over.png");
  },function(){
        $("#SnapABug_bImg").attr("src","http://www.cfdp.dk/img/contact_us.png");
   });

  // https://github.com/artberri/sidr
  $('#toggle-menu-button').sidr({
    name: 'mobile-menu',
    side: 'right'
  });
});