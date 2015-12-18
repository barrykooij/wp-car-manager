/**
 * Only included on Car Submission form
 */
Dropzone.autoDiscover = false;
jQuery( function ( $ ) {

    var wpcm_submitting = false;

    $.fn.wpcm_disable = function () {
        wpcm_submitting = true;
        this.find( '#wpcm-submit' ).attr( 'disabled', 'disabled' ).addClass( 'wpcm-disabled' );
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

    // get action URL
    var $form = $( '#wpcm-car-form' );

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

        init: function () {
            var wcpm_dropzone = this;

            // processQueue on wpcm_car_saved
            $form.on( 'wpcm_car_saved', function ( event, response ) {

                // set new URL based on SaveVehicle response
                wcpm_dropzone.options.url = wpcm.ajax_url_post_images + '&vehicle=' + response.vehicle;

                // process that queue
                wcpm_dropzone.processQueue();
            } );

            // bind on queuecomplete
            this.on( 'queuecomplete', function () {
                console.log( 'queuecomplete triggerd' );

                // we're not longer submitting
                $form.wpcm_enable();
            } );

        }
    } );

    // catch form submission
    $form.submit( function () {

        // don't continue if we're already processing
        if ( wpcm_submitting ) {
            //return false;
        }

        // @todo add spinner
        // @todo disable submit
        $form.wpcm_disable();

        if ( !$form.wpcm_check_required() ) {
            $form.wpcm_enable();
            return false;
        }

        // args
        var args = {
            nonce: wpcm.nonce_save,
            vehicle_id: $form.data( 'vehicle' ),
            data: $form.serialize()
        };

        // @todo should probably change this to post instead of get
        jQuery.post( wpcm.ajax_url_save, args, function ( response ) {

            // check response
            if ( response.success ) {

                // @todo upload dem images
                $form.trigger( 'wpcm_car_saved', [ response ] );

            } else {
                if ( response.errors.length > 0 ) {
                    for ( var i = 0; i < response.errors.length; i++ ) {

                        // get element
                        var el = $( '#' + response.errors[ i ].id );

                        // mark error
                        $( el ).addClass( 'wpcm-error' );
                        $( el ).parent().append( $( '<span>' ).addClass( 'wpcm-error-desc' ).html( response.errors[ i ].msg ) );

                    }
                }

                // we're not longer submitting
                wpcm_submitting = false;
            }

            console.log( response );

        } );

        return false;
    } );
} );