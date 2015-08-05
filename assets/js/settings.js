jQuery( function ( $ ) {
    $( '.nav-tab-wrapper a' ).click( function () {
        $( '.settings_panel' ).hide();
        $( '.nav-tab-active' ).removeClass( 'nav-tab-active' );
        $( $( this ).attr( 'href' ) ).show();
        $( this ).addClass( 'nav-tab-active' );
        return false;
    } );
    $( '.nav-tab-wrapper a:first' ).click();
} );