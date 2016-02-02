jQuery( function ( $ ) {

    // make - model select
    $( 'select#make' ).change( function () {
        var selected_make = $( this ).find( 'option:selected' ).val();
        var select_model = $( 'select#model' );
        select_model.find( 'option' ).remove().end().append( $( '<option>' ).val( 0 ).html( 'Select Model' ) );
        // @todo display loading icon
        jQuery.post( ajaxurl, {
            action: 'wpcm_admin_get_models',
            make: selected_make,
            nonce: $( '#wpcm-ajax-nonce' ).val()
        }, function ( response ) {

            if ( undefined != response && '' != response && 0 != response && response.length > 0 ) {

                for ( var i = 0; i < response.length; i++ ) {
                    select_model.append( $( '<option>' ).val( response[ i ].id ).html( response[ i ].name ) );
                }

            }

        } );
    } );

    $( '.wpcm-date-field' ).datepicker( {
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    } );

    // car gallery file uploads
    var car_gallery_frame;
    var $image_gallery_ids = $( '#car_gallery' );
    var $car_images = $( '#car_images_container ul.car_images' );

    jQuery( '.add_car_images' ).on( 'click', 'a', function ( event ) {
        var $el = $( this );

        event.preventDefault();

        // If the media frame already exists, reopen it.
        if ( car_gallery_frame ) {
            car_gallery_frame.open();
            return;
        }

        // Create the media frame.
        car_gallery_frame = wp.media.frames.car_gallery = wp.media( {
            // Set the title of the modal.
            title: $el.data( 'choose' ),
            button: {
                text: $el.data( 'update' )
            },
            states: [
                new wp.media.controller.Library( {
                    title: $el.data( 'choose' ),
                    filterable: 'all',
                    multiple: true
                } )
            ]
        } );

        // When an image is selected, run a callback.
        car_gallery_frame.on( 'select', function () {
            var selection = car_gallery_frame.state().get( 'selection' );
            var attachment_ids = $image_gallery_ids.val();

            selection.map( function ( attachment ) {
                attachment = attachment.toJSON();

                if ( attachment.id ) {
                    attachment_ids = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
                    var attachment_image = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

                    $car_images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data( 'delete' ) + '">' + $el.data( 'text' ) + '</a></li></ul></li>' );
                }

            } );

            $image_gallery_ids.val( attachment_ids );
        } );

        // Finally, open the modal.
        car_gallery_frame.open();
    } );

    // Image ordering
    $car_images.sortable( {
        items: 'li.image',
        cursor: 'move',
        scrollSensitivity: 40,
        placeholder : 'wpcm-sortable-placeholder',
        forcePlaceholderSize: true,
        forceHelperSize: false,
        helper: 'clone',
        opacity: 0.65,
        start: function ( event, ui ) {
            ui.item.css( 'background-color', '#f6f6f6' );
        },
        stop: function ( event, ui ) {
            ui.item.removeAttr( 'style' );
        },
        update: function () {
            var attachment_ids = '';

            $( '#car_images_container ul li.image' ).css( 'cursor', 'default' ).each( function () {
                var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
                attachment_ids = attachment_ids + attachment_id + ',';
            } );

            $image_gallery_ids.val( attachment_ids );
        }
    } );

    // Remove images
    $( '#car_images_container' ).on( 'click', 'a.delete', function () {
        $( this ).closest( 'li.image' ).remove();

        var attachment_ids = '';

        $( '#car_images_container ul li.image' ).css( 'cursor', 'default' ).each( function () {
            var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
            attachment_ids = attachment_ids + attachment_id + ',';
        } );

        $image_gallery_ids.val( attachment_ids );

        // remove any lingering tooltips
        $( '#tiptip_holder' ).removeAttr( 'style' );
        $( '#tiptip_arrow' ).removeAttr( 'style' );

        return false;
    } );

} );