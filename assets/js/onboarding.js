jQuery( function ( $ ) {
	$.each( $( '.wpcm-onboarding-pages a.button' ), function ( k, v ) {
		$( v ).click( function () {
			var tgt = $( v );

			if ( tgt.attr( 'disabled' ) ) {
				return;
			}

			tgt.html( wpcm.lbl_creating );
			tgt.attr( 'disabled', true );
			$.post( wpcm.ajax_url_create_page, {
				nonce: wpcm.nonce_create_page,
				page: tgt.data( 'page' )
			}, function ( response ) {
				if ( true == response.success ) {
					tgt.html( wpcm.lbl_created );
				} else {
					alert( 'Something went wrong while creating the page, please try again.' );
					tgt.attr( 'disabled', false );
					tgt.html( wpcm.lbl_create_page );
				}
			} );
		} );
	} );
} );