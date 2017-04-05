<style>
ul#slider_<?php echo $slider_id; ?> {
	margin: 0;
	width: 100%;
	height: 100%;
	max-width: <?php echo $slider->get_width() . 'px'; ?>;
	max-height: <?php echo $slider->get_height() . 'px'; ?>;
	overflow: visible;
	padding: 0;
}

.slider_<?php echo $slider_id; ?> {
	width: 100%;
	height: 100%;
	max-width: <?php echo $slider->get_width() + 2 * Hugeit_Slider_Options::get_slideshow_border_size() . 'px'; ?>;
	max-height: <?php if($slider->get_navigate_by() === 'thumbnail'){
		echo $slider->get_height() + Hugeit_Slider_Options::get_thumb_height() + 3 * Hugeit_Slider_Options::get_slideshow_border_size() . 'px';
	} else {
		  echo $slider->get_height() + 2 * Hugeit_Slider_Options::get_slideshow_border_size() . 'px';
	} ?>;
<?php
switch($slider->get_position()){
case 'center':
    echo 'margin: 0 auto;';
    break;
case 'left':
    echo 'left: 0;';
    break;
case 'right':
    echo 'margin-left: calc(100% - ' . $slider->get_width() . 'px);';
    break;
}
?>
}
.huge-it-wrap:after,
.huge-it-slider:after,
.huge-it-thumb-wrap:after,
.huge-it-arrows:after,
.huge-it-caption:after {
	content: ".";
	display: block;
	height: 0;
	clear: both;
	line-height: 0;
	visibility: hidden;
}

.video_cover, .playSlider, .pauseSlider, div[class*=playButton] {
	display: none !important;
}

.huge-it-thumb-wrap .video_cover {
	display: block !important;
}

iframe.huge_it_vimeo_iframe {
	height: <?php echo $slider->get_height() . 'px'; ?>;
}

div[class*=slider-loader-] {
	background: rgba(0, 0, 0, 0) url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL . '/loading/loading' . Hugeit_Slider_Options::get_loading_icon_type() . '.gif'; ?>) no-repeat center;
	height: 90px;
	overflow: hidden;
	position: absolute;
	top: <?php echo ($slider->get_height() / 2 - 45) . 'px'; ?>;;
	width: <?php echo $slider->get_width() . 'px'; ?>;;
	z-index: 3;
}

.huge-it-wrap {
	opacity: 0;
	position: relative;
	border: <?php echo Hugeit_Slider_Options::get_slideshow_border_size().'px'; ?> solid <?php echo '#'.Hugeit_Slider_Options::get_slideshow_border_color(); ?>;
	-webkit-border-radius: <?php echo Hugeit_Slider_Options::get_slideshow_border_radius().'px'; ?>;
	-moz-border-radius: <?php echo Hugeit_Slider_Options::get_slideshow_border_radius().'px'; ?>;
	border-radius: <?php echo Hugeit_Slider_Options::get_slideshow_border_radius().'px'; ?>;
	<?php if(!(Hugeit_Slider_Options::get_navigation_type() === '16' && $slider->get_navigate_by() !== 'thumbnail')){
		echo 'overflow: hidden;';
	}?>;
}

.huge-it-slide-bg {
	background: <?php
					list($r,$g,$b) = array_map('hexdec',str_split(Hugeit_Slider_Options::get_slider_background_color(),2));
						$titleopacity = Hugeit_Slider_Options::get_slider_background_color_transparency();
						echo 'rgba('.$r.','.$g.','.$b.','.$titleopacity.')'; ?>;
<?php if($slider->get_navigate_by() == 'thumbnail'){ ?>
	border-bottom:	<?php echo Hugeit_Slider_Options::get_slideshow_border_size().'px'; ?> solid <?php echo '#'.Hugeit_Slider_Options::get_slideshow_border_color(); ?>;
<?php } ?>
}

.huge-it-caption {
	position: absolute;
	display: block;
}

.huge-it-caption div {
	padding: 10px 20px;
	line-height: normal;
}

