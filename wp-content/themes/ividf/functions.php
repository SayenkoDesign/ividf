<?php

define('OM_THEME_PREFIX', 'om_amax_');
define('OM_THEME_SHORT_PREFIX', 'om_');
define('OM_THEME_NAME', 'amax');
define('OM_THEME_TITLE_NAME', 'Amax');
define('TEMPLATE_DIR', get_template_directory()); // without the trailing slash
define('TEMPLATE_DIR_URI', get_template_directory_uri()); // without trailing slash, in the event a child theme is being used, the parent theme directory URI will be returned
define('OM_THEME_VERSION', '1.0.4');

/*************************************************************************************
 *	WordPress version control
 *************************************************************************************/
if(floatval(get_bloginfo('version')) < 3.6) {
	function om_show_version_notice() {
		echo '<div id="message" class="error"><p><strong>'.__('This theme requires WordPress version 3.6 or greater to work properly. Please, update WordPress','om_theme').'</strong></p></div>';
	}
	add_action('admin_notices', 'om_show_version_notice');     
}

/*************************************************************************************
 *	Translation Text Domain
 *************************************************************************************/

load_theme_textdomain('om_theme', TEMPLATE_DIR . '/languages');

/*************************************************************************************
 *	Register Menu
 *************************************************************************************/
 
if( !function_exists( 'om_register_menu' ) ) {
	function om_register_menu() {
	  register_nav_menu('primary-menu', __('Primary Menu', 'om_theme'));
	  //register_nav_menu('secondary-menu', __('Secondary Menu', 'om_theme'));
	  register_nav_menu('footer-menu', __('Footer Menu', 'om_theme'));
	  register_nav_menu('menu-404', __('Menu for 404 Error page', 'om_theme'));
	}

	add_action('init', 'om_register_menu');
}

if( !function_exists( 'om_primary_menu_fallback' ) ) {
	function om_primary_menu_fallback($args) {
	  $menu=wp_page_menu(array(
	  	'echo' => false,
	 	));
	 	$args['menu_class'].=' primary-menu-fallback';
	 	$menu=str_replace('<div class="menu"><ul>','<div class="menu"><ul class="'.esc_attr($args['menu_class']).'">',$menu);
	 	if(isset($args) && $args['echo'] == false)
	 		return $menu;
	 	else
	 		echo om_esc_wpcf($menu);
	}
}

/*************************************************************************************
 *	Set Max Content Width
 *************************************************************************************/
 
if ( ! isset( $content_width ) ) $content_width = 1000;

/*************************************************************************************
 *	Post Formats
 *************************************************************************************/

if( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-formats', array(
			'audio',
			'gallery', 
			'image', 
			'link', 
			'quote', 
			'video',
	)); 
}

/*************************************************************************************
 *	Post Thumbnails
 *************************************************************************************/

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 144, 144, true );
//add_image_size( 'admin-prev', 144, 144);

/*************************************************************************************
 *	Automatic Feed Links
 *************************************************************************************/

add_theme_support( 'automatic-feed-links' );

/*************************************************************************************
 *	Remove Read More Jump
 *************************************************************************************/

if( !function_exists( 'om_remove_more_jump_link' ) ) {
	function om_remove_more_jump_link($link) {
		$offset = strpos($link, '#more-');
		if ($offset !== false) {
			$end = strpos($link, '"',$offset);
			$link = substr_replace($link, '', $offset, $end-$offset);
		}
	
		return $link;
	}
	add_filter('the_content_more_link', 'om_remove_more_jump_link');
}

/*************************************************************************************
 *	Register Sidebars
 *************************************************************************************/


