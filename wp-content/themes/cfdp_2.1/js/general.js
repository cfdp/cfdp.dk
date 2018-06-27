jQuery(document).ready(function($) {
    
    //Foredrag isotope
    var $container = $('.lectures');
    $container.isotope({
        filter: '*',
        layoutMode: 'fitRows',
        animationOptions: {
            duration: 750,
            easing: 'linear',
            queue: false
        }
    });
 
    $('#filters a').click(function(){
        $('#filters a.active').removeClass('active');
        $(this).addClass('active');
 
        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector,
            layoutMode: 'fitRows',
            animationOptions: {
                duration: 750,
                easing: 'linear',
                queue: false
            }
         });
         return false;
    });   
    
//Searchbar animation   
    
$( ".search-icon" ).on( "click", animateSearchBar );
function animateSearchBar() {
    $( ".search-form" ).toggleClass( "open" );
}

$( "close-search" ).on( "click", animateSearchBar );
function animateSearchBar() {
    $( ".search-form" ).toggleClass( "open" );
}

$(document).mouseup(function (e){  
    var container = $("#searchform");
    if (!container.is(e.target) && container.has(e.target).length === 0 && $( ".search-form" ).hasClass( "open" )){
        $( ".search-form" ).toggleClass( "open" );	
    }
});  	


    
    
    
    
$('.current_page_item').closest('.menu-item-has-children').addClass("opened");    
    
$('#cssmenu > ul > li > a').click(function() {
    var checkElement = $(this).next();	

    if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
      $(this).closest('li').removeClass('active');
      checkElement.slideUp('100', 'linear');
        $(this).parent().toggleClass("opened");
    }

    if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
      $('#cssmenu ul ul:visible').slideUp('normal');
      checkElement.slideDown('100', 'linear');
        $('.menu-item-has-children').not(this).removeClass("opened");
        $(this).parent().toggleClass("opened");
    }

    if (checkElement.is('ul')) {
      return false;
    } else {
      return true;	
    }
    
    if($(this).closest(".menu-item-has-children").length > 0)
   {
       
       alert("Clicked anchor with div parent class: menu-item-has-children");
   }
    
});
    
// Fixed header on scroll - subpages
    
$(window).scroll(function() {
  var scrolledY = $(window).scrollTop();
    if ($(window).width() < 1500) {
       $('.img-container').css('background-position', 'center ' + ((scrolledY)) + 'px');
    }
});
  
    
    
    
// menu animation
$('.burger').on('click', function(event) {
    $(".menu-overlay").toggleClass("open");
    $("body").css("overflow", "hidden");
}); 
    
$('.menu-overlay').on('click', function(event) {
    $(".menu-overlay").toggleClass("open");
    $("body").css("overflow", "auto");
});     

  $("#SnapABug_bImg").hover(function(){
        $("#SnapABug_bImg").attr("src","http://www.cfdp.dk/img/contact_us_over.png");
  },function(){
        $("#SnapABug_bImg").attr("src","http://www.cfdp.dk/img/contact_us.png");
   });

  $(".menu-item-15510").click(function(e){
    e.preventDefault()
    SnapABug.startLink();
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

     
    
// Scroll animation to kontakt on lecture pages
$('a[href^="#"]').on('click', function(event) {

    var target = $(this.getAttribute('href'));

    if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
            scrollTop: target.offset().top
        }, 650);
    }

});    

    
});

// newsletter widget image height    
$(window).on('load resize', function () {
    $("#module--newsletter div:nth-child(1) .widget_text").height( $("#module--newsletter div:nth-child(2)").height() );
}); 