.slider-title {
<?php if(Hugeit_Slider_Options::get_title_has_margin() === 1){
	$width = 'calc(' . Hugeit_Slider_Options::get_title_width() . '% - 20px)';
	$margin = '10px';
} else {
	$width = Hugeit_Slider_Options::get_title_width(). '%';
	$margin = '0';
} ?>
	width: <?php echo $width; ?>;
	margin: <?php echo $margin;?>;
	font-size: <?php echo Hugeit_Slider_Options::get_title_font_size() . 'px'; ?>;
	color: <?php echo '#' . Hugeit_Slider_Options::get_title_color(); ?>;
	text-align: <?php echo Hugeit_Slider_Options::get_title_text_align(); ?>;
	background: <?php
					list($r,$g,$b) = array_map('hexdec',str_split(Hugeit_Slider_Options::get_title_background_color(),2));
						$titleopacity = Hugeit_Slider_Options::get_title_background_transparency();
						echo 'rgba('.$r.','.$g.','.$b.','.$titleopacity.')'; ?>;
	border: <?php echo Hugeit_Slider_Options::get_title_border_size() . 'px solid #' . Hugeit_Slider_Options::get_title_border_color(); ?>;
	border-radius: <?php echo Hugeit_Slider_Options::get_title_border_radius() . 'px'; ?>;
<?php switch(Hugeit_Slider_Options::get_title_position()){
		case '11':
			echo 'left: 0 !important; bottom: 0;';
			break;
		case '21':
			echo 'left: 50% !important; transform: translateX(-50%); bottom: 0;';
			break;
		case '31':
			echo 'right: 0 !important; bottom: 0;';
			break;
		case '12':
			echo 'left: 0 !important; top: 50%; transform: translateY(-50%);';
			break;
		case '22':
			echo 'left: 50% !important; top: 50%; transform: translate(-50%, -50%);';
			break;
		case '32':
			echo 'right: 0 !important; top: 50%; transform: translateY(-50%);';
			break;
		case '13':
			echo 'left: 0 !important; top: 0;';
			break;
		case '23':
			echo 'left: 50% !important; transform: translateX(-50%); top: 0;';
			break;
		case '33':
			echo 'right: 0 !important; top: 0;';
			break;
} ?>
}

.slider-description {
<?php if(Hugeit_Slider_Options::get_description_has_margin() === 1){
	$width = 'calc(' . Hugeit_Slider_Options::get_description_width() . '% - 20px)';
	$margin = '10px';
} else {
	$width = Hugeit_Slider_Options::get_description_width(). '%';
	$margin = '0';
} ?>
	width: <?php echo $width; ?>;
	margin: <?php echo $margin;?>;
	font-size: <?php echo Hugeit_Slider_Options::get_description_font_size() . 'px'; ?>;
	color: <?php echo '#' . Hugeit_Slider_Options::get_description_color(); ?>;
	text-align: <?php echo Hugeit_Slider_Options::get_description_text_align(); ?>;
	background: <?php
					list($r,$g,$b) = array_map('hexdec',str_split(Hugeit_Slider_Options::get_description_background_color(),2));
						$descriptionopacity = Hugeit_Slider_Options::get_description_background_transparency();
						echo 'rgba('.$r.','.$g.','.$b.','.$descriptionopacity.')'; ?>;


	border: <?php echo Hugeit_Slider_Options::get_description_border_size() . 'px solid #' . Hugeit_Slider_Options::get_description_border_color(); ?>;
	border-radius: <?php echo Hugeit_Slider_Options::get_description_border_radius() . 'px'; ?>;
<?php switch(Hugeit_Slider_Options::get_description_position()){
		case '11':
			echo 'left: 0 !important; bottom: 0;';
			break;
		case '21':
			echo 'left: 50% !important; transform: translateX(-50%); bottom: 0;';
			break;
		case '31':
			echo 'right: 0 !important; bottom: 0;';
			break;
		case '12':
			echo 'left: 0 !important; top: 50%; transform: translateY(-50%);';
			break;
		case '22':
			echo 'left: 50% !important; top: 50%; transform: translate(-50%, -50%);';
			break;
		case '32':
			echo 'right: 0 !important; top: 50%; transform: translateY(-50%);';
			break;
		case '13':
			echo 'left: 0 !important; top: 0;';
			break;
		case '23':
			echo 'left: 50% !important; transform: translateX(-50%); top: 0;';
			break;
		case '33':
			echo 'right: 0 !important; top: 0;';
			break;
} ?>
}

.slider_<?php echo $slider_id; ?> .huge-it-slider > li {
	list-style: none;
	filter: alpha(opacity=0);
	opacity: 0;
	width: 100%;
	height: 100%;
	margin: 0 -100% 0 0;
	padding: 0;
	float: left;
	position: relative;
	<?php if(Hugeit_Slider_Options::get_crop_image() === 'fill'){
        echo 'height:  ' . $slider->get_height() . 'px;';
    } ?>;
	overflow: hidden;
}