if( !function_exists('om_widgets_init') ) {
	function om_widgets_init() {
		
		register_sidebar(array(
			'name' => __('Main Sidebar','om_theme'),
			'id' => 'sidebar-1',
			'description' => __('Sidebar that appears on the right/left (depends on Theme Options)','om_theme'),
			'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s"><div class="sidebar-widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="sidebar-widget-title">',
			'after_title' => '</div>',
		));
	
		$footer_columns_layout=get_option(OM_THEME_PREFIX.'footer_layout');
		if( $footer_columns_layout == '1v4-1v4-1v4-1v4')
			$footer_columns=array(
				'footer-column-1'=>__('Footer 1st Column 1/4','om_theme'),
				'footer-column-2'=>__('Footer 2nd Column 1/4','om_theme'),
				'footer-column-3'=>__('Footer 3rd Column 1/4','om_theme'),
				'footer-column-4'=>__('Footer 4th Column 1/4','om_theme'),
			);
		elseif( $footer_columns_layout == '2v4-1v4-1v4')
			$footer_columns=array(
				'footer-column-1'=>__('Footer 1st Column 2/4','om_theme'),
				'footer-column-2'=>__('Footer 2nd Column 1/4','om_theme'),
				'footer-column-3'=>__('Footer 3rd Column 1/4','om_theme'),
			);
		elseif( $footer_columns_layout == '1v4-1v4-2v4')
			$footer_columns=array(
				'footer-column-1'=>__('Footer 1st Column 1/4','om_theme'),
				'footer-column-2'=>__('Footer 2nd Column 1/4','om_theme'),
				'footer-column-3'=>__('Footer 3rd Column 2/4','om_theme'),
			);
		elseif( $footer_columns_layout == '1v3-1v3-1v3')
			$footer_columns=array(
				'footer-column-1'=>__('Footer 1st Column 1/3','om_theme'),
				'footer-column-2'=>__('Footer 2nd Column 1/3','om_theme'),
				'footer-column-3'=>__('Footer 3rd Column 1/3','om_theme'),
			);
		elseif( $footer_columns_layout == '2v3-1v3')
			$footer_columns=array(
				'footer-column-1'=>__('Footer 1st Column 2/3','om_theme'),
				'footer-column-2'=>__('Footer 2nd Column 1/3','om_theme'),
			);
		elseif( $footer_columns_layout == '1v3-2v3')
			$footer_columns=array(
				'footer-column-1'=>__('Footer 1st Column 1/3','om_theme'),
				'footer-column-2'=>__('Footer 2nd Column 2/3','om_theme'),
			);
		elseif( $footer_columns_layout == '1v2-1v2')
			$footer_columns=array(
				'footer-column-1'=>__('Footer 1st Column 1/2','om_theme'),
				'footer-column-2'=>__('Footer 2nd Column 1/2','om_theme'),
			);
		else
			$footer_columns=array(
				'footer-column-1'=>__('Footer','om_theme'),
			);
	
		foreach($footer_columns as $id=>$name) {
			register_sidebar(array(
				'name' => $name,
				'description' => __('Appears in the footer of the site','om_theme'),
				'id' => $id,
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s"><div class="footer-widget-inner">',
				'after_widget' => '</div></div>',
				'before_title' => '<div class="footer-widget-title">',
				'after_title' => '</div>',
			));	
		}
	
	
		$sidebars=get_option(OM_THEME_PREFIX."extra_sidebars");
		if(is_array($sidebars)) {
			foreach($sidebars as $k=>$v) {
				register_sidebar(array(
					'name' => __('Extra:','om_theme').' '.$v,
					'description' => __('This is an extra sidebar - it can be displayed on specific page instead of "Main sidebar"','om_theme'),
					'id' => 'extra-'.$k,
					'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s"><div class="sidebar-widget-inner">',
					'after_widget' => '</div></div>',
					'before_title' => '<div class="sidebar-widget-title">',
					'after_title' => '</div>',
				));	
			}
		}
	}
}

add_action( 'widgets_init', 'om_widgets_init' );


/*************************************************************************************
 *	Widgets
 *************************************************************************************/

// Recent Posts
//include_once("widgets/recent-posts/recent-posts.php");

// Facebook
include_once("widgets/facebook/facebook.php");

// Latest Tweets
include_once("widgets/tweets/tweets.php");

// Apply Shortcodes for Widgets
add_filter('widget_text', 'do_shortcode');

/*************************************************************************************
 *	Front-end JS/CSS
 *************************************************************************************/

