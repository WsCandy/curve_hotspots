(function($) {

	'use strict';

	var Upload = function(data) {

		this.frame = null;
		this.meta = data.meta;
		this.field = data.field;
		this.addButton = this.meta.find('.hotspot__image__add');
		this.deleteButton = this.meta.find('.hotspot__image__delete');
		this.imageContainer = this.meta.find('.hotspot__image');
		this.hasImage = this.field.val() ? true : false;

		this.bindings();

	};

	Upload.prototype.bindings = function() {

		var self = this;

		this.addButton.on('click', function(e) {

			typeof e !== 'undefined' ? e.preventDefault() : e;

			self.addMedia();

		});

		this.deleteButton.on('click', function(e) {

			typeof e !== 'undefined' ? e.preventDefault() : e;

			self.deleteMedia();

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

			self.imageContainer.find('.hotspot__bg').remove();
			self.imageContainer.append('<img src="' + attachment.url + '" class="hotspot__bg" />');
			self.field.val( attachment.id );
			self.addButton.addClass('button-primary').text('Replace Image');
			self.deleteButton.removeClass('hidden');

			self.hasImage = true;

		});

		this.frame.open();

	};

	Upload.prototype.deleteMedia = function() {

		this.imageContainer.find('.hotspot__bg').remove();
		this.addButton.removeClass('button-primary').text('Add Image');
		this.deleteButton.addClass('hidden');
		this.field.val('');

		this.hasImage = false;

	};

	var Hotspots = function(data) {

		this.hotspots = {};
		this.container = data.container;
		this.total = data.container.find('.hotspot__point').length;
		this.addButton = data.container.find('.hotspot__add');

		this.index();

		this.bindings();

	};

	Hotspots.prototype.bindings = function() {

		var self = this;

		this.addButton.on('click', function(e) {

			typeof e !== 'undefined' ? e.preventDefault() : null;

			self.add();

		});

	};

	Hotspots.prototype.index = function() {

		var currentSpots = this.container.find('.hotspot__point');

		this.total = currentSpots.length;

		for(var i = 0; i < currentSpots.length; i++) {

			var id = $(currentSpots[i]).attr('data-id');

			this.hotspots[id] = $(currentSpots);
			this.bind($(currentSpots[i]));

		}

	};

	Hotspots.prototype.add = function() {

		this.total +=1;

		console.log(this.total);

		for(var i = 1; i < (this.total + 1); i++) {

			if(this.hotspots[i]) {

				continue;

			}

			var top = Math.round((Math.random() * 100) * 100) / 100,
				left = Math.round((Math.random() * 100) * 100) / 100;

			var inputX = $('<input />', {

				'type' : 'hidden',
				'name' : 'hotspots['+i+'][x]',
				'value' : left

			});

			var inputY = $('<input />', {

				'type' : 'hidden',
				'name' : 'hotspots['+i+'][y]',
				'value' : top

			});

			var point = $('<a />', {

				'class' : 'hotspot__point',
				'data-id' : i

			});

			point.css({

				top: top + '%',
				left: left + '%'

			}).text(i);

			point.appendTo(this.container);
			inputX.appendTo(point);
			inputY.appendTo(point);

			this.hotspots[i] = point;

			this.bind(point);

			break;

		}

	};

	Hotspots.prototype.bind = function(hotspot) {

		var self = this;

		hotspot.on('click', function(e) {

			typeof e !== 'undefined' ? e.preventDefault() : null;

			$(this).remove();

			self.delete($(this).attr('data-id'));

		});

	};
	
	Hotspots.prototype.delete = function(id) {

		this.total--;
		this.hotspots[id] = null;

	};

	$(function() {

		var mainBg = new Upload({

			meta: $('.hotspot__background'),
			field : $('#hotspot_bg')

		});

		var mainHotspots = new Hotspots({

			container: $('.hotspot__image')

		});

	});

})(jQuery);
