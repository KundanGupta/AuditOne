<?php
/*
Plugin Name: Social Media and Share Icons (Ultimate Social Media)
Plugin URI: http://ultimatelysocial.com
Description: Easy to use and 100% FREE social media plugin which adds social media icons to your website with tons of customization features!. 
Author: UltimatelySocial
Author URI: http://ultimatelysocial.com
Version: 1.6.6
License: GPLv2 or later
*/
global $wpdb;

/* define the Root for URL and Document */
define('SFSI_DOCROOT',    dirname(__FILE__));
define('SFSI_PLUGURL',    plugin_dir_url(__FILE__));
define('SFSI_WEBROOT',    str_replace(getcwd(), home_url(), dirname(__FILE__)));

/* load all files  */
include(SFSI_DOCROOT.'/libs/controllers/sfsi_socialhelper.php');
include(SFSI_DOCROOT.'/libs/sfsi_install_uninstall.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsi_buttons_controller.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsi_iconsUpload_contoller.php');
include(SFSI_DOCROOT.'/libs/sfsi_Init_JqueryCss.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsi_floater_icons.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsi_frontpopUp.php');
include(SFSI_DOCROOT.'/libs/controllers/sfsiocns_OnPosts.php');
include(SFSI_DOCROOT.'/libs/sfsi_widget.php');
include(SFSI_DOCROOT.'/libs/sfsi_subscribe_widget.php');

/* plugin install and uninstall hooks */
register_activation_hook(__FILE__, 'sfsi_activate_plugin' );
register_deactivation_hook(__FILE__, 'sfsi_deactivate_plugin');
register_uninstall_hook(__FILE__, 'sfsi_Unistall_plugin');

if(!get_option('sfsi_pluginVersion') || get_option('sfsi_pluginVersion') < 1.66)
{
	add_action("init", "sfsi_update_plugin");
}

//shortcode for the ultimate social icons {Monad}
add_shortcode("DISPLAY_ULTIMATE_SOCIAL_ICONS", "DISPLAY_ULTIMATE_SOCIAL_ICONS");
function DISPLAY_ULTIMATE_SOCIAL_ICONS($args = null, $content = null)
{
	$instance = array("showf" => 1, "title" => '');
	$return = '';
	if(!isset($before_widget)): $before_widget =''; endif;
	if(!isset($after_widget)): $after_widget =''; endif;
	
	/*Our variables from the widget settings. */
	$title = apply_filters('widget_title', $instance['title'] );
	$show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;
	global $is_floter;	      
	$return.= $before_widget;
		/* Display the widget title */
		if ( $title ) $return .= $before_title . $title . $after_title;
		$return .= '<div class="sfsi_widget">';
			$return .= '<div id="sfsi_wDiv"></div>';
			/* Link the main icons function */
			$return .= sfsi_check_visiblity(0);
	   		$return .= '<div style="clear: both;"></div>';
	    $return .= '</div>';
	$return .= $after_widget;
	return $return;
}