if(!function_exists('om_enqueue_scripts')) {
	function om_enqueue_scripts() {

		// styles
		wp_enqueue_style('om_style', get_stylesheet_uri(), array(), OM_THEME_VERSION);
		if(get_option(OM_THEME_PREFIX . 'responsive') == 'true') {
			wp_enqueue_style('responsive-mobile', TEMPLATE_DIR_URI.'/css/responsive-mobile.css');
		}

		wp_enqueue_style('omFont', TEMPLATE_DIR_URI.'/libraries/omFont/omFont.css');
		if( isset( $GLOBALS['wp_styles']->registered[ 'font-awesome' ] ) ) {
			if ( ( defined( 'WPB_VC_VERSION' ) && $GLOBALS['wp_styles']->registered[ 'font-awesome' ]->ver == WPB_VC_VERSION ) || version_compare( $GLOBALS['wp_styles']->registered[ 'font-awesome' ]->ver , '4.3.0', '<'))
				wp_deregister_style('font-awesome');
		}
		wp_register_style('font-awesome', TEMPLATE_DIR_URI.'/libraries/fontawesome/css/font-awesome.min.css', array(), '4.3.0');
		wp_register_style('linecons-omfi-ext', TEMPLATE_DIR_URI.'/libraries/linecons/style.css');
		wp_register_style('typicons', TEMPLATE_DIR_URI.'/libraries/typicons/typicons.css');
		
		if(ommb_check_slider_exists('lslider')) {
			wp_enqueue_style('layerslider-custom-skins', TEMPLATE_DIR_URI.'/css/layerslider/skins.css');
		}

		if( ! in_array(get_option(OM_THEME_PREFIX . 'prettyphoto_lightbox'), array('disabled','disabled_no_action')) ) {
			wp_deregister_style('prettyphoto');
			wp_deregister_script('prettyphoto');
			wp_enqueue_style('prettyphoto', TEMPLATE_DIR_URI.'/libraries/prettyphoto/css/prettyPhoto.custom.css');
			wp_enqueue_script('prettyphoto', TEMPLATE_DIR_URI.'/libraries/prettyphoto/js/jquery.prettyPhoto.custom.min.js', array('jquery'), false, true);
		}

		// scripts

		if(isset($GLOBALS['wp_scripts']->registered['mediaelement'])) {
			if(version_compare($GLOBALS['wp_scripts']->registered['mediaelement']->ver, '2.13.0', '<=')) {
				$GLOBALS['wp_scripts']->registered['mediaelement']->src=TEMPLATE_DIR_URI.'/js/mediaelement-and-player.min.js';
			}
		}
				
		wp_enqueue_script('jquery');
		wp_enqueue_script('google_charts', "https://www.gstatic.com/charts/loader.js");
		//wp_enqueue_script('hoverIntent');
		wp_enqueue_script('omLibraries', TEMPLATE_DIR_URI.'/js/libraries.js', array('jquery'), false, true);
		wp_enqueue_script('superfish', TEMPLATE_DIR_URI.'/js/jquery.superfish.min.js', array('jquery'), false, true);
		wp_enqueue_script('omSlider', TEMPLATE_DIR_URI.'/js/jquery.omslider.min.js', array('jquery'), false, true);
		if(get_option(OM_THEME_PREFIX."lazyload") == 'true') {
			wp_enqueue_script('lazyload', TEMPLATE_DIR_URI.'/js/jquery.lazyload.min.js', array('jquery'), false, true);
		}
		wp_enqueue_script('om-isotope', TEMPLATE_DIR_URI.'/js/isotope.pkgd.om.min.js', array('jquery'), false, true);
		wp_enqueue_script('waypoints', TEMPLATE_DIR_URI.'/js/jquery.waypoints.min.js', array('jquery'), false, true);
		wp_enqueue_script('om_custom', TEMPLATE_DIR_URI.'/js/custom.js', array('jquery','omLibraries', 'google_charts'), OM_THEME_VERSION, true);
		wp_enqueue_script('youtube_google_analytics', TEMPLATE_DIR_URI.'/js/youtube-google-analytics-8.0.2/lunametrics-youtube.gtm.js', array('jquery'), OM_THEME_VERSION, true);

		if(get_option(OM_THEME_PREFIX . 'disable_smoothscroll') != 'true') {
			wp_enqueue_script('smoothscroll', TEMPLATE_DIR_URI.'/js/jquery.smoothscroll.js', array(), false, true);
		}
		
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
		
		wp_register_script('linecons-omfi-ext-loader', TEMPLATE_DIR_URI.'/libraries/linecons/loader.js', array(), false, true);
		wp_register_script('typicons-loader', TEMPLATE_DIR_URI.'/libraries/typicons/loader.js', array(), false, true);
		wp_register_script('font-awesome-loader', TEMPLATE_DIR_URI.'/libraries/fontawesome/loader.js', array(), false, true);

		wp_enqueue_style('custom', TEMPLATE_DIR_URI.'/custom.css');
  }

	add_action('wp_enqueue_scripts', 'om_enqueue_scripts');
}

// theme custom css block
if(!function_exists('om_custom_css_block')) {
	function om_custom_css_block() {
		
		$custom_css=get_option(OM_THEME_PREFIX . 'code_custom_css');
		if($custom_css)
			echo '<style>'.om_esc_css($custom_css).'</style>';
	
  }
	add_action('wp_head', 'om_custom_css_block');
}

/*************************************************************************************
 *	Plugins Inclusion
 *************************************************************************************/

