jQuery( function ( $ ) {
    var dashboards = $( '.wpcm-dashboard' );
    if ( dashboards ) {
        $.each( dashboards, function ( k, v ) {
            new WPCM_Dashboard( v );
        } );
    }
} );

var WPCM_Dashboard = function ( tgt ) {

    this.is_updating = false;
    this.listings = jQuery( tgt ).find( '.wpcm-vehicle-results-wrapper>.wpcm-vehicle-results:first' );
    this.per_page = jQuery( tgt ).data( 'per_page' );

    // load vehicles
    this.load_vehicles();
};

WPCM_Dashboard.prototype.load_vehicles = function () {

    // don't do anything if we're already updating
    if ( this.is_updating == true ) {
        return;
    }

    // listings is updating
    this.is_updating = true;

    // meh
    var instance = this;

    // listings var
    var listings = this.listings;

    // default ajax args with nonce
    var args = {
        nonce: wpcm.nonce_vehicles,
        per_page: this.per_page
    };

    // add spinner
    this.listings.parent().append( jQuery( '<div>' ).addClass( 'wpcm-results-load-overlay' ) );
    this.listings.parent().append( new WPCM_Spinner().getDOM() );

    jQuery.get( wpcm.ajax_url_get_vehicles, args, function ( response ) {

        // set response
        listings.html( response );

        // remove spinner
        listings.parent().find( '.wpcm-results-load-overlay' ).remove();
        listings.parent().find( '.wpcm-results-spinner' ).remove();

        // set is_updating to false
        instance.is_updating = false;

    } );

};

var WPCM_Spinner = function () {
    this.el = jQuery( '<div>' ).addClass( 'wpcm-results-spinner' ).fadeIn( 400, WPCM_Spinner.prototype.fadeOut );

    jQuery( this.el ).bind( 'fade', function () {
        jQuery( this ).fadeOut( 'slow', function () {
            jQuery( this ).fadeIn( 'slow', function () {
                jQuery( this ).trigger( 'fade' );
            } );
        } );
    } );

    jQuery( this.el ).trigger( 'fade' );

    return this;
};

WPCM_Spinner.prototype.getDOM = function () {
    return this.el;
}