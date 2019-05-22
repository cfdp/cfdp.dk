jQuery( document ).ready( function() { 
    jQuery( '.passster-captcha-notice button.notice-dismiss' ).ready( function() {

        jQuery( '.passster-captcha-notice button.notice-dismiss' ).on( 'click', function() {
            
            var data = {
                'action': 'passster_dismiss_captcha_notice',
            };

            jQuery.post( captcha_notice_ajax_object.ajax_url, data, function( response ) {
            });

        });

    });
});