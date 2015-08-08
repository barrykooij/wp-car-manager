jQuery( function ( $ ) {
    var archive = $( '.wpcm-vehicle-listings' );
    if ( archive ) {
        new WPCM_Listings( archive );
    }
} );

var WPCM_Listings = function ( tgt ) {

    this.filters = jQuery( tgt ).find( '.wpcm-vehicle-filters:first' );
    this.listings = jQuery( tgt ).find( '.wpcm-vehicle-results-wrapper>.wpcm-vehicle-results:first' );

    // init filters
    this.init_filters();

    // always load vehicles on init for now
    this.load_vehicles();

    // todo hook into filter change - reload vehicles
};

WPCM_Listings.prototype.init_filters = function () {
    jQuery.each( this.filters.find( 'select' ), function ( k, v ) {
        jQuery( v ).select2( {
            placeholder: jQuery( v ).data( 'placeholder' ),
        } );
    } );
};

WPCM_Listings.prototype.load_vehicles = function () {

    var listings = this.listings;

    // todo load filters

    var args = {
        nonce: 'die komt nog wel'
    };

    args [ wpcm.ajax_endpoint ] = 'get_vehicles_listings';

    // todo set loading spinner

    jQuery.get( wpcm.ajax_url, args, function ( response ) {

        listings.html( response );

    } );

};