.slider_<?php echo $slider_id; ?> .huge-it-slider > li > a {
	display: block;
	padding: 0;
	background: none;
	-webkit-border-radius: 0;
	-moz-border-radius: 0;
	border-radius: 0;
	width: 100%;
	height: 100%;
}

.slider_<?php echo $slider_id; ?> .huge-it-slider > li img {
	max-width: 100%;
	max-height: 100%;
	margin: 0;
	cursor: pointer;	
}

.slider_<?php echo $slider_id; ?> .huge-it-slide-bg, .slider_<?php echo $slider_id; ?> .huge-it-slider > li, .slider_<?php echo $slider_id; ?> .huge-it-slider > li > a, .slider_<?php echo $slider_id; ?> .huge-it-slider > li img {
	<?php if(Hugeit_Slider_Options::get_slideshow_border_size() !== '0'){
		if($slider->get_navigate_by() === 'thumbnail'){
			echo '-webkit-border-radius: '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px 0 0;';
			echo '-moz-border-radius: '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px 0 0;';
			echo 'border-radius: '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px 0 0;';
		} else {
			echo '-webkit-border-radius: '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px;';
			echo '-moz-border-radius: '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px;';
			echo 'border-radius: '.(Hugeit_Slider_Options::get_slideshow_border_radius() - 5).'px;';
		}
	} ?>;
}

.huge-it-dot-wrap {
	position: absolute;
<?php switch(Hugeit_Slider_Options::get_navigation_position()){
	case 'top':
		echo 'top: 5px;';
		echo 'height: 20px;';
		break;
	case 'bottom':
		echo 'bottom: 5px;';
		echo 'height: auto;';
		break;
}
?>
	left: 50%;
	transform: translateX(-50%);
	z-index: 999;
}

.huge-it-dot-wrap a {
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px;
	border-radius: 8px;
	cursor: pointer;
	display: block;
	float: left;
	height: 11px;
	margin: 2px !important;
	position: relative;
	text-align: left;
	text-indent: 9999px;
	width: 11px !important;
	background: <?php echo '#' . Hugeit_Slider_Options::get_dots_color(); ?>;
	box-shadow: none;
}

.huge-it-dot-wrap a.active:focus, .huge-it-dot-wrap a:focus,
.huge-it-thumb-wrap > a:focus, .huge-it-thumb-wrap > a.active:focus {
	outline: none;
}

.huge-it-dot-wrap a:hover {
	background: <?php echo '#' . Hugeit_Slider_Options::get_dots_color(); ?>;
	box-shadow: none !important;
}

.huge-it-dot-wrap a.active {
	background: <?php echo '#' . Hugeit_Slider_Options::get_active_dot_color(); ?>;
	box-shadow: none;
}

.huge-it-thumb-wrap {
	background: <?php echo '#' . Hugeit_Slider_Options::get_thumb_background_color();?>;
	height: <?php echo (Hugeit_Slider_Options::get_thumb_height() + 5).'px'; ?> ;
	margin-left: 0;
}

.huge-it-thumb-wrap a.active img {
	border-radius: 5px;
	opacity: 1;
}

.huge-it-thumb-wrap > a {
	height: <?php echo Hugeit_Slider_Options::get_thumb_height() . 'px'; ?>;
	display: block;
	float: left;
	position: relative;
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	background: <?php echo '#' . Hugeit_Slider_Options::get_thumb_passive_color(); ?>;
}

.huge-it-thumb-wrap a img {
	opacity: <?php echo 1 - Hugeit_Slider_Options::get_thumb_passive_color_transparency();?>;
	height: <?php echo Hugeit_Slider_Options::get_thumb_height() . 'px'; ?>;
	width: 100%;
	display: block;
	-ms-interpolation-mode: bicubic;
	box-shadow: none !important;
}

.huge-it-grid {
	position: absolute;
	overflow: hidden;
	width: 100%;
	height: 100%;
	display: none;
}

.huge-it-gridlet {
	position: absolute;
	opacity: 1;
}

.huge-it-arrows .huge-it-next,
.huge-it-arrows .huge-it-prev {
	z-index: 1;
}

.huge-it-arrows:hover .huge-it-next,
.huge-it-arrows:hover .huge-it-prev {
	z-index: 2;
}

.huge-it-arrows {
	cursor: pointer;
	height: 40px;
	margin-top: -20px;
	position: absolute;
	top: 50%;
	/*transform: translateY(-50%);*/
	width: 40px;
	z-index: 2;
	color: rgba(0, 0, 0, 0);
	outline: none;
	box-shadow: none !important;
}

