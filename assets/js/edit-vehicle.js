jQuery( function ( $ ) {

    $( 'select#make' ).change( function () {
        var selected_make = $( this ).find( 'option:selected' ).val();
        var select_model = $( 'select#model' );
        select_model.find( 'option' ).remove().end().append( $( '<option>' ).val( 0 ).html( 'Select Model' ) );
        // @todo display loading icon
        jQuery.post( ajaxurl, {
            action: 'wpcm_admin_get_models',
            make: selected_make,
            nonce: $( '#wpcm-ajax-nonce' ).val()
        }, function ( response ) {
            
            if ( undefined != response && '' != response && 0 != response && response.length > 0 ) {

                for ( var i = 0; i < response.length; i++ ) {
                    select_model.append( $( '<option>' ).val( response[ i ].id ).html( response[ i ].name ) );
                }

            }

        } );
    } );

} );