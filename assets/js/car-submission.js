/**
 * Only included on Car Submission form
 */
Dropzone.autoDiscover = false;
jQuery( function ( $ ) {

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
            } );

        }
    } );

    // catch form submission
    $form.submit( function () {

        // testing
        $form.trigger( 'wpcm_car_saved', [ { vehicle: 170 } ] );
        return false;

        // args
        var args = {
            nonce: wpcm.nonce_save,
            vehicle_id: $form.data( 'vehicle' ),
            data: $form.serialize()
        };

        // @todo add spinner
        // @todo disable submit

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
            }

            console.log( response );

        } );

        return false;
    } );
} );