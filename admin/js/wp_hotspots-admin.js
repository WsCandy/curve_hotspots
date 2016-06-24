(function($) {

	'use strict';

	var Upload = function(meta) {

		this.frame = null;
		this.meta = meta;
		this.addButton = this.meta.find('.hotspot__add');
		this.deleteButton = this.meta.find('.hotspot__delete');
		this.imageContainer = this.meta.find('.hotspot__image');

		this.bindings();

	};

	Upload.prototype.bindings = function() {

		var self = this;

		this.addButton.on('click', function(e) {

			typeof e !== 'undefined' ? e.preventDefault() : e;

			self.addMedia();

		});

	};

	Upload.prototype.addMedia = function() {

		var self = this;

		if(self.frame) {

			this.frame.open();
			return;

		}

		self.frame = wp.media({

			title: 'Select Image',
			button: {

				text: 'Select'

			},
			multiple: false
		});

		self.frame.on('select', function() {

			var attachment = self.frame.state().get('selection').first().toJSON();

			self.imageContainer.append('<img src="' + attachment.url + '" alt="" style="max-width:100%;"/>');

			// imgIdInput.val( attachment.id );

			self.addButton.parent().addClass('hidden');
			self.deleteButton.removeClass('hidden');

		});

		this.frame.open();

	};

	Upload.prototype.deleteMedia = function() {

	};

	$(function() {

		var media = new Upload($('.hotspot__background'));

		// // DELETE IMAGE LINK
		// delImgLink.on( 'click', function( event ){
		//
		//  event.preventDefault();
		//
		//  // Clear out the preview image
		//  imgContainer.html( '' );
		//
		//  // Un-hide the add image link
		//  addImgLink.removeClass( 'hidden' );
		//
		//  // Hide the delete image link
		//  delImgLink.addClass( 'hidden' );
		//
		//  // Delete the image id from the hidden input
		//  imgIdInput.val( '' );
		//
		// });

	});

})(jQuery);
