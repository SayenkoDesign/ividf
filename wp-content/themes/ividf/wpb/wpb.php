<?php

function om_wpb_activated() {
	return defined( 'WPB_VC_VERSION' );
}

function om_vc_set_as_theme() {
	vc_set_as_theme(true);
}
add_action( 'vc_before_init', 'om_vc_set_as_theme' );

/******************************************/

if( om_wpb_activated() && get_option(OM_THEME_PREFIX . 'disable_wpb_addons') != 'true' ) {

	function om_wpb_remove_grid() {
		if(defined('VC_PAGE_MAIN_SLUG') && class_exists('Vc_Grid_Item_Editor')) {
			remove_submenu_page(VC_PAGE_MAIN_SLUG, 'edit.php?post_type=' . rawurlencode( Vc_Grid_Item_Editor::postType() ));
			
			global $wp_post_types;
			if(isset($wp_post_types['vc_grid_item'])) {
				unset($wp_post_types['vc_grid_item']);
			}
		}
	}
	add_action('vc_menu_page_build', 'om_wpb_remove_grid', 20);
	
	vc_set_shortcodes_templates_dir(TEMPLATE_DIR . '/wpb/vc_templates/');
		
	require_once (TEMPLATE_DIR . '/wpb/functions/attribute-types.php');
	require_once (TEMPLATE_DIR . '/wpb/functions/options.php');
	require_once (TEMPLATE_DIR . '/wpb/functions/misc.php');
	require_once (TEMPLATE_DIR . '/wpb/functions/custom_shortcodes.php');
	require_once (TEMPLATE_DIR . '/wpb/functions/modifications.php');

	// Testimonials
	if(isset($GLOBALS['omTestimonialsPlugin']))
		include_once (TEMPLATE_DIR . '/widgets/testimonials/testimonials.php');
	
	/**
	 * Styles & Scripts
	 */
	
	function om_wpb_admin_scripts() {
		if ( in_array( get_post_type(), vc_editor_post_types() )) {
			wp_enqueue_style( 'om_wpb_admin_styles', TEMPLATE_DIR_URI . '/wpb/assets/css/wpb-admin.css', array(), OM_THEME_VERSION );
			//wp_enqueue_script( 'om_wpb_custom_views', TEMPLATE_DIR_URI . '/wpb/assets/js/custom-views.js', array('jquery'), OM_THEME_VERSION, true);
		}
	}
	add_action( 'admin_enqueue_scripts', 'om_wpb_admin_scripts' );
	
	function om_wpb_front_scripts() {
		wp_register_script( 'vc_pie', TEMPLATE_DIR_URI . '/wpb/assets/js/jquery.vc_chart.js', array( 'jquery', 'waypoints', 'progressCircle' ), OM_THEME_VERSION, true );

		wp_register_script( 'om_js_composer_front', TEMPLATE_DIR_URI . '/wpb/assets/js/addon_js_composer_front.js', array('jquery', 'omLibraries', 'waypoints'), OM_THEME_VERSION, true );
		
		wp_register_script( 'om_charts', TEMPLATE_DIR_URI . '/wpb/assets/js/chart.min.js', array('jquery', 'omLibraries', 'waypoints'), OM_THEME_VERSION, true );
		// add dependency to make sure that om_js_composer_front will be loaded always before wpb_composer_front_js
		if(isset($GLOBALS['wp_scripts']->registered['wpb_composer_front_js']))
			$GLOBALS['wp_scripts']->registered['wpb_composer_front_js']->deps[]='om_js_composer_front';
	}
	add_action( 'wp_enqueue_scripts', 'om_wpb_front_scripts' );
	
	
	
	function om_wpb_head_styles() {
		if ( in_array( get_post_type(), vc_editor_post_types() )) {
			echo '<style>.vc_colored-dropdown .om-theme-color{background-color:'.get_option(OM_THEME_PREFIX . 'hightlight_color').';color:#fff !important}</style>';
		}
	}
	add_action('admin_head', 'om_wpb_head_styles');


	if(isset($_GET['vc_editable']) && $_GET['vc_editable'] == 'true') { //frontend editor activated
		add_filter('pre_option_' . OM_THEME_PREFIX . 'lazyload', '__return_empty_string');
	}
	
	// remove welcome screen of VC
	remove_action( 'vc_activation_hook', 'vc_page_welcome_set_redirect' );
	remove_action( 'init', 'vc_page_welcome_redirect' );
	
} else {
	
	function om_wpb_detect($post) {
		return false;
	}
	
}