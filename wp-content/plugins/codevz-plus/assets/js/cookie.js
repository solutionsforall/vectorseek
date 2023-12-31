jQuery( function( $ ) {
	"use strict";

	function setCookie( name, value, days ) {

		var expires = "";

		if (days) {
			var date = new Date();
			date.setTime( date.getTime() + ( days*24*60*60*1000 ) );
			expires = "; expires=" + date.toUTCString();
		}

		document.cookie = name + "=" + ( value || "" )  + expires + "; path=/";

	}

	function getCookie( name ) {
		
		var nameEQ = name + "=",
			ca = document.cookie.split(';');
		
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}

		return null;
	}

	if ( ! getCookie( 'xtra_cookie' ) ) {

		$( '.xtra-cookie' ).fadeIn();

	}

	// Close and hide cookie div.
	$( document.body ).on( 'click', '.xtra-cookie-button', function() {

		$( this ).parent().fadeOut();

		setCookie( 'xtra_cookie', '1', 90 );

	});

});