jQuery( document ).ready( function() { 

	jQuery( '.passster-notice button.notice-dismiss' ).ready( function() {

		jQuery( '.passster-notice button.notice-dismiss' ).on( 'click', function() {
			
			var data = {
				'action': 'passster_dismiss_notice',
			};

			jQuery.post( admin_notice_ajax_object.ajax_url, data, function( response ) {
			});

		});

	});

});