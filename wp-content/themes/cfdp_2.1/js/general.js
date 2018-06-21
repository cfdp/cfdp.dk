jQuery(document).ready(function($) {
    
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

     
    
// load front page video    
function isIE () {
    var myNav = navigator.userAgent.toLowerCase();
    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
}

window.isIEOld = isIE() && isIE() < 9;
window.isiPad = navigator.userAgent.match(/iPad/i);

var img = $('.video').data('placeholder'),
    video = $('.video').data('video'),
    noVideo = $('.video').data('src'),
    el = '';

if($(window).width() > 599 && !isIEOld && !isiPad) {
    el +=   '<video autoplay loop poster="' + img + '">';
    el +=       '<source src="' + video + '" type="video/mp4">';
    el +=   '</video>';
} else {
    el = '<div class="video-element" style="background-image: url(' + noVideo + ')"></div>';
}

$('.video').prepend(el);   
    
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
