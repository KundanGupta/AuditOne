jQuery(document).ready(function() {
	jQuery('#arrows-type input[name="params[navigation_type]"]').on('change', function() {
		jQuery(this).closest('ul').find('li.active').removeClass('active');
		jQuery(this).closest('li').addClass('active');
	});
	jQuery('#slider-loading-icon li').click(function() { //alert(jQuery(this).find("input:checked").val());
		jQuery(this).parents('ul').find('li.act').removeClass('act');
		jQuery(this).addClass('act');
	});

	jQuery('input[data-slider="true"]').bind("slider:changed", function(event, data) {
		jQuery(this).parent().find('span').html(parseInt(data.value) + "%");
		jQuery(this).val(parseInt(data.value));
	});

	jQuery('.help').hover(function() {
		jQuery(this).parent().find('.help-block').removeClass('active');
		var width = jQuery(this).parent().find('.help-block').outerWidth();
		jQuery(this).parent().find('.help-block').addClass('active').css({'left': -((width / 2) - 10)});
	}, function() {
		jQuery(this).parent().find('.help-block').removeClass('active');
	});

	jQuery('.hugeit_slider_delete_slider').on('click', function() {
		var r = confirm(hugeitSliderObject.removeSliderConfirm);

		if (!r) {
			return false;
		}

		var sliderId = jQuery(this).data('slider-id'),
			nonce = jQuery(this).data('nonce');

		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'hugeit_slider_delete_slider',
				id: sliderId,
				nonce: nonce
			}
		}).done(function(response) {
			if (response.success) {
				location.reload(true);

				var h2 = jQuery('#sliders-list-page').find('h2');
				jQuery('<div class="updated"><p><strong>' + hugeitSliderObject.itemDeleted + '</strong></p></div>').insertAfter(h2)
			}
		});
	});

	jQuery('#reset').on('click', function() {
		location.reload();
	});

	jQuery('#adminForm').find('#sliders-list li.active').on('click', function() {
		this.firstElementChild.style.width = ((this.firstElementChild.value.length + 1) * 8) + 'px';
	});

	jQuery('#adminForm').find('#sliders-list li.active input.text_area').on('focus', function() {
		this.style.width = ((this.value.length + 1) * 8) + 'px'
	});

	jQuery('#hugeit_slider_add_image_slide_button').on('click', function() {
		var frame = wp.media({
			title: hugeitSliderObject.addImageSliderPopupTitle,
			button: {
				text: hugeitSliderObject.insertImageButtonText,
			},
			multiple: true
		}).on('select', function() {
			var attachments = frame.state().get('selection').toJSON(),
				sliderId = jQuery('#sliders-list').find('li.active').data('slider-id');

			jQuery.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'JSON',
				data: {
					slider_id: sliderId,
					action: 'hugeit_slider_get_slide_html',
					type: 'image',
					attachments: attachments
				}
			}).done(function(response) {
				if (response === false) {
					return false;
				}

				var list = jQuery('#slides-list');

				jQuery(response).each(function(i, res) {
					if (res.success) {
						list.prepend('<li data-type="image" class="slider-cell ui-sortable-handle" data-slide-id="' + res.id + '">' + res.html + '</li>');
					}
				});

				setSlidesOrder();
			});
		}).open();
	});

	jQuery('#slides-list').sortable({
		revert: true,
		cursor: 'move',
		axis : 'y',
		opacity: 0.6,
		stop: setSlidesOrder,
		cancel: 'li.slider-cell span,input,textarea,button,select,option',
	});

	jQuery('#adminForm').on('submit', function() {
		setSlidesOrder();

		var sliderId = jQuery('#sliders-list').find('li.active').data('slider-id'),
			nonce = jQuery(this).find('input:submit').data('nonce'),
			spinner = jQuery('#hugeit_slider_save_slider_spinner'),
			saveButton = jQuery(this).find('#save-buttom'),
			slider,
			slides = [],
			ajaxData;

		spinner.css('visibility', 'visible');
		saveButton.prop('disabled', true);

		slider = {
			name: jQuery('#adminForm').find('#sliders-list li.active input#name').val(),
			width: jQuery('#slider-options').find('#width').val(),
			height: jQuery('#slider-options').find('#height').val(),
			effect: jQuery('#slider-options').find('#effect').val(),
			pause_time: jQuery('#slider-options').find('#pause_time').val(),
			change_speed: jQuery('#slider-options').find('#change_speed').val(),
			position: jQuery('#slider-options').find('#position').val(),
			show_loading_icon: jQuery('#slider-options').find('#show_loading_icon').val(),
			navigate_by: jQuery('#slider-options').find('#navigate_by').val(),
			pause_on_hover: jQuery('#slider-options').find('#pause_on_hover').prop('checked') ? 1 : 0,
			random: jQuery('#slider-options').find('#random').prop('checked') ? 1 : 0,
		};

		jQuery.each(jQuery('#slides-list > li'), function(i, li) {
			var $li = jQuery(li),
				order = $li.data('order'),
				type = $li.data('type');

			switch (type) {
				case 'image' :
					slides[order] = {
						id: $li.data('slide-id'),
						title: $li.find('input.title').val(),
						description: $li.find('textarea.description').val(),
						url: $li.find('input.url').val(),
						in_new_tab: $li.find('input.in-new-tab').prop('checked') ? 1 : 0,
						attachment_id: $li.find('input.attachment-id').val(),
						order: $li.data('order'),
					};

					break;
			}
		});

		ajaxData = {
			action: 'hugeit_slider_save_slider',
			slider_id: sliderId,
			slider: slider,
			slides: slides,
			nonce: nonce,
		};

		var resultSection = jQuery('#adminForm').find('#post-body .save-result'),
			p = resultSection.find('p.message');

		jQuery.ajax({
			url: ajaxurl,
			dataType: 'JSON',
			type: 'POST',
			data: ajaxData,
		}).done(function(res) {
			if (res.hasOwnProperty('success') && res.success !== 0) {
				p.text(hugeitSliderObject.sliderSuccessfullySaved);
			} else {
				p.text(hugeitSliderObject.sliderSaveFail);
			}
		}).fail(function() {
			p.text(hugeitSliderObject.sliderSaveFail);
		}).always(function() {
			resultSection.show();
			spinner.css('visibility', 'hidden');
			saveButton.prop('disabled', false);

			setTimeout(function() {
				resultSection.hide();
				p.text('');
			}, 3000);
		});

		return false;
	});

	jQuery('body').on('click', 'a.remove-image', function(e) {
		e.preventDefault();

		var r = confirm(hugeitSliderObject.removeSlideConfirm);

		if (!r) {
			return false;
		}

		jQuery(this).closest('li').remove();
		setSlidesOrder();
	});

	jQuery('#slides-list .edit').on('click', function(e) {
		e.preventDefault();

		var $li = jQuery(this).closest('li'),
			frame = wp.media({
			title: hugeitSliderObject.addImageSliderPopupTitle,
			button: {
				text: hugeitSliderObject.insertImageButtonText
			},
			multiple: false
		}).on('select', function() {
			var attachment = frame.state().get('selection').first().toJSON(),
				sliderId = jQuery('#sliders-list').find('li.active').data('slider-id');

			$li.find('input.attachment-id').val(attachment.id);
			$li.find('img.slide-thumbnail').attr('src', attachment.url);
		}).open();
	});

	jQuery('#hugeit_slider_add_post_popup_tabs').tabs();

	jQuery('form#sliders').find('a.hugeit_slider_duplicate_slider').on('click', function() {
		var id = jQuery(this).data('slider-id'),
			nonce = jQuery(this).data('nonce');

		jQuery.ajax({
			url: ajaxurl,
			dataType: 'JSON',
			type: 'POST',
			data: {
				action: 'hugeit_slider_duplicate_slider',
				id: id,
				nonce: nonce,
			}
		}).done(function(res) {
			if (res.success) {
				window.location.reload();
			}
		});
	});

	jQuery('body').on('mouseover', '#slides-list li[data-type=image] div.centering > img', function() {
		if (!jQuery('#enable_preview_on_hover').prop('checked')) {
			return false;
		}
		jQuery('#zoomed-image-section').find('img').attr('src', jQuery(this).attr('src'));
		jQuery('#zoomed-image-section').fadeIn();
	}).on('mouseleave', '#slides-list li[data-type=image] div.centering > img', function() {
		if (!jQuery('#enable_preview_on_hover').prop('checked')) {
			return false;
		}
		jQuery('#zoomed-image-section').fadeOut();
	});
});

function isYoutubeURL(url) {
	var youtubeRegExp = /^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/;

	return youtubeRegExp.test(url);
}

function isVimeoURL(url) {
	var vimeoRegExp = /https:\/\/vimeo.com\/\d{8,12}(?=\b|\/)/;

	return vimeoRegExp.test(url);
}

function setSlidesOrder() {
	jQuery('#slides-list > li').each(function(i, li) {
		jQuery(li).attr('data-order', i);
	});
}