require_once (TEMPLATE_DIR . '/libraries/om-metaboxes/om-metaboxes.php');
require_once (TEMPLATE_DIR . '/libraries/aq_resizer/aq_resizer.php');

require_once ( locate_template ( 'functions/misc.php' ) );
require_once ( locate_template ( 'functions/colors.php' ) );
require_once ( locate_template ( 'functions/styling.php' ) );
require_once ( locate_template ( 'functions/social-icons.php' ) );
require_once ( locate_template ( 'functions/templates.php' ) );
require_once ( locate_template ( 'functions/breadcrumbs.php' ) );
require_once ( locate_template ( 'functions/comments.php' ) );
require_once ( locate_template ( 'functions/facebook-comments.php' ) );
require_once ( locate_template ( 'functions/images.php' ) );
require_once ( locate_template ( 'functions/portfolio.php' ) );
require_once ( locate_template ( 'functions/gallery-interface.php' ) );
require_once ( locate_template ( 'functions/customization.php' ) );
//require_once ( locate_template ( 'functions/woocommerce.php' ) );
require_once ( locate_template ( 'functions/bbpress.php' ) );
require_once ( locate_template ( 'functions/megamenu.php' ) );
require_once ( locate_template ( 'functions/icons.php' ) );
if ( defined( 'WPB_VC_VERSION' ) && version_compare(WPB_VC_VERSION, '4.6', '<') )
	require_once ( locate_template ( 'wpb-4.5/wpb.php' ) );
else 
	require_once ( locate_template ( 'wpb/wpb.php' ) );
require_once ( locate_template ( 'functions/custom-javascript.php' ) );

if(is_admin()) {
	require_once (TEMPLATE_DIR . '/libraries/om-import-tool/om-import-tool.php');

	require_once ( locate_template ( 'functions/plugins.php' ) );
	require_once ( locate_template ( 'functions/common-meta.php' ) );
	require_once ( locate_template ( 'functions/metaboxes-theme.php' ) );
	require_once ( locate_template ( 'functions/page-meta.php' ) );
	require_once ( locate_template ( 'functions/post-meta.php' ) );
	require_once ( locate_template ( 'functions/sidebars-manager.php' ) );
	require_once ( locate_template ( 'functions/theme-update.php' ) );
	require_once ( locate_template ( 'functions/theme-options.php' ) );
}

/*************************************************************************************
 *	Favicon
 *************************************************************************************/

if ( !function_exists( 'om_favicon' ) ) {
	function om_favicon() {
		if ($tmp = get_option(OM_THEME_PREFIX . 'favicon')) {
			echo '<link rel="shortcut icon" href="'. esc_attr($tmp) .'" />';
		}
	}
	add_action('wp_head', 'om_favicon');
}

/*************************************************************************************
 *	Embed wrap
 *************************************************************************************/

function om_embed_oembed_html($html) {
	
	if(strpos($html, '<blockquote class="twitter-tweet"') === false)
		return '<div class="responsive-embed">'.$html.'</div>';
	else
		return $html;
	
}
add_filter('embed_oembed_html', 'om_embed_oembed_html');

/*************************************************************************************
 *	Title
 *************************************************************************************/

function om_title_tag() {
   add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'om_title_tag' );

if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function om_wp_title($title) {
		$title .= get_bloginfo('name');
		return $title;
	}
	
	function om_theme_render_title() {
		if (!defined('WPSEO_VERSION')) {
			add_filter('wp_title','om_wp_title');
			?><title><?php wp_title('|', true, 'right'); ?></title><?php
    } else { //If WordPress SEO by Yoast is activated
			?><title><?php wp_title(''); ?></title><?php
    }
	}
	add_action( 'wp_head', 'om_theme_render_title' );
}

/*************************************************************************************
 *	CSS loaded in footer validation error
 *************************************************************************************/

add_filter('style_loader_tag', 'om_add_property_stylesheet', 10, 2);
function om_add_property_stylesheet($tag, $handle) {
	$tag=str_replace("<link rel='stylesheet'", "<link rel='stylesheet' property='stylesheet'", $tag);
	return $tag;
}

/*************************************************************************************
 *	Google Analytics Code
 *************************************************************************************/
 
if(!function_exists('om_google_analytics_code')) {
	function om_google_analytics_code() {
		
		$id=get_option(OM_THEME_PREFIX . 'google_tracking_id');
		if($id) {
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo esc_attr($id); ?>', 'auto');
  ga('send', 'pageview');

  console.log(ga);

</script>
<?php
		}

  }
	add_action('wp_footer', 'om_google_analytics_code');
}

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function example_add_dashboard_widgets() {

	wp_add_dashboard_widget(
                 'example_dashboard_widget',         // Widget slug.
                 'RECEIVE $500 in CASH FOR A WEBSITE REFERRAL!!',         // Title.
                 'example_dashboard_widget_function' // Display function.
        );	
}
add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );




