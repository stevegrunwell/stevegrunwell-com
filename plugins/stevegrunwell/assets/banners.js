/*!*
 * Scripting for the Banners meta box.
 */

( function( $ ) {
	'use strict';

	var $metabox = $( '.grunwell-image-input' ),
		mediaUploader,

		/**
		 * Callback when media is selected in the modal.
		 *
		 * @returns {void}
		 */
		mediaSelected = function() {
			var attachment = mediaUploader.state().get( 'selection' ).first().toJSON(),
				img = $( '<img />', {
					src: attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url
				} );

			$metabox.find( '.image-id' ).val( attachment.id );
			$metabox.find( '.image-div' ).html( img );
			$metabox.addClass( 'has-image' );
		},

		/**
		 * Open the media modal for an inline image selector.
		 * @param {object} e - The event that triggered the modal to open.
		 * @returns {void}
		 */
		openMediaModal = function( e ) {
			e.preventDefault();

			if ( mediaUploader ) {
				mediaUploader.open();
				return;
			}

			mediaUploader = wp.media.frames.grunwellFileFrame = wp.media( {
				title: 'Choose Image',
				button: {
					text: 'Choose Image',
				},
				multiple: false
			} ).on( 'select', mediaSelected );

			// Open the mediaUploader modal.
			mediaUploader.open();
		},

		/**
		 * Remove an image from the current image input.
		 * @param {object} e - The event that's causing the modal to close.
		 * @returns {void}
		 */
		removeImage = function( e ) {
			e.preventDefault();

			$metabox.find( '.image-id' ).val( '' );
			$metabox.removeClass( 'has-image' );
		};

	// Register event handlers.
	$metabox
		.on( 'click', '.image-controls .new', openMediaModal )
		.on( 'click', '.image-remove', removeImage );

} )( jQuery );
