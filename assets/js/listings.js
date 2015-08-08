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

    var instance = this;

    // select 2 the select fields
    jQuery.each( this.filters.find( 'select' ), function ( k, v ) {
        jQuery( v ).select2( {
            placeholder: jQuery( v ).data( 'placeholder' ),
        } );
    } );

    // bind listener to make field
    this.filters.find( '.wpcm-filter-make select' ).change( function () {
        instance.updateModels();
    } );

    this.filters.find( '.wpcm-filter-button input' ).click( function () {
        instance.load_vehicles();
    } );

};

WPCM_Listings.prototype.updateModels = function () {

    var make_id = this.filters.find( '.wpcm-filter-make select option:selected' ).val();

    // model select input
    var select_model = this.filters.find( '.wpcm-filter-model select' );

    if ( make_id > 0 ) {
        // args
        var args = {
            nonce: 'die komt nog wel',
            make: make_id
        };

        // add endpoint
        args [ wpcm.ajax_endpoint ] = 'get_models';

        // todo set loading spinner

        jQuery.get( wpcm.ajax_url, args, function ( response ) {

            // remove current options
            select_model.attr( 'disabled', false ).find( 'option' ).remove();

            if ( undefined != response && '' != response && 0 != response && response.length > 0 ) {

                select_model.append( jQuery( '<option>' ).val( 0 ).html( select_model.data( 'placeholder' ) ) );

                for ( var i = 0; i < response.length; i++ ) {
                    select_model.append( jQuery( '<option>' ).val( response[ i ].id ).html( response[ i ].name ) );
                }
            } else {
                select_model.append( jQuery( '<option>' ).val( 0 ).html( wpcm.lbl_no_models_found ) );
            }

            // re-enable select2
            select_model.select2();

        } );
    } else {
        select_model.attr( 'disabled', true ).find( 'option' ).remove().end().append( jQuery( '<option>' ).val( 0 ).html( wpcm.lbl_select_make_first ) ).select2();
    }


};

WPCM_Listings.prototype.load_vehicles = function () {

    // listings var
    var listings = this.listings;

    // ajax args
    var args = {
        nonce: 'die komt nog wel',
    };

    // todo load filters
    var filters = [];
    jQuery.each( this.filters.find( '.wpcm-filter select' ), function ( k, v ) {
        var filter_val = jQuery( v ).find( 'option:selected' ).val();
        if ( filter_val != 0 ) {
            args[ 'filter_' + jQuery( v ).attr( 'name' ) ] = filter_val;
        }
    } );

    args [ wpcm.ajax_endpoint ] = 'get_vehicle_results';

    // todo set loading spinner

    jQuery.get( wpcm.ajax_url, args, function ( response ) {

        listings.html( response );

    } );

};