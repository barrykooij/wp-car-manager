jQuery( function ( $ ) {
	var dashboards = $( '.wpcm-dashboard' );
	if ( dashboards ) {
		$.each( dashboards, function ( k, v ) {
			new WPCM_Dashboard( v );
		} );
	}

	// setup profile
	var dashboard_profile = $( '.wpcm-dashboard-profile:first' );
	new WPCM_Dashboard_Profile( dashboard_profile );

} );

var WPCM_Dashboard_Profile = function ( wrapper ) {

	this.is_editing = false;
	this.is_updating = false;

	this.wrapper = jQuery( wrapper );
	this.fields_wrapper = this.wrapper.find( '.wpcm-dashboard-profile-fields:first' );
	this.button = jQuery( this.wrapper.find( 'h2:first a:first' ) );

	// setup
	this.init();
};

WPCM_Dashboard_Profile.prototype.init = function () {

	var instance = this;

	this.load_data();

	this.button.click( function () {
		if ( instance.is_editing ) {
			instance.save();
		} else {
			instance.edit();
		}
	} );

};

WPCM_Dashboard_Profile.prototype.load_data = function () {

	var args = {
		nonce: wpcm.nonce_get_profile
	};

	jQuery.getJSON( wpcm.ajax_url_get_profile, args, function ( response ) {

		var data = response.data;

		jQuery( '#wpcm-dashboard-profile-field-email:first' ).find( '.wpcm-dashboard-profile-value:first' ).html( data.email );
		jQuery( '#wpcm-dashboard-profile-field-phone:first' ).find( '.wpcm-dashboard-profile-value:first' ).html( data.phone );
	} );

};

WPCM_Dashboard_Profile.prototype.edit = function () {
	if ( ! this.is_editing ) {
		this.button.html( wpcm.profile_btn_save );
		this.is_editing = true;

		jQuery.each( this.fields_wrapper.find( '.wpcm-dashboard-profile-value' ), function ( k, v ) {
			var cur_val = jQuery( v ).html();
			jQuery( v ).html(
				jQuery( '<input>' ).attr( 'type', 'text' ).addClass( 'wpcm-dashboard-profile-field' ).attr( 'data-key', jQuery( v ).data( 'key' ) ).val( cur_val )
			);
		} );
	}
};

WPCM_Dashboard_Profile.prototype.save = function () {
	var instance = this;

	var profile_data = {};

	jQuery.each( this.fields_wrapper.find( '.wpcm-dashboard-profile-value' ), function ( k, v ) {
		var inp = jQuery( v ).find( 'input:first' );
		profile_data[inp.data( 'key' )] = inp.val();
	} );

	// ajax post
	jQuery.post( wpcm.ajax_url_save_profile, {
		nonce: wpcm.nonce_save_profile,
		data: profile_data
	}, function ( response ) {

		if ( response.success === false ) {
			alert( response.errors.msg );
		} else {
			instance.button.html( wpcm.profile_btn_edit );

			var data = response.data;

			jQuery( '#wpcm-dashboard-profile-field-email:first' ).find( '.wpcm-dashboard-profile-value:first' ).html( data.email );
			jQuery( '#wpcm-dashboard-profile-field-phone:first' ).find( '.wpcm-dashboard-profile-value:first' ).html( data.phone );

			instance.is_editing = false;
		}
	} );

};

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