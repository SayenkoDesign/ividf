<?php

/**
 * Header Slider
 */

if(!function_exists('om_tpl_header_slider')) {
	function om_tpl_header_slider($slider) {
		
		include TEMPLATE_DIR . '/includes/header-slider.php';
		
	}
}

/**
 * Page title
 */

if(!function_exists('om_tpl_page_title')) {
	function om_tpl_page_title($post_id, $post_title) {
		
		include TEMPLATE_DIR . '/includes/page-title.php';
		
	}
}