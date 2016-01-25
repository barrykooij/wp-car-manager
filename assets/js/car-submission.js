/**
 * Only included on Car Submission form
 */
Dropzone.autoDiscover = false;
jQuery( function ( $ ) {

	var wpcm_submitting = false;

	$.fn.wpcm_disable = function () {
		wpcm_submitting = true;
		//this.find( '#wpcm-submit' ).attr( 'disabled', 'disabled' ).addClass( 'wpcm-disabled' ).val(wpcm.lbl_submitting);
		this.find( '#wpcm-submit' ).addClass( 'wpcm-disabled' ).val( wpcm.lbl_submitting );
		return this;
	};

	$.fn.wpcm_enable = function () {
		wpcm_submitting = false;
		this.find( '#wpcm-submit' ).removeAttr( 'disabled' ).removeClass( 'wpcm-disabled' );
		return this;
	};

	$.fn.wpcm_check_required = function () {

		var success = true;

		this.find( '.wpcm-error' ).removeClass( 'wpcm-error' );

		$.each( this.find( '.wpcm-required-field input, .wpcm-required-field textarea, .wpcm-required-field select' ), function ( k, v ) {

			// validate
			if ( '' == $( v ).val() || 0 == $( v ).val() ) {
				$( v ).addClass( 'wpcm-error' );
				success = false;
			}
		} );

		return success;
	};

	$.fn.wpcm_update_models = function () {

		var make_id = this.find( '#make option:selected' ).val();

		// model select input
		var select_model = this.find( '#model' );

		if ( make_id > 0 ) {
			// args
			var args = {
				nonce: wpcm.nonce_models,
				make: make_id
			};

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
				select_model.select2();

			} );
		} else {
			select_model.attr( 'disabled', true ).find( 'option' ).remove().end().append( jQuery( '<option>' ).val( 0 ).html( wpcm.lbl_select_make_first ) ).select2();
		}

		return this;

	};

	// get action URL
	var $form = $( '#wpcm-car-form' );

	// setup select2
	$form.find( '#make' ).select2();
	$form.find( '#model' ).select2();

	// bind listener to make field
	$form.find( '#make' ).change( function () {
		$form.wpcm_update_models();
	} );

	// setup dropzone
	$( 'div#wpcm-car-submission-images' ).dropzone( {
		url: wpcm.ajax_url_post_images,
		paramName: 'wpcm_images',
		autoProcessQueue: false,
		addRemoveLinks: true,
		uploadMultiple: true,
		parallelUploads: 20,
		maxFiles: 20,
		acceptedFiles: 'image/*',
		wpcm_response: null,

		init: function () {
			var wpcm_dropzone = this;

			// processQueue on wpcm_car_saved
			$form.on( 'wpcm_car_saved', function ( event, response ) {

				wpcm_dropzone.wpcm_response = response;

				// only process when there are images
				if ( wpcm_dropzone.getQueuedFiles().length > 0 ) {
					// set new URL based on SaveVehicle response
					wpcm_dropzone.options.url = wpcm.ajax_url_post_images + '&vehicle=' + wpcm_dropzone.wpcm_response.vehicle;

					// process that queue
					wpcm_dropzone.processQueue();
				} else {
					// no images so trigger complete event
					$form.trigger( 'wpcm_image_queue_complete', [wpcm_dropzone.wpcm_response] );
				}

			} );

			// trigger wpcm_image_queue_complete on queuecomplete
			this.on( 'queuecomplete', function () {
				$form.trigger( 'wpcm_image_queue_complete', [wpcm_dropzone.wpcm_response] );
			} );

		}
	} );

	$form.bind( 'wpcm_image_queue_complete', function ( event, response ) {
		// redirect user to success URL
		if ( 'undefined' !== typeof response.url ) {
			window.location = response.url;
		}
	} );

	// catch form submission
	$form.submit( function () {

		// don't continue if we're already processing
		if ( wpcm_submitting ) {
			return false;
		}

		// @todo add spinner
		// @todo disable submit
		$form.wpcm_disable();

		if ( ! $form.wpcm_check_required() ) {
			$form.wpcm_enable();
			return false;
		}

		// args
		var args = {
			nonce: wpcm.nonce_save,
			vehicle_id: $form.data( 'vehicle' ),
			data: $form.serialize()
		};

		// post data
		jQuery.post( wpcm.ajax_url_save, args, function ( response ) {

			// check response
			if ( response.success ) {

				// wpcm_car_saved event, uploading car images binds on this
				$form.trigger( 'wpcm_car_saved', [response] );

			} else {
				if ( response.errors.length > 0 ) {
					for ( var i = 0; i < response.errors.length; i ++ ) {

						// get element
						var el = $( '#' + response.errors[i].id );

						if ( el ) {
							// mark error
							$( el ).addClass( 'wpcm-error' );
							$( el ).parent().append( $( '<span>' ).addClass( 'wpcm-error-desc' ).html( response.errors[i].msg ) );
						} else {
							// @todo add generic message because this is not an element specific issue
						}


					}
				}

				// we're not longer submitting
				wpcm_submitting = false;
			}

		} );

		return false;
	} );
} );