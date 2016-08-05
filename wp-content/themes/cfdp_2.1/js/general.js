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
});