<?php

function om_wpb_attribute_attach_video($settings, $value) {
	$dependency = vc_generate_dependencies_attributes($settings);
	return
   	'<div class="'.$settings['type'].'_field_block">'.
			'<input name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-textinput '.$settings['param_name'].' '.$settings['type'].'_field" id="wpb_'.$settings['param_name'].'_value" type="text" value="'.$value.'" ' . $dependency . ' style="width:75%;"/>'.
			' <a href="#" class="button wpb-vc-button om-wpb-browse-button" rel="wpb_'.$settings['param_name'].'_value" data-library="video" data-choose="Choose a file" data-select="Select">Browse</a>'.
		'</div>'
	;
}
add_shortcode_param('attach_video', 'om_wpb_attribute_attach_video', TEMPLATE_DIR_URI . '/wpb/assets/js/attributes.js');


function om_wpb_attribute_om_get_code($settings, $value) {
	$dependency = vc_generate_dependencies_attributes($settings);
	return
   	'<div class="'.$settings['type'].'_field_block">'.
   		'<a href="#" class="button om_get_code_button" data-output-id="wpb_'.$settings['param_name'].'_value">'.__('Get code','om_theme').'</a>'.
			'<textarea id="wpb_'.$settings['param_name'].'_value" style="display:none" rows="3" readonly="readonly"></textarea>'.
		'</div>'
	;
}
add_shortcode_param('om_get_code', 'om_wpb_attribute_om_get_code', TEMPLATE_DIR_URI . '/wpb/assets/js/attributes.js');

function om_wpb_attribute_om_info($settings, $value) {
	return
   	'<div class="'.$settings['type'].'_field_block">'.
		'</div>'
	;
}
add_shortcode_param('om_info', 'om_wpb_attribute_om_info');

function om_wpb_attribute_om_categories($settings, $value) {
	$dependency = vc_generate_dependencies_attributes($settings);

	$args = array(
		'show_option_all'    => __('All Categories', 'om_theme'),
		'show_option_none'   => '',
		'orderby' => 'name',
		'hide_empty'         => 0, 
		'echo'               => 0,
		'selected'           => $value,
		'hierarchical'       => 1, 
		'name'               => $settings['param_name'],
		'id'         		     => 'wpb_'.$settings['param_name'].'_value',
		'class'              => 'wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field',
		'depth'              => 4,
		'tab_index'          => 0,
		'taxonomy'           => 'category',
		'hide_if_empty'      => false 	
	);
	
	if(isset($settings['args'])) {
		$args=array_merge($args, $settings['args']);
	}

	$select = wp_dropdown_categories( $args );
	$select = str_replace('<select', '<select '.$dependency.' ', $select);

	return
   	'<div class="'.$settings['type'].'_field_block">'.
			$select.
		'</div>'
	;
}
add_shortcode_param('om_categories', 'om_wpb_attribute_om_categories', TEMPLATE_DIR_URI . '/wpb/assets/js/attributes.js');

function om_wpb_attribute_om_categories_multiple($settings, $value) {
	$dependency = vc_generate_dependencies_attributes($settings);

	$args = array(
		'show_option_all'    => __('All Categories', 'om_theme'),
		'show_option_none'   => '',
		'orderby' => 'name',
		'hide_empty'         => 0, 
		'echo'               => 0,
		'selected'           => $value,
		'hierarchical'       => 1, 
		'name'               => $settings['param_name'],
		'id'         		     => 'wpb_'.$settings['param_name'].'_value',
		'class'              => 'wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field',
		'depth'              => 4,
		'tab_index'          => 0,
		'taxonomy'           => 'category',
		'hide_if_empty'      => false 	
	);
	
	if(isset($settings['args'])) {
		$args=array_merge($args, $settings['args']);
	}

	$select = wp_dropdown_categories( $args );
	$select = str_replace('<select', '<select multiple="multiple" size="4" '.$dependency.' ', $select);

	return
   	'<div class="'.$settings['type'].'_field_block">'.
			$select.
		'</div>'
	;
}
add_shortcode_param('om_categories_multiple', 'om_wpb_attribute_om_categories_multiple', TEMPLATE_DIR_URI . '/wpb/assets/js/attributes.js');