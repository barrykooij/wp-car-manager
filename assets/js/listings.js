jQuery( function ( $ ) {
	var archives = $( '.wpcm-vehicle-listings' );
	if ( archives ) {
		$.each( archives, function ( k, v ) {
			new WPCM_Listings( v );
		} );
	}
} );

var WPCM_Listings = function ( tgt ) {

	this.is_updating = false;
	this.nonce = jQuery( tgt ).find( '#wpcm-listings-nonce' ).val();
	this.filters = jQuery( tgt ).find( '.wpcm-vehicle-filters:first' );
	this.sort = jQuery( tgt ).find( '#wpcm-sort:first' );
	this.listings = jQuery( tgt ).find( '.wpcm-vehicle-results-wrapper>.wpcm-vehicle-results:first' );
	this.pagination = jQuery( tgt ).find( '.wpcm-vehicle-listings-pagination:first' );
	this.page = 1;
	this.default_sort = jQuery( tgt ).data( 'sort' );
	this.condition = jQuery( tgt ).data( 'condition' );

	this.locked_make = 0;
	if ( jQuery( tgt ).data( 'make_id' ) ) {
		this.locked_make = jQuery( tgt ).data( 'make_id' );
	}

	// init filters
	this.init_filters();

	// init sort
	if ( this.sort.length > 0 ) {
		this.init_sort();
	}

	// always try to initially load models
	this.updateModels();

	// always load vehicles on init for now
	this.load_vehicles();
};

WPCM_Listings.prototype.init_filters = function () {

	var instance = this;

	// select 2 the select fields
	jQuery.each( this.filters.find( 'select' ), function ( k, v ) {
		jQuery( v ).select2( {
			placeholder: jQuery( v ).data( 'placeholder' ),
			width: 'resolve'
		} );
	} );

	// bind listener to make field
	this.filters.find( '.wpcm-filter-make select' ).change( function () {
		instance.updateModels();
	} );

	this.filters.find( '.wpcm-filter-button input' ).click( function () {

		// reset page to 1 on sort change
		instance.page = 1;

		// load
		instance.load_vehicles();
	} );

};

WPCM_Listings.prototype.init_sort = function () {

	var instance = this;

	// bind listener to make field
	this.sort.change( function () {

		// reset page to 1 on sort change
		instance.page = 1;

		// load
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
			nonce: wpcm.nonce_models,
			make: make_id
		};

		// todo add spinner

		jQuery.get( wpcm.ajax_url_get_models, args, function ( response ) {

			// remove current options
			select_model.attr( 'disabled', false ).find( 'option' ).remove();

			if ( undefined != response && '' != response && 0 != response && response.length > 0 ) {

				select_model.append( jQuery( '<option>' ).val( 0 ).html( select_model.data( 'placeholder' ) ) );

				for ( var i = 0; i < response.length; i ++ ) {
					select_model.append( jQuery( '<option>' ).val( response[i].id ).html( response[i].name ) );
				}
			} else {
				select_model.append( jQuery( '<option>' ).val( 0 ).html( wpcm.lbl_no_models_found ) );
			}

			// re-enable select2
			select_model.select2( {width: 'resolve'} );

		} );
	} else {
		select_model.attr( 'disabled', true ).find( 'option' ).remove().end().append( jQuery( '<option>' ).val( 0 ).html( wpcm.lbl_select_make_first ) ).select2( {width: 'resolve'} );
	}

};

WPCM_Listings.prototype.load_vehicles = function () {

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

	// pagination var
	var pagination = this.pagination;

	// default ajax args with nonce
	var args = {
		nonce: this.nonce,
		page: this.page
	};

	// set filters in args
	var filters = [];
	jQuery.each( this.filters.find( '.wpcm-filter select' ), function ( k, v ) {
		var filter_val = jQuery( v ).find( 'option:selected' ).val();
		if ( filter_val != 0 ) {
			args['filter_' + jQuery( v ).attr( 'name' )] = filter_val;
		}
	} );

	// if make is locked, it's locked
	if ( this.locked_make > 0 ) {
		args['filter_make'] = this.locked_make;
	}

	// set sort in args
	if ( this.sort.length > 0 ) {
		args['sort'] = this.sort.find( 'option:selected' ).val();
	} else {
		args['sort'] = this.default_sort;
	}

	if ( '' != this.condition ) {
		args['filter_condition'] = this.condition;
	}

	// add spinner
	this.listings.parent().append( jQuery( '<div>' ).addClass( 'wpcm-results-load-overlay' ) );
	this.listings.parent().append( new WPCM_Spinner().getDOM() );

	jQuery.getJSON( wpcm.ajax_url_get_vehicles, args, function ( response ) {

		// set listings
		if ( response.listings ) {
			// set response
			listings.html( response.listings );
		}

		// set pagination
		if ( response.pagination ) {
			pagination.html( response.pagination );

			instance.bind_pagination();
		} else {
			pagination.html( '' );
		}

		// remove spinner
		listings.parent().find( '.wpcm-results-load-overlay' ).remove();
		listings.parent().find( '.wpcm-results-spinner' ).remove();

		// set is_updating to false
		instance.is_updating = false;

	} );

};

WPCM_Listings.prototype.bind_pagination = function () {
	var instance = this;

	jQuery.each( jQuery( this.pagination ).find( 'a' ), function ( k, v ) {
		jQuery( v ).click( function () {
			var new_page = jQuery( v ).data( 'page' );

			if ( new_page == 'next' ) {
				new_page = instance.page + 1;
			}

			if ( new_page == 'prev' ) {
				new_page = instance.page - 1;
			}

			// set new page
			instance.page = new_page;

			// trigger load_vehicles()
			instance.load_vehicles();

		} );
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