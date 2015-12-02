<?php



/**
 * Remove WPB Elements
 */

function om_wpb_remove_elements() { 
	vc_remove_element('vc_posts_slider');
	vc_remove_element('vc_cta_button');
}
add_action( 'init', 'om_wpb_remove_elements' );
 
/**
 * Sort WPB Elements
 */

function om_wpb_sort_elements() {
	$elements = array (
		'vc_row',
		'vc_column_text',
		'vc_separator',
		'vc_text_separator',
		'om_icon_separator',
		'vc_message',
		'vc_facebook',
		'vc_tweetmeme',
		'vc_googleplus',
		'vc_pinterest',
		'vc_toggle',
		'vc_single_image',
		'vc_gallery',
		'vc_images_carousel',
		'vc_tabs',
		'vc_tour',
		'vc_accordion',
		'vc_btn',
		'vc_cta',
		'vc_icon',
		'vc_video',
		'vc_gmaps',
		'vc_raw_html',
		'vc_raw_js',
		'vc_flickr',
		'vc_progress_bar',
		'vc_pie',
		'vc_empty_space',
		'vc_custom_heading',
		
		'om_box',
		'om_counter',
		'om_a_button',
		'om_pricing_table',
		'om_pricing_table_column',
		'om_html_table',
		'om_posts',
		'om_testimonials',
		'om_portfolio',
		'om_logos',
		'om_chart',
		'om_person',
		'om_click_box',
		'om_moving_box',
		'om_click_icon_box',
		'om_click_icon_box2',
		'om_teaser',
	);
	
	$elements=array_reverse($elements);
	$w=10;
	foreach($elements as $v) {
		if(WPBMap::exists($v)) {
			vc_map_update($v, array( 'weight' => $w ));
			$w+=10;
		}
	}
}

add_action( 'init', 'om_wpb_sort_elements' );

/**
 * Widget Titles
 */
 

function om_wpb_widget_title( $title, $params = array( 'title' => '' ) ) {
	if ( $params['title'] == '' ) return;

	$extraclass = ( isset( $params['extraclass'] ) ) ? " " . $params['extraclass'] : "";
	$output = '<div class="wpb_heading' . $extraclass . '">' . $params['title'] . '</div>';

	return $output;
}
add_filter('wpb_widget_title', 'om_wpb_widget_title', 10, 2);



/*
add_filter('vc_shortcodes_css_class', 'om_wpb_vc_shortcodes_css_class', 10, 3);

function om_wpb_vc_shortcodes_css_class($class, $tag, $atts) {

	switch($tag) {
		
		case 'vc_text_separator':

			if(isset($atts['border_w']) && $atts['border_w']) {
				$class.=' border-w-'.esc_attr($atts['border_w']);
			}
		
		break;
		
	}
	
	return $class;
	
}
*/