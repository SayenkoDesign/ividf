<?php


/**
 * Plugin Name: IVIDF Testimonials
 * Plugin URI: http://sayenkodesign.com/
 * Description: Testimonials
 * Version: 1.0.0
 * Author: Sayenko Design
 * Author URI: http://sayenkodesign.com/
 */


$plugin_dir_url=plugin_dir_url( __FILE__ );

$GLOBALS['omTestimonialsPlugin'] = array(
	'version' => '1.0.0',
	'path' => plugin_dir_path( __FILE__ ),
	'path_url' => $plugin_dir_url,
	'plugin_basename' => plugin_basename( __FILE__ ),
	'config' => array(
		'include_front_css' => true,
		'enable_lazyload_markup' => false,
		'update_api_url' => 'http://update-api.olevmedia.net/',
		'lazyload_placeholder' => $plugin_dir_url . 'assets/img/e.png',
	),
);


function omtm_get_config_from_theme() {
	$GLOBALS['omTestimonialsPlugin']['config'] = apply_filters('omtm_config', $GLOBALS['omTestimonialsPlugin']['config']);
}
add_action('init', 'omtm_get_config_from_theme');


load_plugin_textdomain( 'om_testimonials', false, $GLOBALS['omTestimonialsPlugin']['path'] . 'languages/' );

add_theme_support( 'post-thumbnails', array( 'testimonials' ) );

include_once( 'functions/plugin-update.php' );
include_once( 'functions/custom-post.php' );
include_once( 'functions/custom-post-meta.php' );
//include_once( 'functions/shortcodes.php' );
//include_once( 'widgets/testimonials/testimonials.php' );