//adding some meta tags for facebook news feed {Monad}
function sfsi_checkmetas()
{
	if ( ! function_exists( 'get_plugins' ) )
	{
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$all_plugins = get_plugins();
	foreach($all_plugins as $key => $plugin)
	{
		if(is_plugin_active($key))
		{
			if(preg_match("/(seo|search engine optimization|meta tag|open graph|opengraph|og tag|ogtag)/im", $plugin['Name']) || preg_match("/(seo|search engine optimization|meta tag|open graph|opengraph|og tag|ogtag)/im", $plugin['Description']))
			{
				update_option("adding_tags", "no");
				break;
			}
			else
			{
				update_option("adding_tags", "yes");
			}
		}
	}	
}
if ( ! is_admin() )
{
	sfsi_checkmetas();
}

add_action('wp_head', 'ultimatefbmetatags');
function ultimatefbmetatags()
{
	$metarequest = get_option("adding_tags");
	$post_id = get_the_ID();
	
	$feed_id = sanitize_text_field(get_option('sfsi_feed_id'));
	$verification_code = get_option('sfsi_verificatiom_code');
	if(!empty($feed_id) && !empty($verification_code) && $verification_code != "no" )
	{
	    echo '<meta name="specificfeeds-verification-code-'.$feed_id.'" content="'.$verification_code.'"/>';
	}
	
	if($metarequest == 'yes' && !empty($post_id))
	{
		$post = get_post( $post_id );
		$attachment_id = get_post_thumbnail_id($post_id);
		$title = str_replace('"', "", strip_tags(get_the_title($post_id)));
		$url = get_permalink($post_id);
		$description = $post->post_content;
		$description = str_replace('"', "", strip_tags($description));
		
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		
		if($attachment_id)
		{
		   $feat_image = wp_get_attachment_url( $attachment_id );
		   if (preg_match('/https/',$feat_image))
		   {
				echo '<meta property="og:image:secure_url" content="'.$feat_image.'" data-id="sfsi">';
		   }
		   else
		   {
				echo '<meta property="og:image" content="'.$feat_image.'" data-id="sfsi">';
		   }
		   $metadata = wp_get_attachment_metadata( $attachment_id );
		   if(isset($metadata) && !empty($metadata))
		   {
			   if(isset($metadata['sizes']['post-thumbnail']))
			   {
					$image_type = $metadata['sizes']['post-thumbnail']['mime-type'];
			   }
			   else
			   {
					$image_type = '';  
			   }
			   if(isset($metadata['width']))
			   {
					$width = $metadata['width'];
			   }
			   else
			   {
					$width = '';  
			   }
			   if(isset($metadata['height']))
			   {
					$height = $metadata['height'];
			   }
			   else
			   {
					$height = '';  
			   }
		   }
		   else
		   {
				$image_type = '';
				$width = '';
				$height = '';  
		   }  
		   echo '<meta property="og:image:type" content="'.$image_type.'" data-id="sfsi" />';
		   echo '<meta property="og:image:width" content="'.$width.'" data-id="sfsi" />';
		   echo '<meta property="og:image:height" content="'.$height.'" data-id="sfsi" />';
		   echo '<meta property="og:url" content="'.$url.'" data-id="sfsi" />'; 
		   echo '<meta property="og:description" content="'.$description.'" data-id="sfsi" />';
		   echo '<meta property="og:title" content="'.$title.'" data-id="sfsi" />';
		}
	}
}

//Get verification code
if(is_admin())
{	
	$code = sanitize_text_field(get_option('sfsi_verificatiom_code'));
	$feed_id = sanitize_text_field(get_option('sfsi_feed_id'));
	if(empty($code) && !empty($feed_id))
	{
		add_action("init", "sfsi_getverification_code");
	}
}
function sfsi_getverification_code()
{
	$feed_id = sanitize_text_field(get_option('sfsi_feed_id'));
	$curl = curl_init();  
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://www.specificfeeds.com/wordpress/getVerifiedCode_plugin',
        CURLOPT_USERAGENT => 'sf get verification',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array(
            'feed_id' => $feed_id
        )
    ));
     // Send the request & save response to $resp
	$resp = curl_exec($curl);
	$resp = json_decode($resp);
	update_option('sfsi_verificatiom_code', $resp->code);
	curl_close($curl);
}

//checking for the youtube username and channel id option
add_action('admin_init', 'check_sfsfiupdatedoptions');
function check_sfsfiupdatedoptions()
{
	$option4=  unserialize(get_option('sfsi_section4_options',false));
	if(isset($option4['sfsi_youtubeusernameorid']) && !empty($option4['sfsi_youtubeusernameorid']))
	{
	}
	else
	{
		$option4['sfsi_youtubeusernameorid'] = 'name';
		update_option('sfsi_section4_options',serialize($option4));
	}
}

//sanitizing values
function string_sanitize($s) {
    $result = preg_replace("/[^a-zA-Z0-9]+/", " ", html_entity_decode($s, ENT_QUOTES));
    return $result;
}

