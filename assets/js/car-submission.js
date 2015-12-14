/**
 * Only included on Car Submission form
 */
Dropzone.autoDiscover = false;
jQuery( function ( $ ) {

    // get action URL
    var $form = $( '#wpcm-car-form' );
    var action = $form.attr( 'action' );

    // setup dropzone
    $( 'div#wpcm-car-submission-images' ).dropzone( {
        url: action,
        paramName: 'wpcm_images',
        autoProcessQueue: false,
        addRemoveLinks: true,
        acceptedFiles: 'image/*'
    } );


    console.log( wpcm.ajax_url_save );

    // catch form submission
    $form.submit( function () {

        // args
        var args = {
            nonce: wpcm.nonce_save,
            vehicle_id: $form.data( 'vehicle' ),
            data: $form.serialize()
        };

        // todo add spinner

        // @todo should probably change this to post instead of get
        jQuery.post( wpcm.ajax_url_save, args, function ( response ) {

            // check response
            // on success process images

            console.log( response );

        } );

        console.log( 'Submit' );

        return false;
    } );
} );