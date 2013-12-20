// Navigation


jQuery(document).ready(function($) {
    maxWidth = 478;
    minWidth = 138;  

    $("ul li div.tab").hover(
      function(){
        $(lastBlock).animate({width: minWidth+"px"}, { queue:false, duration:450 });
      $(this).animate({width: maxWidth+"px"}, { queue:false, duration:450});
      lastBlock = this;
      }
    );
    $('a.topLink').click(function(){
	     $('html, body').animate({scrollTop: '0px'}, 300);
	     return false;
	});
      $("#SnapABug_bImg").hover(function(){
            $("#SnapABug_bImg").attr("src","http://www.cfdp.dk/img/contact_us_over.png");
      },function(){
            $("#SnapABug_bImg").attr("src","http://www.cfdp.dk/img/contact_us.png");
       });

});