/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function example_dashboard_widget_function() {

	// Display whatever it is you want to show.
	echo "<span style='width:100%'><a href='http://www.sayenkodesign.com'><img alt='Seattle Web Design' src='http://www.sayenkodesign.com/wp-content/uploads/2014/08/Sayenko-Design-WP-Referral-Bonus-460.jpg' width='486px'></a></span>
</br>
</br>

Simply introduce us via email along with the prospects phone number. Email introductions can be sent to <a href='mailto:mike@sayenkodesign.com'>mike@sayenkodesign.com</a>";
} 


?>



<?php
function remove_menus(){
  

  remove_menu_page( 'edit-comments.php' );          //Comments
 
  
}
add_action( 'admin_menu', 'remove_menus' );


/*************************************************************************************
 *	Menu stuffs
 *************************************************************************************/
add_action( 'add_meta_boxes', function() {
	add_meta_box('alt_menu_sectionid', __('Page Override'), 'alt_menu_meta_box_view', 'post', 'side', 'high');
	add_meta_box('alt_menu_sectionid', __('Page Override'), 'alt_menu_meta_box_view', 'page', 'side', 'high');
});

function alt_menu_meta_box_view($post) {
	wp_nonce_field( 'alt_menu_save_meta_box_data', 'alt_menu_meta_box_view_nonce' );
	$value_menu = esc_attr(get_post_meta( $post->ID, 'alt_menu', true ));
	$value_text = esc_attr(get_post_meta( $post->ID, 'alt_text', true ));
	$value_url = esc_attr(get_post_meta( $post->ID, 'alt_url', true ));

	$label_menu = __('Select a menu for this page');
	$label_url = __('Mobile Menu Button URL');
	$label_text = __('Mobile Menu Button Text');
	$label_empty = __('Leave empty for theme default');

	$menus = get_terms('nav_menu', array('hide_empty' => false));
	if(!$menus){
		$select_menu = __("No menus have been built");
	} else {
		if(!is_array($menus)) {
			$menus = [$menus];
		}
		$default = new stdClass();
		$default->term_id = 0;
		$default->name = "Theme default";
		array_unshift($menus, $default);
		$options = '';
		foreach($menus as $menu) {
			if($value_menu == $menu->term_id || (!$value_menu && $menu->term_id == 0)) {
				$options .= '<option value="' . $menu->term_id . '" selected="selected">' . $menu->name . '</option>';
			} else {
				$options .= '<option value="' . $menu->term_id . '">' . $menu->name . '</option>';
			}
		}
		$select_menu = '<select id="alt_menu" name="alt_menu" class="postbox">' . $options . '</select>';
	}

	echo <<<HTML
		<p><strong>$label_menu</strong></p>
		$select_menu
		<p>$label_text <br/> <small>$label_empty</small></p>
		<input id="alt_text" name="alt_text" type="text" value="$value_text"/>
		<p>$label_url <br/> <small>$label_empty</small></p>
		<input id="alt_url" name="alt_url" type="text" value="$value_url"/>
HTML;
}

function alt_menu_save_meta_box_data( $post_id ) {
	// incorrect nonce or draft or empty value
	if (
			!isset($_POST['alt_menu_meta_box_view_nonce'])
			|| !wp_verify_nonce($_POST['alt_menu_meta_box_view_nonce'], 'alt_menu_save_meta_box_data')
			|| (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			|| !isset($_POST['alt_menu'])
	) {
		return;
	}

	// permissions
	if (isset($_POST['post_type'] ) && 'page' == $_POST['post_type']) {
		if (!current_user_can( 'edit_page', $post_id)) {
			return;
		}
	} else {
		if (!current_user_can( 'edit_post', $post_id)) {
			return;
		}
	}

	$alt_menu = sanitize_text_field( $_POST['alt_menu'] );
	$alt_text = sanitize_text_field( $_POST['alt_text'] );
	$alt_url = sanitize_text_field( $_POST['alt_url'] );
	update_post_meta( $post_id, 'alt_menu', $alt_menu );
	update_post_meta( $post_id, 'alt_text', $alt_text );
	update_post_meta( $post_id, 'alt_url', $alt_url );
}
add_action( 'save_post', 'alt_menu_save_meta_box_data' );
?>