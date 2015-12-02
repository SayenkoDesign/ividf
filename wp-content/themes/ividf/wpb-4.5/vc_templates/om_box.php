<?php

$atts = vc_shortcode_attribute_parse( array(
	'border_width' => '',
	'border_style' => '',
	'border_color' => '',
	'border_custom_color' => '',
	'bg_color' => '',
	'bg_custom_color' => '',
	'bg_image' => '',
	'bg_image_pos' => '',
	'icon_type' => '',
	'icon_style' => '',
	'icon_shape' => '',
	'text_color' => '',
	'height' => '',
	'el_class' => '',
), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-box wpb_content_element' . $el_class, 'om_box', $atts ));

$border_width=intval($border_width);
$height=intval($height);

$border_custom_color_code=false;
$bg_custom_color_code=false;

if($border_width) {
	$classes[]='vc_om-with-border';
	$styles[]='border-width:'.$border_width.'px';
}
if($border_color == 'om-theme-color') {
	$classes[]='vc_om-border-om-theme-color';
} elseif($border_color == 'custom') {
	if($border_custom_color) {
		$styles[]='border-color:'.$border_custom_color;
		$border_custom_color_code=$border_custom_color;
	}
} else {
	if($tmp=om_wpb_get_std_color_code($border_color)) {
		$border_custom_color_code=$tmp;
		$styles[]='border-color:'.$tmp;
	}
}

if($bg_color) {
	$classes[]='vc_om-with-bg-color';
	if($bg_color == 'om-theme-color') {
		$classes[]='vc_om-bg-om-theme-color';
	} elseif($bg_color == 'custom') {
		if($bg_custom_color)
			$styles[]='background-color:'.$bg_custom_color;
			$bg_custom_color_code=$bg_custom_color;
	} else {
		if($tmp=om_wpb_get_std_color_code($bg_color)) {
			$styles[]='background-color:'.$tmp;
			$bg_custom_color_code=$tmp;
		}
	}
}
if($bg_image && ( $bg_image_url = wp_get_attachment_url( $bg_image, 'full' ) ) !== false) {
	$styles[]='background-image:url('.$bg_image_url.')';
}
if($bg_image_pos) {
	$styles=array_merge($styles, om_bg_img_pos_style($bg_image_pos));
}
if($text_color) {
	$styles[]='color:'.$text_color;
}
if($height) {
	$styles[]='min-height:'.$height.'px';
}

if($icon_type) {
	$iconClass = isset( ${"icon_" . $icon_type} ) ? ${"icon_" . $icon_type} : false;
	if($iconClass) {
		vc_icon_element_fonts_enqueue( $icon_type );

		$classes[]='vc_om-with-icon';
		
		if($icon_style) {
			$classes[]='vc_om-icon-style-'.$icon_style;
		}
		if($icon_shape) {
			$classes[]='vc_om-icon-shape-'.$icon_shape;
		}
	}
} else {
	$iconClass=false;
}
if($border_style == 'dotted') {
	$classes[]='vc_om-border-style-dotted';
}

echo '<div class="'.implode(' ',$classes).'"'.(!empty($styles)?' style="'.implode(';',$styles).'"':'').'>';
if($iconClass) {
	echo '<div class="vc_om-box-icon-wrapper"><div class="vc_om-box-icon" style="'.
		($border_width?'border-width:'.$border_width.'px;':'').
		($border_width?'margin-top:-'.($border_width*0.5).'px;margin-left:-'.$border_width.'px;':'').
		($border_width==0&&$icon_style=='bg'&&$bg_custom_color_code?'background-color:'.$bg_custom_color_code.';color:inherit':'').
		($border_width==0&&$icon_style=='border'&&$bg_custom_color_code?'background-color:'.$bg_custom_color_code.';':'').
		($icon_style=='bg'&&$border_custom_color_code?'background-color:'.$border_custom_color_code.';':'').
		($icon_style=='border'&&$bg_custom_color_code&&$border_width?'background-color:'.$bg_custom_color_code.';':'').
		($border_custom_color_code?'border-color:'.$border_custom_color_code.';':'').
		($icon_style=='border'&&$border_custom_color_code?'color:'.$border_custom_color_code.';':'').
		'"><i class="'.$iconClass.'"></i></div></div>';
}
echo '<div class="vc_om-box-inner"'.($border_width&&$iconClass?' style="padding-top:'.($border_width*2).'px"':'').'>'.wpb_js_remove_wpautop($content, true).'</div></div>';

