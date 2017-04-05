<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Hugeit_Slider_Install {

	/**
	 * If plugin tables are created will be true, and default rows will be inserted, tables exist nothing will happen.
	 *
	 * @var bool
	 */
	public static function init() {
		if (Hugeit_Slider()->get_version() !== get_option('hugeit_slider_version')) {
			global $wpdb;

			$hugeit_slider_slider_exists = $wpdb->get_row("SELECT * FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "' AND table_name = '" . $wpdb->prefix . "hugeit_slider_slider' LIMIT 1;", ARRAY_A);
			$hugeit_slider_slide_exists = $wpdb->get_row("SELECT * FROM information_schema.tables WHERE table_schema = '" . DB_NAME . "' AND table_name = '" . $wpdb->prefix . "hugeit_slider_slide' LIMIT 1;", ARRAY_A);

			$new_tables_does_not_exist = empty($hugeit_slider_slider_exists) || empty($hugeit_slider_slide_exists);

			if ($new_tables_does_not_exist) {
				self::install();
			}

			update_option('hugeit_slider_version', Hugeit_Slider()->get_version());
		}
	}
	
	private static function install() {
		self::create_tables();

		global $wpdb;

		$old_tables_exists = $wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . 'huge_itslider_sliders"') && $wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . 'huge_itslider_images"');

		if ($old_tables_exists) {
			Hugeit_Slider_Migrate::migrate();

			$wpdb->query('ALTER TABLE ' . $wpdb->prefix . 'huge_itslider_sliders RENAME ' . $wpdb->prefix . 'huge_itslider_sliders_backup');
			$wpdb->query('ALTER TABLE ' . $wpdb->prefix . 'huge_itslider_images RENAME ' . $wpdb->prefix . 'huge_itslider_images_backup');
		} else {
			try {
				self::insert_default_rows();
			} catch (Exception $e) {

			}
		}

		$old_options_table_exists = $wpdb->get_var('SHOW TABLES LIKE "' . $wpdb->prefix . 'huge_itslider_params"');

		if ($old_options_table_exists) {
			Hugeit_Slider_Migrate::migrate_options();

			$wpdb->query('ALTER TABLE ' . $wpdb->prefix . 'huge_itslider_params RENAME ' . $wpdb->prefix . 'huge_itslider_params_backup');
		} else {
			self::set_default_options();
		}
	}

	/**
	 * Create tables.
	 */
	private static function create_tables() {
		global $wpdb;

		$collate = '';

		if ( $wpdb->has_cap( 'collation' ) ) {
			$collate = $wpdb->get_charset_collate();
		}

		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "hugeit_slider_slider(
				id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				name varchar(128) NOT NULL DEFAULT 'My New Slider',
				width int(4) UNSIGNED NOT NULL DEFAULT '600',
				height int(4) UNSIGNED NOT NULL DEFAULT '375',
				effect enum('none','cube_h','cube_v','fade','slice_h','slice_v','slide_h','slide_v','scale_out','scale_in','block_scale','kaleidoscope','fan','blind_h','blind_v','random') NOT NULL DEFAULT 'none',
				pause_time int(5) UNSIGNED NOT NULL DEFAULT '4000',
				change_speed int(5) UNSIGNED NOT NULL DEFAULT '1000',
				position enum('left','right','center') NOT NULL DEFAULT 'center',
				show_loading_icon int(1) UNSIGNED DEFAULT '0',
				navigate_by enum('dot','thumbnail','none') NOT NULL DEFAULT 'none',
				pause_on_hover int(1) UNSIGNED NOT NULL DEFAULT '1',
				video_autoplay int(1) UNSIGNED DEFAULT '0',
				random int(1) UNSIGNED DEFAULT '0',
				
				PRIMARY KEY (id)
			) {$collate}"
		);

		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "hugeit_slider_slide (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`slider_id` int(11) unsigned NOT NULL,
				`title` varchar(512) DEFAULT NULL,
				`description` varchar(2048) DEFAULT NULL,
				`url` varchar(2048) DEFAULT NULL,
				`attachment_id` bigint(20) unsigned DEFAULT NULL,
				`in_new_tab` int(1) unsigned NOT NULL DEFAULT '1',
				`type` enum('image','video','post') NOT NULL,
				`order` int(5) unsigned NOT NULL,
				`post_term_id` bigint(20) unsigned DEFAULT NULL,
				`post_show_title` int(1) unsigned DEFAULT NULL,
				`post_show_description` int(1) unsigned DEFAULT NULL,
				`post_go_to_post` int(1) unsigned DEFAULT NULL,
				`post_max_post_count` int(4) unsigned DEFAULT NULL,
				`video_quality` int(5) unsigned DEFAULT NULL,
				`video_volume` int(3) unsigned DEFAULT NULL,
				`video_show_controls` int(1) unsigned DEFAULT NULL,
				`video_show_info` int(1) unsigned DEFAULT NULL,
				`video_control_color` int(8) unsigned DEFAULT NULL,
				`draft` int(1) unsigned DEFAULT NULL,
				
				PRIMARY KEY (`id`)
			) {$collate}"
		);
	}

	private static function set_default_options() {
		if ( Hugeit_Slider_Options::get_crop_image() === false ) {
			Hugeit_Slider_Options::set_crop_image( 'stretch', __('Slider crop image', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_color() === false ) {
			Hugeit_Slider_Options::set_title_color( '000000', __('Slider title color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_font_size() === false ) {
			Hugeit_Slider_Options::set_title_font_size( 13, __('Slider title font size', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_color() === false ) {
			Hugeit_Slider_Options::set_description_color( 'ffffff', __('Slider description color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_font_size() === false ) {
			Hugeit_Slider_Options::set_description_font_size( 13, __('Slider description font size', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_position() === false ) {
			Hugeit_Slider_Options::set_title_position( 33, __('Slider title position', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_position() === false ) {
			Hugeit_Slider_Options::set_description_position( 31, __('Slider description position', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_border_size() === false ) {
			Hugeit_Slider_Options::set_title_border_size( 0, __('Slider Title border size', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_border_color() === false ) {
			Hugeit_Slider_Options::set_title_border_color( 'ffffff', __('Slider title border color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_border_radius() === false ) {
			Hugeit_Slider_Options::set_title_border_radius( 4, __('Slider title border radius', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_border_size() === false ) {
			Hugeit_Slider_Options::set_description_border_size( 0, __('Slider description border size', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_border_color() === false ) {
			Hugeit_Slider_Options::set_description_border_color( 'ffffff', __('Slider description border color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_border_radius() === false ) {
			Hugeit_Slider_Options::set_description_border_radius( 0, __('Slider description border radius', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_slideshow_border_size() === false ) {
			Hugeit_Slider_Options::set_slideshow_border_size( 0, __('Slider border size', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_slideshow_border_color() === false ) {
			Hugeit_Slider_Options::set_slideshow_border_color( 'ffffff', __('Slider border color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_slideshow_border_radius() === false ) {
			Hugeit_Slider_Options::set_slideshow_border_radius( 0, __('Slider border radius', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_navigation_type() === false ) {
			Hugeit_Slider_Options::set_navigation_type( 1, __('Slider navigation type', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_navigation_position() === false ) {
			Hugeit_Slider_Options::set_navigation_position( 'top', __('Slider navigation position', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_background_color() === false ) {
			Hugeit_Slider_Options::set_title_background_color( 'ffffff', __('Slider title background color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_background_color() === false ) {
			Hugeit_Slider_Options::set_description_background_color( '000000', __('Slider description background color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_slider_background_color() === false ) {
			Hugeit_Slider_Options::set_slider_background_color( 'ffffff', __('Slider slider background color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_slider_background_color_transparency() === false ) {
			Hugeit_Slider_Options::set_slider_background_color_transparency( 100, __('Slider slider background color transparency', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_active_dot_color() === false ) {
			Hugeit_Slider_Options::set_active_dot_color( 'ffffff', __('Slider active dot color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_dots_color() === false ) {
			Hugeit_Slider_Options::set_dots_color( '000000', __('Slider dots color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_loading_icon_type() === false ) {
			Hugeit_Slider_Options::set_loading_icon_type( 1, __('Slider Loading Image', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_width() === false ) {
			Hugeit_Slider_Options::set_description_width( 70, __('Slider description width', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_height() === false ) {
			Hugeit_Slider_Options::set_description_height( 50, __('Slider description height', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_background_transparency() === false ) {
			Hugeit_Slider_Options::set_description_background_transparency( 70, __('Slider description background transparency', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_text_align() === false ) {
			Hugeit_Slider_Options::set_description_text_align( 'justify', __('Description text-align', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_width() === false ) {
			Hugeit_Slider_Options::set_title_width( 30, __('Slider title width', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_height() === false ) {
			Hugeit_Slider_Options::set_title_height( 50, __('Slider title height', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_background_transparency() === false ) {
			Hugeit_Slider_Options::set_title_background_transparency( 70, __('Slider title background transparency', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_text_align() === false ) {
			Hugeit_Slider_Options::set_title_text_align( 'right', __('Title text-align', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_title_has_margin() === false ) {
			Hugeit_Slider_Options::set_title_has_margin( 1, __('Title has margin', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_description_has_margin() === false ) {
			Hugeit_Slider_Options::set_description_has_margin( 1, __('Description has margin', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_show_arrows() === false ) {
			Hugeit_Slider_Options::set_show_arrows( 1, __('Slider show left right arrows', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_thumb_count_slides() === false ) {
			Hugeit_Slider_Options::set_thumb_count_slides( 3, __('Count of Thumbs Slides', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_thumb_background_color() === false ) {
			Hugeit_Slider_Options::set_thumb_background_color( 'ffffff', __('Thumbnail Background Color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_thumb_passive_color() === false ) {
			Hugeit_Slider_Options::set_thumb_passive_color( 'ffffff', __('Passive Thumbnail Color', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_thumb_passive_color_transparency() === false ) {
			Hugeit_Slider_Options::set_thumb_passive_color_transparency( 50, __('Passive Thumbnail Color Transparency', 'hugeit-slider') );
		}

		if ( Hugeit_Slider_Options::get_thumb_height() === false ) {
			Hugeit_Slider_Options::set_thumb_height( 100, __('Slider Thumb Height', 'hugeit-slider' ) );
		}
	}

	private static function insert_default_rows() {
		/**
		 * @var Hugeit_Slider_Slide_Image $slide1
		 * @var Hugeit_Slider_Slide_Image $slide2
		 * @var Hugeit_Slider_Slide_Image $slide3
		 */

		$wp_upload_dir = wp_upload_dir();

		if (!is_dir($wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'hugeit-slider')) {
			mkdir($wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'hugeit-slider');
		}

		copy(HUGEIT_SLIDER_FRONT_IMAGES_PATH . DIRECTORY_SEPARATOR . 'slides' . DIRECTORY_SEPARATOR . 'slide1.jpg', $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'hugeit-slider' . DIRECTORY_SEPARATOR . 'slide1.jpg');
		copy(HUGEIT_SLIDER_FRONT_IMAGES_PATH . DIRECTORY_SEPARATOR . 'slides' . DIRECTORY_SEPARATOR . 'slide2.jpg', $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'hugeit-slider' . DIRECTORY_SEPARATOR . 'slide2.jpg');
		copy(HUGEIT_SLIDER_FRONT_IMAGES_PATH . DIRECTORY_SEPARATOR . 'slides' . DIRECTORY_SEPARATOR . 'slide3.jpg', $wp_upload_dir['basedir'] . DIRECTORY_SEPARATOR . 'hugeit-slider' . DIRECTORY_SEPARATOR . 'slide3.jpg');

		$attachment_id_1 = wp_insert_attachment(array('post_title' => __('Huge-IT First Slide.', 'hugeit-slider'), 'post_content' => '', 'post_status' => 'publish', 'post_mime_type' => 'jpg'), $wp_upload_dir['basedir'] . '/hugeit-slider/slide1.jpg');
		$attachment_id_2 = wp_insert_attachment(array('post_title' => __('Huge-IT Second Slide.', 'hugeit-slider'), 'post_content' => '', 'post_status' => 'publish', 'post_mime_type' => 'jpg'), $wp_upload_dir['basedir'] . '/hugeit-slider/slide2.jpg');
		$attachment_id_3 = wp_insert_attachment(array('post_title' => __('Huge-IT Third Slide.', 'hugeit-slider'), 'post_content' => '', 'post_status' => 'publish', 'post_mime_type' => 'jpg'), $wp_upload_dir['basedir'] . '/hugeit-slider/slide3.jpg');

		$slide1 = Hugeit_Slider_Slide::get_slide('image');
		$slide1
			->set_title('')
			->set_description('')
			->set_url('https://huge-it.com/')
			->set_attachment_id($attachment_id_1)
			->set_order(0);

		$slide2 = Hugeit_Slider_Slide::get_slide('image');
		$slide2
			->set_title(__('Simple Usage', 'hugeit-slider'))
			->set_description('')
			->set_url('https://huge-it.com/')
			->set_attachment_id($attachment_id_2)
			->set_order(1);

		$slide3 = Hugeit_Slider_Slide::get_slide('image');
		$slide3
			->set_title(__('Huge-IT Slider', 'hugeit-slider'))
			->set_description(__('The slider allows having unlimited amount of images with their titles and descriptions. The slider uses autogenerated shortcodes making it easier for the users to add it to the custom location.', 'hugeit-slider'))
			->set_url('https://huge-it.com/')
			->set_attachment_id($attachment_id_3)
			->set_order(2);

		$slider = new Hugeit_Slider_Slider();

		$slider
			->set_name(__('My First Slider', 'hugeit-slider'))
			->set_width(600)
			->set_height(375)
			->set_effect('random')
			->set_pause_time(4000)
			->set_change_speed(1000)
			->set_position('left')
			->set_show_loading_icon(true)
			->set_navigate_by('dot')
			->set_pause_on_hover(true)
			->set_random(false);

		$slider->add_slide($slide1);
		$slider->add_slide($slide2);
		$slider->add_slide($slide3);

		if ( ! $slider->save() ) {
			throw new Exception( __('Problem occurred while installation. Please connect to our support team.', 'hugeit-slider') );
		}
	}
}