//Add Subscriber form css
add_action("wp_head", "addStyleFunction");
function addStyleFunction()
{
	$option8 = unserialize(get_option('sfsi_section8_options',false));
	$sfsi_feediid = sanitize_text_field(get_option('sfsi_feed_id'));
	$url = "http://www.specificfeeds.com/widgets/subscribeWidget/";
	echo $return = '';
	?>
    	<script>
			jQuery(document).ready(function(e) {
                jQuery("body").addClass("sfsi_<?php echo get_option("sfsi_pluginVersion");?>")
            });
			function sfsi_processfurther(ref) {
				var feed_id = '<?php echo $sfsi_feediid?>';
				var feedtype = 8;
				var email = jQuery(ref).find('input[name="data[Widget][email]"]').val();
				var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if ((email != "Enter your email") && (filter.test(email))) {
					if (feedtype == "8") {
						var url = "'.$url.'"+feed_id+"/"+feedtype;
						window.open(url, "popupwindow", "scrollbars=yes,width=1080,height=760");
						return true;
					}
				} else {
					alert("Please enter email address");
					jQuery(ref).find('input[name="data[Widget][email]"]').focus();
					return false;
				}
			}
		</script>
        <style type="text/css" aria-selected="true">
			.sfsi_subscribe_Popinner
			{
				<?php if(sanitize_text_field($option8['sfsi_form_adjustment']) == 'yes') : ?>
				width: 100% !important;
				height: auto !important;
				<?php else: ?>
				width: <?php echo intval($option8['sfsi_form_width']) ?>px !important;
				height: <?php echo intval($option8['sfsi_form_height']) ?>px !important;
				<?php endif;?>
				<?php if(sanitize_text_field($option8['sfsi_form_border']) == 'yes') : ?>
				border: <?php echo intval($option8['sfsi_form_border_thickness'])."px solid ".sfsi_sanitize_hex_color($option8['sfsi_form_border_color']);?> !important;
				<?php endif;?>
				padding: 18px 0px !important;
				background-color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_background']) ?> !important;
			}
			.sfsi_subscribe_Popinner form
			{
				margin: 0 20px !important;
			}
			.sfsi_subscribe_Popinner h5
			{
				font-family: <?php echo sanitize_text_field($option8['sfsi_form_heading_font']) ?> !important;
				<?php if(sanitize_text_field($option8['sfsi_form_heading_fontstyle']) != 'bold') {?>
				font-style: <?php echo sanitize_text_field($option8['sfsi_form_heading_fontstyle']) ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo sanitize_text_field($option8['sfsi_form_heading_fontstyle']) ?> !important;
				<?php }?>
				color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_heading_fontcolor']) ?> !important;
				font-size: <?php echo intval($option8['sfsi_form_heading_fontsize'])."px" ?> !important;
				text-align: <?php echo sanitize_text_field($option8['sfsi_form_heading_fontalign']) ?> !important;
				margin: 0 0 10px !important;
    			padding: 0 !important;
			}
			.sfsi_subscription_form_field {
				margin: 5px 0 !important;
				width: 100% !important;
				display: inline-flex;
				display: -webkit-inline-flex;
			}
			.sfsi_subscription_form_field input {
				width: 100% !important;
				padding: 10px 0px !important;
			}
			.sfsi_subscribe_Popinner input[type=email]
			{
				font-family: <?php echo sanitize_text_field($option8['sfsi_form_field_font']); ?> !important;
				<?php if(sanitize_text_field($option8['sfsi_form_field_fontstyle']) != 'bold') {?>
				font-style: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php }?>
				color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_field_fontcolor']); ?> !important;
				font-size: <?php echo intval($option8['sfsi_form_field_fontsize'])."px" ?> !important;
				text-align: <?php echo sanitize_text_field($option8['sfsi_form_field_fontalign']); ?> !important;
			}
			.sfsi_subscribe_Popinner input[type=email]::-webkit-input-placeholder {
			   	font-family: <?php echo sanitize_text_field($option8['sfsi_form_field_font']); ?> !important;
				<?php if(sanitize_text_field($option8['sfsi_form_field_fontstyle']) != 'bold') {?>
				font-style: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php }?>
				color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_field_fontcolor']); ?> !important;
				font-size: <?php echo intval($option8['sfsi_form_field_fontsize'])."px" ?> !important;
				text-align: <?php echo sanitize_text_field($option8['sfsi_form_field_fontalign']); ?> !important;
			}
			.sfsi_subscribe_Popinner input[type=email]:-moz-placeholder { /* Firefox 18- */
			    font-family: <?php echo sanitize_text_field($option8['sfsi_form_field_font']); ?> !important;
				<?php if(sanitize_text_field($option8['sfsi_form_field_fontstyle']) != 'bold') {?>
				font-style: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php }?>
				color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_field_fontcolor']); ?> !important;
				font-size: <?php echo intval($option8['sfsi_form_field_fontsize'])."px" ?> !important;
				text-align: <?php echo sanitize_text_field($option8['sfsi_form_field_fontalign']); ?> !important;
			}
			.sfsi_subscribe_Popinner input[type=email]::-moz-placeholder {  /* Firefox 19+ */
			    font-family: <?php echo sanitize_text_field($option8['sfsi_form_field_font']); ?> !important;
				<?php if(sanitize_text_field($option8['sfsi_form_field_fontstyle']) != 'bold') {?>
				font-style: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php }?>
				color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_field_fontcolor']); ?> !important;
				font-size: <?php echo intval($option8['sfsi_form_field_fontsize'])."px" ?> !important;
				text-align: <?php echo sanitize_text_field($option8['sfsi_form_field_fontalign']); ?> !important;
			}
			.sfsi_subscribe_Popinner input[type=email]:-ms-input-placeholder {  
			  	font-family: <?php echo sanitize_text_field($option8['sfsi_form_field_font']); ?> !important;
				<?php if(sanitize_text_field($option8['sfsi_form_field_fontstyle']) != 'bold') {?>
				font-style: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo sanitize_text_field($option8['sfsi_form_field_fontstyle']) ?> !important;
				<?php }?>
				color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_field_fontcolor']); ?> !important;
				font-size: <?php echo intval($option8['sfsi_form_field_fontsize'])."px" ?> !important;
				text-align: <?php echo sanitize_text_field($option8['sfsi_form_field_fontalign']); ?> !important;
			}
			.sfsi_subscribe_Popinner input[type=submit]
			{
				font-family: <?php echo sanitize_text_field($option8['sfsi_form_button_font']); ?> !important;
				<?php if(sanitize_text_field($option8['sfsi_form_button_fontstyle']) != 'bold') {?>
				font-style: <?php echo sanitize_text_field($option8['sfsi_form_button_fontstyle']) ?> !important;
				<?php } else{ ?>
				font-weight: <?php echo sanitize_text_field($option8['sfsi_form_button_fontstyle']) ?> !important;
				<?php }?>
				color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_button_fontcolor']); ?> !important;
				font-size: <?php echo intval($option8['sfsi_form_button_fontsize'])."px" ?> !important;
				text-align: <?php echo sanitize_text_field($option8['sfsi_form_button_fontalign']); ?> !important;
				background-color: <?php echo sfsi_sanitize_hex_color($option8['sfsi_form_button_background']); ?> !important;
			}
		</style>
	<?php
}
add_action('admin_notices', 'sfsi_admin_notice', 10);
function sfsi_admin_notice()
{
	$language = get_option("WPLANG");
	
	if(isset($_GET['page']) && $_GET['page'] == "sfsi-options")
	{
		$style = "overflow: hidden; margin:12px 3px 0px;";
	}
	else
	{
		$style = "overflow: hidden;"; 
	}
	

	
	if(get_option("sfsi_curlErrorNotices") == "yes")
	{ 
		?>
		<style type="text/css">
			form.sfsi_curlNoticeDismiss {
			    display: inline-block;
			    margin: 5px 0 0;
			    vertical-align: middle;
			}
			.sfsi_curlNoticeDismiss input[type='submit']{
				background-color: transparent;
			    border: medium none;
			    margin: 0;
			    padding: 0;
			    cursor: pointer;
			}
		</style>
		<div class="error" style="<?php echo $style; ?>">
			<div class="alignleft" style="margin: 9px 0;">
				There seems to be an error on your website which prevents the plugin to work properly. Please contact us at <a href="mailto:support@ultimatelysocial.com">support@ultimatelysocial.com</a> and state the error code you see below.
                <p style="text-align:left"><b>Error : <?php echo ucfirst(get_option("sfsi_curlErrorMessage")); ?></b></p>
			</div>
			<div class="alignright">
				<form method="post" class="sfsi_curlNoticeDismiss">
					<input type="hidden" name="sfsi-dismiss-curlNotice" value="true">
					<input type="submit" name="dismiss" value="Dismiss" />
				</form>
			</div>
		</div>
	<?php }
	
	/**
	 * if wordpress uses other language
	 */
	if(
		!empty($language) &&
		isset($_GET['page']) &&
		$_GET['page'] == "sfsi-options" &&
		get_option("sfsi_languageNotice") == "yes"
	)
	{
		?>
		<style type="text/css">
			form.sfsi_languageNoticeDismiss{
			    display: inline-block;
			    margin: 5px 0 0;
			    vertical-align: middle;
			}
			.sfsi_languageNoticeDismiss input[type='submit']{
				background-color: transparent;
			    border: medium none;
			    margin: 0;
			    padding: 0;
			    cursor: pointer;
			}
		</style>
		<div class="updated" style="<?php echo $style; ?>">
			<div class="alignleft" style="margin: 9px 0;">
				We detected that you're using a language other than English in Wordpress. We created also the <a target="_blank" href="https://wordpress.org/plugins/ultimate-social-media-plus/">Ultimate Social Media PLUS</a> plugin (still FREE) which allows you to select buttons in non-English languages (under question 6).
			</div>
			<div class="alignright">
				<form method="post" class="sfsi_languageNoticeDismiss">
					<input type="hidden" name="sfsi-dismiss-languageNotice" value="true">
					<input type="submit" name="dismiss" value="Dismiss" />
				</form>
			</div>
		</div>
		<?php 
	}

	/**
	 * Premium Notification
	 */
	$domain 	= sfsi_getdomain(site_url());
	$siteMatch 	= false;
	
	if(!empty($domain))
	{
		$regexp = "/^([a-d A-D])/im";
		if(preg_match($regexp, $domain)) {
			$siteMatch = true;
		}
		else {
			$siteMatch = false;
		}
	}

	if(get_option("show_premium_notification") == "yes")
	{
		?>
		<style type="text/css">
			.sfsi_show_premium_notification a{
			   	color: #fff;
			}
			form.sfsi_premiumNoticeDismiss {
			    display: inline-block;
			    margin: 5px 0 0;
			    vertical-align: middle;
			}
			.sfsi_premiumNoticeDismiss input[type='submit']{
				background-color: transparent;
			    border: medium none;
			    color: #fff;
			    margin: 0;
			    padding: 0;
			    cursor: pointer;
			}
		</style>
	    <div class="updated sfsi_show_premium_notification" style="<?php echo $style; ?>background-color: #38B54A; color: #fff; font-size: 18px;">
			<div class="alignleft" style="margin: 9px 0;">
				BIG NEWS : There is now a <b><a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmi_settings_page&utm_campaign=notification_banner&utm_medium=banner" target="_blank">Premium Ultimate Social Media Plugin</a></b> available with many more cool features : <a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmi_settings_page&utm_campaign=notification_banner&utm_medium=banner" target="_blank">Check it out</a>
			</div>
			<div class="alignright">
				<form method="post" class="sfsi_premiumNoticeDismiss">
					<input type="hidden" name="sfsi-dismiss-premiumNotice" value="true">
					<input type="submit" name="dismiss" value="Dismiss" />
				</form>
			</div>
		</div>
		<?php
	} 
	
	/* show mobile notification */
	if(get_option("show_mobile_notification") == "yes"){
		$sfsi_install_date = strtotime(get_option( 'sfsi_installDate' ));
		$sfsi_future_date = strtotime( '14 days',$sfsi_install_date );
		$sfsi_past_date = strtotime("now");
		if($sfsi_past_date >= $sfsi_future_date) {
		?>
			<style type="text/css">
				.sfsi_show_mobile_notification a{
					color: #fff;
				}
				form.sfsi_mobileNoticeDismiss {
					display: inline-block;
					margin: 5px 0 0;
					vertical-align: middle;
				}
				.sfsi_mobileNoticeDismiss input[type='submit']{
					background-color: transparent;
					border: medium none;
					color: #fff;
					margin: 0;
					padding: 0;
					cursor: pointer;
				}
			</style>
		<!-- <div class="updated sfsi_show_mobile_notification" style="<?php echo $style; ?>background-color: #38B54A; color: #fff; font-size: 18px;">
				<div class="alignleft" style="margin: 9px 0;line-height: 24px;width: 95%;">
					<b>Over 50% of visitors are mobile visitors.</b> Make sure your social media icons look good on mobile too, so that people like & share your site. With the premium plugin you can define the location of the icons separately on mobile:<a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmi_settings_page&utm_campaign=check_mobile&utm_medium=banner" target="_blank">Check it out</a>
				</div>
				<div class="alignright">
					<form method="post" class="sfsi_mobileNoticeDismiss">
						<input type="hidden" name="sfsi-dismiss-mobileNotice" value="true">
						<input type="submit" name="dismiss" value="Dismiss" />
					</form>
				</div>
			</div> -->
		<?php
		}
	}
/* end show mobile notification */
	
}
add_action('admin_init', 'sfsi_dismiss_admin_notice');
function sfsi_dismiss_admin_notice()
{
	if ( isset($_REQUEST['sfsi-dismiss-notice']) && $_REQUEST['sfsi-dismiss-notice'] == 'true' )
	{
		update_option( 'show_notification_plugin', "no" );
		//header("Location: ".site_url()."/wp-admin/admin.php?page=sfsi-options");die;
	}
	
	if ( isset($_REQUEST['sfsi-dismiss-curlNotice']) && $_REQUEST['sfsi-dismiss-curlNotice'] == 'true' )
	{
		update_option( 'sfsi_curlErrorNotices', "no" );
		//header("Location: ".site_url()."/wp-admin/admin.php?page=sfsi-options");die;
	}
	
	if ( isset($_REQUEST['sfsi-dismiss-languageNotice']) && $_REQUEST['sfsi-dismiss-languageNotice'] == 'true' )
	{
		update_option( 'sfsi_languageNotice', "no" );
		//header("Location: ".site_url()."/wp-admin/admin.php?page=sfsi-options"); die;
	}

	if ( isset($_REQUEST['sfsi-dismiss-premiumNotice']) && $_REQUEST['sfsi-dismiss-premiumNotice'] == 'true' )
	{
		update_option( 'show_premium_notification', "no" );
		//header("Location: ".site_url()."/wp-admin/admin.php?page=sfsi-options");die;
	}
	
	if ( isset($_REQUEST['sfsi-dismiss-mobileNotice']) && $_REQUEST['sfsi-dismiss-mobileNotice'] == 'true' )
	{
		update_option( 'show_mobile_notification', "no" );
		//header("Location: ".site_url()."/wp-admin/admin.php?page=sfsi-options");die;
	}
}

function sfsi_get_bloginfo($url)
{
	$web_url = get_bloginfo($url);
	
	//Block to use feedburner url
	if (preg_match("/(feedburner)/im", $web_url, $match))
	{
		$web_url = site_url()."/feed";
	}
	return $web_url;
}

function sfsi_getdomain($url)
{
	$pieces = parse_url($url);
	$domain = isset($pieces['host']) ? $pieces['host'] : '';
	if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
		return $regs['domain'];
	}
	return false;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), "sfsi_actionLinks", -10 );
function sfsi_actionLinks($links)
{
	$links[] = '<a href="https://www.ultimatelysocial.com/usm-premium/?utm_source=usmi_manage_plugin_page&utm_campaign=upgrade_to_pro&utm_medium=banner" id="sfsi_deactivateButton" style="color:#FF0000;"><b>Upgrade To pro</b></a>';
	$links[] = $links["deactivate"];
	$links[] = $links["edit"];
	unset($links['deactivate']);
	unset($links['edit']);
	return $links;
}

?>
