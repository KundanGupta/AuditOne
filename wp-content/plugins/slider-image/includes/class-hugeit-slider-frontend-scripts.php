<?php

class Hugeit_Slider_Frontend_Scripts {

	public function __construct() {
		add_action('hugeit_slider_before_shortcode', array($this, 'enqueue_scripts'));
		add_action('hugeit_slider_before_shortcode', array($this, 'enqueue_styles'));
		add_action('hugeit_slider_before_shortcode', array($this, 'localize_script'));
		add_action('hugeit_slider_before_shortcode', array(get_class(), 'localize_single_slider_params'));
	}

	public function enqueue_scripts() {
		wp_enqueue_script('hugeit_slider_frontend_froogaloop', HUGEIT_SLIDER_SCRIPTS_URL . '/froogaloop2.min.js', array('jquery'), false, true);
		wp_enqueue_script('hugeit_slider_frontend_main', HUGEIT_SLIDER_SCRIPTS_URL . '/main.js', array('jquery'), false, true);
	}

	public function localize_script() {
		$slider_options = array(
			'crop_image' => Hugeit_Slider_Options::get_crop_image(),
			'slider_background_color' => Hugeit_Slider_Options::get_slider_background_color(),
			'slideshow_border_size' => Hugeit_Slider_Options::get_slideshow_border_size(),
			'slideshow_border_color' => Hugeit_Slider_Options::get_slideshow_border_color(),
			'slideshow_border_radius' => Hugeit_Slider_Options::get_slideshow_border_radius(),
			'loading_icon_type' => Hugeit_Slider_Options::get_loading_icon_type(),
			'title_width' => Hugeit_Slider_Options::get_title_width(),
			'title_has_margin' => Hugeit_Slider_Options::get_title_has_margin(),
			'title_font_size' => Hugeit_Slider_Options::get_title_font_size(),
			'title_color' => Hugeit_Slider_Options::get_title_color(),
			'title_text_align' => Hugeit_Slider_Options::get_title_text_align(),
			'title_background_transparency' => Hugeit_Slider_Options::get_title_background_transparency(),
			'title_background_color' => Hugeit_Slider_Options::get_title_background_color(),
			'title_border_size' => Hugeit_Slider_Options::get_title_border_size(),
			'title_border_color' => Hugeit_Slider_Options::get_title_border_color(),
			'title_border_radius' => Hugeit_Slider_Options::get_title_border_radius(),
			'title_position' => Hugeit_Slider_Options::get_title_position(),
			'description_width' => Hugeit_Slider_Options::get_description_width(),
			'description_has_margin' => Hugeit_Slider_Options::get_description_has_margin(),
			'description_font_size' => Hugeit_Slider_Options::get_description_font_size(),
			'description_color' => Hugeit_Slider_Options::get_description_color(),
			'description_text_align' => Hugeit_Slider_Options::get_description_text_align(),
			'description_background_transparency' => Hugeit_Slider_Options::get_description_background_transparency(),
			'description_background_color' => Hugeit_Slider_Options::get_description_background_color(),
			'description_border_size' => Hugeit_Slider_Options::get_description_border_size(),
			'description_border_color' => Hugeit_Slider_Options::get_description_border_color(),
			'description_border_radius' => Hugeit_Slider_Options::get_description_border_radius(),
			'description_position' => Hugeit_Slider_Options::get_description_position(),
			'navigation_position' => Hugeit_Slider_Options::get_navigation_position(),
			'dots_color' => Hugeit_Slider_Options::get_dots_color(),
			'active_dot_color' => Hugeit_Slider_Options::get_active_dot_color(),
			'show_arrows' => Hugeit_Slider_Options::get_show_arrows(),
			'thumb_count_slides' => Hugeit_Slider_Options::get_thumb_count_slides(),
			'thumb_height' => Hugeit_Slider_Options::get_thumb_height(),
			'thumb_background_color' => Hugeit_Slider_Options::get_thumb_background_color(),
			'thumb_passive_color' => Hugeit_Slider_Options::get_thumb_passive_color(),
			'thumb_passive_color_transparency' => Hugeit_Slider_Options::get_thumb_passive_color_transparency(),
			'navigation_type' => Hugeit_Slider_Options::get_navigation_type()
		);
		wp_localize_script('hugeit_slider_frontend_main', 'hugeitSliderUrl', HUGEIT_SLIDER_FRONT_IMAGES_URL);
		wp_localize_script('hugeit_slider_frontend_main', 'hugeitSliderObj', $slider_options);
	}

	public static function localize_single_slider_params( $id ) {
		try {
			$slider = new Hugeit_Slider_Slider($id);
		} catch (Exception $e) {

		}

		if (isset($slider) && $slider instanceof Hugeit_Slider_Slider) {
			wp_localize_script('hugeit_slider_frontend_main', 'singleSlider_' . $slider->get_id(), array(
				'width' => $slider->get_width(),
				'height' => $slider->get_height(),
				'pause_on_hover' => $slider->get_pause_on_hover(),
				'navigate_by' => $slider->get_navigate_by(),
				'pause_time' => $slider->get_pause_time(),
				'change_speed' => $slider->get_change_speed(),
				'effect' => $slider->get_effect()
			));
		}
	}

	public function enqueue_styles() {
	}
}