.huge-it-arrows:hover, .huge-it-arrows:active, .huge-it-arrows:focus,
.huge-it-dot-wrap a:hover, .huge-it-dot-wrap a:active, .huge-it-dot-wrap a:focus {
	outline: none;
	box-shadow: none !important;
}

.ts-arrow:hover {
	opacity: .95;
	text-decoration: none;
}

<?php
switch (Hugeit_Slider_Options::get_navigation_type()) {
	case 1: ?>
.huge-it-prev {
	left:0;
	margin-top:-21px;
	height:43px;
	width:29px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-21px;
	height:43px;
	width:29px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;

}
<?php
break;
case 2: ?>
.huge-it-prev {
	left:0;
	margin-top:-25px;
	height:50px;
	width:50px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-25px;
	height:50px;
	width:50px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}

.huge-it-prev:hover {
	background-position:left -50px;
}

.huge-it-next:hover {
	background-position:right -50px;
}
<?php
break;
case 3: ?>
.huge-it-prev {
	left:0;
	margin-top:-22px;
	height:44px;
	width:44px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>)) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-22px;
	height:44px;
	width:44px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}

.huge-it-prev:hover {
	background-position:left -44px;
}

.huge-it-next:hover {
	background-position:right -44px;
}
<?php
break;
case 4:	?>
.huge-it-prev {
	left:0;
	margin-top:-33px;
	height:65px;
	width:59px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-33px;
	height:65px;
	width:59px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}

.huge-it-prev:hover {
	background-position:left -66px;
}

.huge-it-next:hover {
	background-position:right -66px;
}
<?php
break;
case 5: ?>
.huge-it-prev {
	left:0;
	margin-top:-18px;
	height:37px;
	width:40px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-18px;
	height:37px;
	width:40px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}

<?php
break;
case 6: ?>
.huge-it-prev {
	left:0;
	margin-top:-25px;
	height:50px;
	width:50px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-25px;
	height:50px;
	width:50px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}

.huge-it-prev:hover {
	background-position:left -50px;
}

.huge-it-next:hover {
	background-position:right -50px;
}
<?php
break;
case 7:	?>
.huge-it-prev {
	left:0;
	right:0;
	margin-top:-19px;
	height:38px;
	width:38px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-19px;
	height:38px;
	width:38px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
case 8: ?>
.huge-it-prev {
	left:0;
	margin-top:-22px;
	height:45px;
	width:45px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-22px;
	height:45px;
	width:45px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
case 9: ?>
.huge-it-prev {
	left:0;
	margin-top:-22px;
	height:45px;
	width:45px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-22px;
	height:45px;
	width:45px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
case 10: ?>
.huge-it-prev {
	left:0;
	margin-top:-24px;
	height:48px;
	width:48px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-24px;
	height:48px;
	width:48px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}

.huge-it-prev:hover {
	background-position:left -48px;
}

.huge-it-next:hover {
	background-position:right -48px;
}
<?php
break;
case 11: ?>
.huge-it-prev {
	left:0;
	margin-top:-29px;
	height:58px;
	width:55px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-29px;
	height:58px;
	width:55px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
case 12: ?>
.huge-it-prev {
	left:0;
	margin-top:-37px;
	height:74px;
	width:74px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-37px;
	height:74px;
	width:74px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
case 13: ?>
.huge-it-prev {
	left:0;
	margin-top:-16px;
	height:33px;
	width:33px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-16px;
	height:33px;
	width:33px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
case 14: ?>
.huge-it-prev {
	left:0;
	margin-top:-51px;
	height:102px;
	width:52px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-51px;
	height:102px;
	width:52px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
case 15: ?>
.huge-it-prev {
	left:0;
	margin-top:-19px;
	height:39px;
	width:70px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-19px;
	height:39px;
	width:70px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
case 16: ?>
.huge-it-prev {
	left:0;
	margin-top:-20px;
	height:40px;
	width:37px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) left  top no-repeat;
	background-size: 200%;
}

.huge-it-next {
	right:0;
	margin-top:-20px;
	height:40px;
	width:37px;
	background:url(<?php echo HUGEIT_SLIDER_FRONT_IMAGES_URL .  '/arrows/arrows' . Hugeit_Slider_Options::get_navigation_type() . '.png' ?>) right top no-repeat;
	background-size: 200%;
}
<?php
break;
}
?>
</style>
