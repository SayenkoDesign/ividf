<?php

/**
 * Plugin Name: IVIDF Portfolio
 * Plugin URI: http://sayenkodesign.com/
 * Description: Portfolio
 * Version: 2.0.2
 * Author: Sayenko Design
 * Author URI: http://sayenkodesign.com/
 */

$plugin_dir_url=plugin_dir_url( __FILE__ );

$GLOBALS['omPortfolioPlugin'] = array(
	'version' => '2.0.2',
	'path' => plugin_dir_path( __FILE__ ),
	'path_url' => $plugin_dir_url,
	'plugin_basename' => plugin_basename( __FILE__ ),
	'config' => array(
		'display_options_page' => true,
		'include_custom_post_meta_js' => true,
		'include_front_css' => true,
		'include_front_js' => true,
		'include_isotope_js' => true,
		'scripts_in_footer' => true,
		'include_min_scripts' => true,
		'fit_thumbnails_height' => true,
		'theme_supplies_page_template' => false,
		'theme_supplies_portfolio_single_template' => false,
		'theme_supplies_portfolio_archive_template' => false,
		'theme_support_width100' => false,
		'theme_support_portfolio_width100' => false,
		'enable_lazyload_markup' => false,
		'infinite_scroll_portion' => '16',
		'update_api_url' => 'http://update-api.olevmedia.net/',
		'lazyload_placeholder' => $plugin_dir_url . 'assets/img/e.png',
		'thumbnail_sizes' => array(
			'xsmall' => array(
				'width' => 245,
			),
			'small' => array(
				'width' => 316,
			),
			'medium' => array(
				'width' => 435,
			),
			'large' => array(
				'width' => 676,
			),
			'xsmall-full' => array(
				'width' => 384,
			),
			'small-full' => array(
				'width' => 480,
			),
			'medium-full' => array(
				'width' => 640,
			),
			'large-full' => array(
				'width' => 960,
			),
		),
		'single_page_image_sizes' => array(
			'width100' => array(
				'width' => 1400,
			),
			'full' => array(
				'width' => 1400,
			),
			'2v1' => array(
				'width' => 930,
			),
			'1v1' => array(
				'width' => 700,
			),
			'1v2' => array(
				'width' => 465,
			),
		),
		'responsive_mode' => true,
		/*
		'responsive_bounds' => array(
			//'tablet' => array('from' => 768, 'to' => 959),
			'mobile' => array('from' => false, 'to' => 767),
		),
		*/
		'preview_items_per_row' => array(
			'xsmall' => 5,
			'small' => 4,
			'medium' => 3,
			'large' => 2,
		),
	),
);


function ompf_get_config_from_theme() {
	$GLOBALS['omPortfolioPlugin']['config'] = apply_filters('ompf_config', $GLOBALS['omPortfolioPlugin']['config']);
}
add_action('init', 'ompf_get_config_from_theme');


load_plugin_textdomain( 'om_portfolio', false, $GLOBALS['omPortfolioPlugin']['path'] . 'languages/' );

function ompf_activation_hook() {
	update_option('ompf_plugin_just_activated', 1);
	update_option('ompf_do_flush_rewrite_rules', 1);
}
register_activation_hook( __FILE__, 'ompf_activation_hook' );

add_theme_support( 'post-thumbnails', array( 'portfolio' ) );

function ompf_enqueue_admin_scripts($hook) {
	if('edit.php' == $hook && isset($_GET['post_type']) && $_GET['post_type'] == 'portfolio')
		wp_enqueue_style('ompf-styles', $GLOBALS['omPortfolioPlugin']['path_url'].'assets/css/admin-edit.css' );
}
add_action('admin_enqueue_scripts', 'ompf_enqueue_admin_scripts');

include_once( 'functions/misc.php' );
include_once( 'functions/options.php' );
include_once( 'functions/options-interface.php' );
include_once( 'libraries/ompf-metaboxes/ompf-metaboxes.php' );
include_once( 'libraries/aq_resizer/aq_resizer.php' );
include_once( 'functions/custom-post.php' );
include_once( 'functions/custom-post-meta.php' );
include_once( 'functions/page-meta.php' );
include_once( 'functions/portfolio.php' );
include_once( 'functions/portfolio-archive.php' );
include_once( 'functions/portfolio-single.php' );
include_once( 'functions/shortcodes.php' );
include_once( 'widgets/portfolio/portfolio.php' );
include_once( 'functions/portfolio-ajax.php' );