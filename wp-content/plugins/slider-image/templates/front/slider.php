<?php
/**
 * @var int $slider_id Slider ID.
 * @var int $show_loading_icon 1 for show, otherwise 0.
 * @var string $loading_icon_type
 * @var Hugeit_Slider_Slide[] $slides
 * @var Hugeit_Slider_Slider $slider
 */
?>

<div class="slider_<?php echo $slider_id; ?>">
	<?php
	if($show_loading_icon) {
		echo '<div class="slider-loader-' . $slider_id . '"></div>';
	}
	?>
	<ul id="slider_<?php echo $slider_id; ?>" class="huge-it-slider" data-autoplay="<?php echo $slider->get_video_autoplay(); ?>">
		<?php
		foreach ( $slides as $key => $slide ) {
			$slide_type = $slides[ $key ]->get_type();
			$i = 0;
			switch($slide_type){
				case 'image': ?>
					<li class="group">
						<?php if($slides[ $key ]->get_url()){
							$target = ($slides[ $key ]->get_in_new_tab()) ? "_blank" : "";
							echo '<a href="'. $slides[ $key ]->get_url() .'" target="'. $target .'">';
						} ?>
							<img src="<?php echo wp_get_attachment_url($slides[$key]->get_attachment_id()); ?>" alt="<?php echo $slides[ $key ]->get_title(); ?>"/>
						<?php if($slides[ $key ]->get_url()){
							echo '</a>';
						} ?>
						<?php if($slides[ $key ]->get_title()){ ?>
							<div class="huge-it-caption slider-title">
								<div><?php echo $slides[ $key ]->get_title(); ?></div>
							</div>
						<?php } ?>
						<?php if($slides[ $key ]->get_description()){ ?>
							<div class="huge-it-caption slider-description">
								<div><?php echo $slides[ $key ]->get_description(); ?></div>
							</div>
						<?php } ?>
					</li>
					<?php
					break;
				case 'video':
					if( $slides[ $key ]->get_site() === 'youtube' ){ ?>
						<li class="group video_iframe">
							<img src="<?php echo 'https://img.youtube.com/vi/'.$slides[ $key ]->get_video_id().'/mqdefault.jpg'; ?>" class="video_cover" />
							<div id="huge_it_youtube_iframe<?php echo $slider_id.'_'.$slides[ $key ]->get_id(); ?>" data-id="<?php echo $slides[ $key ]->get_video_id(); ?>"
								 class="huge_it_youtube_iframe"	data-controls="<?php echo $slides[ $key ]->get_show_controls(); ?>"
								 data-showinfo="<?php echo $slides[ $key ]->get_show_info(); ?>" data-volume="<?php echo $slides[ $key ]->get_volume(); ?>"
								 data-quality="<?php echo $slides[ $key ]->get_quality(); ?>" data-rel="0" data-width="<?php echo $slider->get_width(); ?>"
								 data-height="<?php echo $slider->get_height(); ?>" data-delay="<?php echo $slider->get_pause_time(); ?>"  data-autoplay="0"></div>
							<div class="playSlider"></div>
							<div class="pauseSlider"></div>
							<div class="playButton"></div>
						</li>
					<?php } else if( $slides[ $key ]->get_site() === 'vimeo' ){
						$vimeo    = $slides[ $key ]->get_url();
						$temp_var = explode( "/", $vimeo );
						$imgid    = end( $temp_var );
						?>
						<li class="group video_iframe">
							<img src="<?php echo $slides[ $key ]->get_thumbnail_url(); ?> '" class="video_cover" />
							<iframe width="100%" height="100%" src="//player.vimeo.com/video/<?php echo $imgid; ?>?api=1&player_id=huge_it_vimeo_iframe<?php echo $slider_id.'_'.$slides[ $key ]->get_id(); ?>"
									id="huge_it_vimeo_iframe<?php echo $slider_id.'_'.$slides[ $key ]->get_id(); ?>" data-element-id="<?php echo $slides[ $key ]->get_id(); ?>"
									data-volume="<?php echo $slides[ $key ]->get_volume();?>" data-controlColor="<?php echo $slides[ $key ]->get_control_color();?>"
									class="huge_it_vimeo_iframe" frameborder="0" allowfullscreen=""></iframe>
							<div class="playSlider"></div>
							<div class="pauseSlider"></div>
							<div class="playButton"></div>
						</li>
					<?php }
					break;
				case 'post':
					$args = array(
						'numberposts' => $slides[ $key ]->get_max_post_count(),
						'offset' => 0,
						'category' => $slides[ $key ]->get_term_id(),
						'orderby' => 'post_date',
						'order' => 'DESC',
						'post_type' => 'post',
						'post_status' => 'publish, future, pending, private',
						'suppress_filters' => true );
					$posts = wp_get_recent_posts( $args, ARRAY_A );
					foreach($posts as $_key => $last_posts){
						$imagethumb = wp_get_attachment_image_src( get_post_thumbnail_id($last_posts["ID"]), 'thumbnail-size', true );
						if(get_post_thumbnail_id( $last_posts["ID"]) ){
							?>
							<li class="group">
								<?php if($last_posts["guid"]){
									$target = ($slides[ $key ]->get_in_new_tab()) ? "_blank" : "";
									echo '<a href="'. $last_posts["guid"] .'" target="'. $target .'">';
								} ?>
								<img src="<?php if(get_the_post_thumbnail($last_posts["ID"], 'thumbnail')){ echo $imagethumb[0]; }; ?>" alt="<?php echo $last_posts["post_title"]; ?>"/>
								<?php if($last_posts["guid"]){
									echo '</a>';
								} ?>
								<?php if($slides[ $key ]->get_show_title() && $last_posts["post_title"]){ ?>
									<div class="huge-it-caption slider-title">
										<div><?php echo $last_posts["post_title"]; ?></div>
									</div>
								<?php } ?>
								<?php if($slides[ $key ]->get_show_description() && wp_strip_all_tags($last_posts["post_excerpt"])){ ?>
									<div class="huge-it-caption slider-description">
										<div><?php echo wp_strip_all_tags($last_posts["post_excerpt"]); ?></div>
									</div>
								<?php } ?>
							</li>
							<?php
						}
						$i++;
					}
					break;
			}
		}
		?>
	</ul>
</div>
<script>
	jQuery(function (){
		jQuery('#slider_<?php echo $slider_id; ?>').sliderPlugin({
			maxWidth: singleSlider_<?php echo $slider_id; ?>.width,
			maxHeight: singleSlider_<?php echo $slider_id; ?>.height,
			transition: singleSlider_<?php echo $slider_id; ?>.effect,
			controls: singleSlider_<?php echo $slider_id; ?>.navigate_by,
			cropImage: hugeitSliderObj.crop_image,
			navigation: hugeitSliderObj.show_arrows,
			delay: +singleSlider_<?php echo $slider_id; ?>.pause_time,
			transitionDuration: +singleSlider_<?php echo $slider_id; ?>.change_speed,
			pauseOnHover: singleSlider_<?php echo $slider_id; ?>.pause_on_hover
		});
	});
</script>