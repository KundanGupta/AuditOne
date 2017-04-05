<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

interface Hugeit_Slider_Slider_Interface {

	/**
	 * Hugeit_Slider_Slider constructor.
	 *
	 * @param int $id
	 */
	public function __construct( $id = NULL );

	/**
	 * @return int
	 */
	public function get_id();

	/**
	 * @return string
	 */
	public function get_name();

	/**
	 * @param string $name
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_name( $name );

	/**
	 * @return int
	 */
	public function get_width();

	/**
	 * @param int $width
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_width( $width );

	/**
	 * @return int
	 */
	public function get_height();

	/**
	 * @param int $height
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_height( $height );

	/**
	 * @return string
	 */
	public function get_effect();

	/**
	 * @param string $effect
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_effect( $effect );

	/**
	 * @return int
	 */
	public function get_pause_time();

	/**
	 * @param int $pause_time
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_pause_time( $pause_time );

	/**
	 * @return int
	 */
	public function get_change_speed();

	/**
	 * @param int $change_speed
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_change_speed( $change_speed );

	/**
	 * @return string
	 */
	public function get_position();

	/**
	 * @param string $position
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_position( $position );

	/**
	 * @return int
	 */
	public function get_show_loading_icon();

	/**
	 * @param int $show_loading_icon
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_show_loading_icon( $show_loading_icon );

	/**
	 * @return string
	 */
	public function get_navigate_by();

	/**
	 * @param string $navigate_by
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_navigate_by( $navigate_by );

	/**
	 * @return int
	 */
	public function get_pause_on_hover();

	/**
	 * @param int $pause_on_hover
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_pause_on_hover( $pause_on_hover );

	/**
	 * @return int
	 */
	public function get_video_autoplay();

	/**
	 * @return int
	 */
	public function get_random();

	/**
	 * @param int $random
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_random( $random );

	/**
	 * Saves slider and it's slides.
	 *
	 * @return bool|int Inserted row id on success, false on failure.
	 */
	public function save();

	/**
	 * Add slide to $this->slides.
	 *
	 * @param Hugeit_Slider_Slide $slide
	 */
	public function add_slide( Hugeit_Slider_Slide $slide );

	/**
	 * Get slide by slide ID.
	 *
	 * @param int $id
	 *
	 * @return bool|Hugeit_Slider_Slide_Image
	 */
	public function get_slide($id);

	/**
	 * Returns count of slides in this slider.
	 *
	 * @return int
	 */
	public function get_slides_count();

	/**
	 * Delete slider by id.
	 *
	 * @param int $id Slider id.
	 *
	 * @return false|int
	 */
	public static function delete($id);
}