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
	this.listings = jQuery( tgt ).find( '.wpcm-dashboard-wrapper>.wpcm-dashboard-list:first' );
	this.pagination = jQuery( tgt ).find( '.wpcm-dashboard-pagination:first' );
	this.page = 1;

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

	// pagination var
	var pagination = this.pagination;

	// default ajax args with nonce
	var args = {
		nonce: wpcm.nonce_vehicles,
		page: this.page
	};

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

		// bind delete buttons
		jQuery( listings ).find( '.wpcm-dashboard-item .wpcm-dashboard-item-actions a.wpcm-dashboard-delete-button' ).click( function () {
			instance.deleteVehicle( jQuery( this ).closest( '.wpcm-dashboard-item' ) );
			return false;
		} );

		// set is_updating to false
		instance.is_updating = false;

	} );

};

WPCM_Dashboard.prototype.bind_pagination = function () {
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

WPCM_Dashboard.prototype.deleteVehicle = function ( row ) {

	var vehicle_id = row.data( 'id' );
	var vehicle_title = row.data( 'title' );

	// confirm delete
	var justchecking = confirm( wpcm.delete_confirm.replace( '%s', '"' + vehicle_title + '"' ) );

	if ( justchecking ) {

		// ajax post
		jQuery.post( wpcm.ajax_url_delete_vehicle, {
			nonce: wpcm.nonce_delete_vehicle,
			vehicle: vehicle_id
		}, function ( response ) {

			if ( response.success ) {
				row.fadeOut( 'normal', function () {
					row.remove();
				} );
			} else {
				alert( wpcm.error_delete_vehicle );
			}

		} );


	}
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
};