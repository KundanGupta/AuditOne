<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Hugeit_Slider_Slider implements Hugeit_Slider_Slider_Interface {

	/**
	 * Slider id.
	 *
	 * @var int
	 */
	private $id;

	/**
	 * Slider name.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Slider width.
	 *
	 * @var int
	 */
	private $width = 600;

	/**
	 * Slider height
	 *
	 * @var int
	 */
	private $height = 375;

	/**
	 * Slider effect.
	 *
	 * @values ['none', 'cube_h', 'cube_v', 'fade', 'slice_h', 'slice_v', 'slide_h', 'slide_v', 'scale_out', 'scale_in', 'block_scale', 'kaleidoscope', 'fan', 'blind_h', 'blind_v', 'random']
	 *
	 * @var string
	 */
	private $effect = 'none';

	/**
	 * Slider pause time in milliseconds.
	 *
	 * @var int
	 */
	private $pause_time = 4000;

	/**
	 * Sliding speed in milliseconds.
	 *
	 * @var int
	 */
	private $change_speed = 1000;

	/**
	 * Slider position.
	 *
	 * @values ['left', 'right', 'center']
	 *
	 * @var string
	 */
	private $position = 'center';

	/**
	 * Show or not loading icon while loading slide. 1 for show, otherwise 0.
	 *
	 * @var int
	 */
	private $show_loading_icon = 0;

	/**
	 * Slider navigation method.
	 *
	 * @values ['dot', 'thumbnail', 'none']
	 *
	 * @var string
	 */
	private $navigate_by = 'none';

	/**
	 * Enable pause on hover. 1 for pause, otherwise 0.
	 *
	 * @var int
	 */
	private $pause_on_hover = 1;

	/**
	 * Enable video autoplay. 1for autoplay, otherwise 0.
	 *
	 * @var int
	 */
	private $video_autoplay = 0;

	/**
	 * Random sliding. 1 for random slid
	 *
	 * @var int
	 */
	private $random = 0;

	/**
	 * This as an array of this slider slides.
	 *
	 * @var array
	 */
	private $slides = array();

	/**
	 * Hugeit_Slider_Slider constructor.
	 *
	 * @param int $id
	 */
	public function __construct( $id = NULL ) {
		if ( is_numeric($id) && absint($id) == $id && absint($id)) {
			global $wpdb;

			$slider = $wpdb->get_row("SELECT * FROM " . Hugeit_Slider()->get_slider_table_name() . " WHERE id = " . $id, ARRAY_A);

			if ( ! is_null( $slider ) ) {

				$this->id = $id;

				foreach ( $slider as $slider_option_name => $slider_option_value ) {
					$function_name = 'set_' . $slider_option_name;

					if (method_exists($this, $function_name)) {
						try {
							call_user_func( array( $this, $function_name ), $slider_option_value );
						} catch ( Exception $e ) {
							wp_die($e->getMessage());
						}
					}
				}
			}

			$slides = $wpdb->get_results( "SELECT id FROM " . Hugeit_Slider()->get_slide_table_name() . " WHERE slider_id = " . $id . " AND (draft IS NULL OR draft = 0) ORDER BY `order` ASC");

			foreach ( $slides as $slide ) {
				try {
					$this->slides[] = Hugeit_Slider_Slide::get_slide( $slide->id );
				} catch ( Exception $e ) {
					wp_die($e->getMessage());
				}
			}
		} else {
			$this->name = __('My New Slider', 'hugeit-slider');
		}
	}

	public function __clone() {
		unset($this->id);

		foreach ( $this->slides as $key => $slide ) {
			$this->slides[$key] = clone $slide;
		}
	}

	/**
	 * @return int
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * @param string $name
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_name( $name ) {
		$name = sanitize_text_field( $name );

		if ( ! empty( $name ) ) {
			$this->name = $name;

			return $this;
		}

		throw new Exception( 'Invalid value for "name" field.' );
	}

	/**
	 * @return int
	 */
	public function get_width() {
		return $this->width;
	}

	/**
	 * @param int $width
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_width( $width ) {

		if (is_numeric($width)) {
			$width = absint($width);

			if ($width > 0 && $width < 9999) {
				$this->width = $width;

				return $this;
			}
		}

		throw new Exception('Invalid value for "width" field.');
	}

	/**
	 * @return int
	 */
	public function get_height() {
		return $this->height;
	}

	/**
	 * @param int $height
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_height( $height ) {
		if ( is_numeric( $height ) ) {
			$height = absint( $height );

			if ( $height > 0 && $height < 9999 ) {
				$this->height = $height;

				return $this;
			}
		}

		throw new Exception('Invalid value for "height" field.');
	}

	/**
	 * @return string
	 */
	public function get_effect() {
		return $this->effect;
	}

	/**
	 * @param string $effect
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_effect( $effect ) {

		if ( ! in_array($effect, array( 'none', 'cube_h', 'cube_v', 'fade', 'slice_h', 'slice_v', 'slide_h', 'slide_v', 'scale_out', 'scale_in', 'block_scale', 'kaleidoscope', 'fan', 'blind_h', 'blind_v', 'random') ) ) {
			throw new Exception( 'Invalid value for "effect" field.' );
		}

		$this->effect = $effect;

		return $this;
	}

	/**
	 * @return int
	 */
	public function get_pause_time() {
		return $this->pause_time;
	}

	/**
	 * @param int $pause_time
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_pause_time( $pause_time ) {

		if (is_numeric($pause_time)) {
			$pause_time = absint($pause_time);

			if ($pause_time > 0 && $pause_time < 99999) {
				$this->pause_time = $pause_time;

				return $this;
			}
		}

		throw new Exception('Invalid value for "pause_time" field.');
	}

	/**
	 * @return int
	 */
	public function get_change_speed() {
		return $this->change_speed;
	}

	/**
	 * @param int $change_speed
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_change_speed( $change_speed ) {

		if (is_numeric($change_speed)) {
			$change_speed = absint($change_speed);

			if ($change_speed > 0 && $change_speed < 99999) {
				$this->change_speed = $change_speed;

				return $this;
			}
		}

		throw new Exception('Invalid value for "change_speed" field.');
	}

	/**
	 * @return string
	 */
	public function get_position() {
		return $this->position;
	}

	/**
	 * @param string $position
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_position( $position ) {

		if ( ! in_array($position, array( 'left', 'right', 'center') ) ) {
			throw new Exception( 'Invalid value for "position" field.' );
		}

		$this->position = $position;

		return $this;
	}

	/**
	 * @return int
	 */
	public function get_show_loading_icon() {
		return $this->show_loading_icon;
	}

	/**
	 * @param int $show_loading_icon
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_show_loading_icon( $show_loading_icon ) {

		if ( $show_loading_icon == 1 || $show_loading_icon == 0  ) {
			$this->show_loading_icon = (int)$show_loading_icon;

			return $this;
		}

		throw new Exception( 'Invalid value for "show_loading_icon" field.' );
	}

	/**
	 * @return string
	 */
	public function get_navigate_by() {
		return $this->navigate_by;
	}

	/**
	 * @param string $navigate_by
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_navigate_by( $navigate_by ) {

		if ( ! in_array( $navigate_by, array( 'dot', 'thumbnail', 'none' ) ) ) {
			throw new Exception( 'Invalid value for "navigate_by" value.' );
		}

		$this->navigate_by = $navigate_by;

		return $this;
	}

	/**
	 * @return int
	 */
	public function get_pause_on_hover() {
		return $this->pause_on_hover;
	}

	/**
	 * @param int $pause_on_hover
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_pause_on_hover( $pause_on_hover ) {
		if ( $pause_on_hover == 1 || $pause_on_hover == 0  ) {
			$this->pause_on_hover = (int)$pause_on_hover;

			return $this;
		}

		throw new Exception( 'Invalid value for "pause_on_hover" field.' );
	}

	/**
	 * @return int
	 */
	public function get_video_autoplay() {
		return $this->video_autoplay;
	}

	/**
	 * @return int
	 */
	public function get_random() {
		return $this->random;
	}

	/**
	 * @param int $random
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_random( $random ) {
		if ( $random == 1 || $random == 0  ) {
			$this->random = $random;

			return $this;
		}

		throw new Exception( 'Invalid value for "random" field.' );
	}

	/**
	 * @return array
	 */
	public function get_slides() {
		return $this->slides;
	}

	/**
	 * Add slide to $this->slides.
	 *
	 * @param Hugeit_Slider_Slide $slide
	 */
	public function add_slide( Hugeit_Slider_Slide $slide ) {
		$slide->set_is_draft(NULL);
		$this->slides[] = $slide;
	}

	/**
	 * @param array $slides
	 *
	 * @return Hugeit_Slider_Slider
	 * @throws Exception
	 */
	public function set_slides( $slides ) {
		foreach ($slides as $slide) {
			if (!($slide instanceof Hugeit_Slider_Slide)) {
				throw new Exception('Slide must be an instance of Hugeit_Slider_Slide class.');
			}
		}

		$this->slides = $slides;

		return $this;
	}



	/**
	 * Get slide by slide ID.
	 *
	 * @param int $id
	 *
	 * @return bool|Hugeit_Slider_Slide_Image
	 */
	public function get_slide($id) {
		$id = absint($id);

		foreach ( $this->slides as $slide ) {
			if ( $slide->id === $id ) {
				return $slide;
			}
		}

		return false;
	}

	/**
	 * Returns count of slides in this slider.
	 *
	 * @return int
	 */
	public function get_slides_count() {
		return count($this->slides);
	}

	/**
	 * Saves slider and it's slides.
	 *
	 * @param null $desired_id
	 *
	 * @return array|bool Inserted row id on success, false on failure.
	 *
	 */
	public function save($desired_id = NULL) {

		global $wpdb;

		$slider_data = array(
			'name' => $this->name,
			'width' => $this->width,
			'height' => $this->height,
			'effect' => $this->effect,
			'pause_time' => $this->pause_time,
			'change_speed' => $this->change_speed,
			'position' => $this->position,
			'show_loading_icon' => $this->show_loading_icon,
			'navigate_by' => $this->navigate_by,
			'pause_on_hover' => $this->pause_on_hover,
			'video_autoplay' => $this->video_autoplay,
			'random' => $this->random
		);

		if (NULL !== $desired_id) {
			$slider_data['id'] = absint($desired_id);
		}

		$slider_success = is_null($this->id)
			? $wpdb->insert(Hugeit_Slider()->get_slider_table_name(), $slider_data)
			: $wpdb->update(Hugeit_Slider()->get_slider_table_name(), $slider_data, array('id' => $this->id));

		if ($slider_success !== false) {
			if (null === $this->id) {
				$this->id = $wpdb->insert_id;
			}

			$slide_success = array();

			foreach ( $this->slides as $slide ) {
				$slide->set_slider_id($this->id);
				$slide->set_is_draft(NULL);
				try {
					$slide_success[] = $slide->save();
				} catch (Exception $e) {
					die($e->getMessage());
				}
			}

			$removed_slide_ids = $this->get_removed_slide_ids();

			foreach ( $removed_slide_ids as $id ) {
				Hugeit_Slider_Slide::delete($id);
			}

			$this->remove_draft_slides();

			return array('slider_id' => $this->id, 'slide_ids' => $slide_success, 'success' => 1);
		}

		return false;
	}

	private function remove_draft_slides() {
		global $wpdb;

		return $wpdb->query('DELETE FROM ' . Hugeit_Slider()->get_slide_table_name() . ' WHERE slider_id = ' . $this->id . ' AND draft = 1');
	}

	private function get_removed_slide_ids() {
		global $wpdb;

		$removable_ids = array();
		$old_slide_ids = $wpdb->get_results( "SELECT id FROM " . Hugeit_Slider()->get_slide_table_name() . " WHERE slider_id = " . $this->id );

		foreach ( $old_slide_ids as $old_slide ) {
			if ( ! $this->has_slide( $old_slide->id ) ) {
				$removable_ids[] = $old_slide->id;
			}
		}

		return $removable_ids;
	}

	private function has_slide( $slide_id ) {
		foreach ( $this->slides as $slide ) {
			if ( $slide->get_id() == $slide_id ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get all sliders.
	 *
	 * @return Hugeit_Slider_Slider[]
	 */
	public static function get_all_sliders() {
		global $wpdb;

		$ids = $wpdb->get_results('SELECT id FROM ' . Hugeit_Slider()->get_slider_table_name() . ' ORDER BY id ASC');

		foreach ( $ids as $data ) {
			$sliders[$data->id] = new Hugeit_Slider_Slider($data->id);
		}

		return !empty($sliders) ? $sliders : array();
	}

	/**
	 * Delete slider by id.
	 *
	 * @param int $id Slider id.
	 *
	 * @return false|int
	 */
	public static function delete( $id ) {
		global $wpdb;

		$success = $wpdb->query("DELETE FROM " . Hugeit_Slider()->get_slider_table_name() . " WHERE id = " . $id);

		if ($success) {
			$slides = self::get_slides_ids($id);

			foreach ( $slides as $slide ) {
				Hugeit_Slider_Slide::delete($slide->id);
			}
		}

		return $success;
	}

	/**
	 * Get slider's slide's ids.
	 *
	 * @param $slider_id
	 * @param string $output. Output type. Default OBJECT
	 *
	 * @return array|null|object
	 */
	private static function get_slides_ids($slider_id, $output = OBJECT) {
		global $wpdb;

		return $wpdb->get_results("SELECT id FROM " . Hugeit_Slider()->get_slide_table_name() . " WHERE slider_id =" . $slider_id, $output);
	}

	public static function get_all_sliders_id_name_pair() {
		global $wpdb;

		return $wpdb->get_results("SELECT id, name FROM " . Hugeit_Slider()->get_slider_table_name() . ' ORDER BY id ASC');
	}

	public static function duplicate($id) {
		$old_slider = new Hugeit_Slider_Slider($id);
		$new_slider = clone $old_slider;
		$new_slider->name .= ' Copy';

		return $new_slider->save();
	}
}