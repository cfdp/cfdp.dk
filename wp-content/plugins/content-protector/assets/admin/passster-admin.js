jQuery(document).ready(function( $ ) {

	/* password generator */
	var password = {
	    rules: [
	        {
	            characters: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890',
	            max: 12
	        },
	    ],
	    generate: function () {
	        var g = '';

	        $.each(password.rules, function (k, v) {
	            var m = v.max;
	            for (var i = 1; i <= m; i++) {
	                g = g + v.characters[Math.floor(Math.random() * (v.characters.length))];
	            }
	            if (v.callback) {
	                g = v.callback(g);
	            }
	        });
	        return g;
	    }
	}

	/* add a generate button to settings page */
	$( '<span class="generate">Generate Password</span>' ).insertAfter( '.password-generator' );

	/* generate password */
	$('.generate').on('click',function() {
		$('.password-generator').val( password.generate() );
	})

	/* copy shortcode / link */
	$.fn.CopyToClipboard = function() {
	    var textToCopy = false;
	    if(this.is('select') || this.is('textarea') || this.is('input')){
	        textToCopy = this.val();
	    }else {
	        textToCopy = this.text();
	    }
	    CopyToClipboard(textToCopy);
	};

	function CopyToClipboard( val ) {
	    var hiddenClipboard = $('#_hiddenClipboard_');
	    if(!hiddenClipboard.length){
	        $('body').append('<textarea style="position:absolute;top: -9999px;" id="_hiddenClipboard_"></textarea>');
	        hiddenClipboard = $('#_hiddenClipboard_');
	    }
	    hiddenClipboard.html(val);
	    hiddenClipboard.select();
	    document.execCommand('copy');
	    document.getSelection().removeAllRanges();
	}

	$(function(){
	    $('[data-clipboard-target]').each(function(){
	        $(this).click(function() {
	            $($(this).data('clipboard-target')).CopyToClipboard();
	        });
	    });
	    $('[data-clipboard-text]').each(function(){
	        $(this).click(function(){
	            CopyToClipboard($(this).data('clipboard-text'));
	        });
	    });
	});

	/* premium indicator */
    $("input.premium").attr('disabled', 'disabled');
    let td = $("input.premium").parent();
	$(td).append('<span class="pro">PRO</span>');

	/* message on copy */
	$( '.copy' ).on('click',function() {
		
		$('.copy').parent().append('<span class="copied">Copied.</span>');

		setTimeout(function() {
 			$('.copied').fadeOut(500);
		}, 2000);

		setTimeout(function() {
 			$('.copied').remove();
		}, 2500);

	});

	

});

