jQuery( function ( $ ) {
    $( '.nav-tab-wrapper a' ).click( function () {
        $( '.settings_panel' ).hide();
        $( '.nav-tab-active' ).removeClass( 'nav-tab-active' );
        $( $( this ).attr( 'href' ) ).show();
        $( this ).addClass( 'nav-tab-active' );

        // Set url parameter
        var href = window.location.href;
        href = href.replace( /\&tab=[a-zA-Z0-9\-_]+/g, '' );
        href = href + '&tab=' + $( this ).attr( 'href' ).replace( /\#settings-/, '' );
        window.history.replaceState( 'Object', 'Title', href );
        
        return false;
    } );
} );