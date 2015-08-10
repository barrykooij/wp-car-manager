jQuery( function ( $ ) {
    $.each( $( '.wpcm-extension-license a' ), function ( k, v ) {
        $( v ).click( function () {
            var wrap = $( v ).closest( '.wpcm-extension-license' );

            var ex_ac = ('inactive' == $( wrap ).find( '#wpcm-status' ).val() ) ? 'activate' : 'deactivate';

            $.post( ajaxurl, {
                action: 'wpcm_extension',
                nonce: $( '#wpcm-ajax-nonce' ).val(),
                product_id: $( wrap ).find( '#wpcm-product-id' ).val(),
                key: $( wrap ).find( '#wpcm-key' ).val(),
                email: $( wrap ).find( '#wpcm-email' ).val(),
                extension_action: ex_ac
            }, function ( response ) {
                if ( response.result == 'failed' ) {
                    alert( response.message );
                } else {
                    if ( 'activate' == ex_ac ) {
                        $( wrap ).find( '.wpcm-license-status' ).addClass( 'active' ).html( 'ACTIVE' );
                        $( wrap ).find( '.button' ).html( 'Deactivate' );
                        $( wrap ).find( '#wpcm-status' ).val( 'active' );
                        $( wrap ).find( '#wpcm-key' ).attr('disabled', true);
                        $( wrap ).find( '#wpcm-email' ).attr('disabled', true);
                    } else {
                        $( wrap ).find( '.wpcm-license-status' ).removeClass( 'active' ).html( 'INACTIVE' );
                        $( wrap ).find( '.button' ).html( 'Activate' );
                        $( wrap ).find( '#wpcm-status' ).val( 'inactive' );
                        $( wrap ).find( '#wpcm-key' ).attr('disabled', false);
                        $( wrap ).find( '#wpcm-email' ).attr('disabled', false);
                    }
                }
            } );

        } );
    } );
} );