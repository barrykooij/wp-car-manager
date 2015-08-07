jQuery( function ( $ ) {
    var archive = $( '.wpcm-vehicle-archive' );
    if ( archive ) {
        new WPCM_Listings( archive );
    }
} );

var WPCM_Listings = function ( tgt ) {

    this.filters = jQuery( tgt ).find( '.wpcm-vehicle-filters:first' );
    this.listings = jQuery( tgt ).find( '.wpcm-vehicle-listings-wrapper>.wpcm-vehicle-listings:first' );

    console.log( this.filters );
    console.log( this.listings );

    // always load vehicles on init for now
    this.load_vehicles();

    // todo hook into filter change - reload vehicles
};

WPCM_Listings.prototype.load_vehicles = function () {

    var listings = this.listings;

    // todo load filters

    var endpoint = wpcm.endpoint;

    var args = {
        nonce: 'die komt nog wel'
    };

    args [ wpcm.ajax_endpoint ] = 'get_vehicles_listings';

    jQuery.get( wpcm.ajax_url, args, function ( response ) {

        listings.html( response );

    } );

};