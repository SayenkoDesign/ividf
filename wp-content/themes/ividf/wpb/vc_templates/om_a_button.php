<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$classes = array('vc_om_a_button');
if($el_class)
	$classes[]=$el_class;
$classes[]='vc_om-style-'.$style;	
$classes[]='vc_om-size-'.$size;	
	
$styles = array();

$custom_color_code='';
if($color == 'om-theme-color') {
	$classes[]='vc_om-om-theme-color';
} elseif($color == 'custom') {
	if($custom_color) {
		$custom_color_code=$custom_color;
	}
} else {
	if($tmp=om_wpb_get_std_color_code($color)) {
		$custom_color_code=$tmp;
	}
}

if($icon_type && isset( ${"icon_" . $icon_type} )) {
	vc_icon_element_fonts_enqueue( $icon_type );
	$f_icon='<i class="'.${"icon_" . $icon_type}.'"></i>';
} else {
	$classes[]='vc_om-default-icon';
	$f_icon='<i class="vc_om-icon"></i>';
}

//parse link
$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ',$classes), $this->settings['base'], $atts );

echo
	'<a class="'. esc_attr( trim( $css_class ) ).'" href="'. $a_href .'" title="'. esc_attr( $a_title ) .'" target="'. $a_target .'"'.
	($custom_color_code ? ' data-hover-border-color="'.$custom_color_code.'"' : '' ).'>'.
	'<span class="vc_om-ab-inner">'.
		'<span class="vc_om-icon-w vc_om-before"'. ($custom_color_code && ($style == 'colored_icon' || $style == 'colored_all') ? ' style="background-color:'.$custom_color_code.'"' : '' ) .'>'. $f_icon .'</span>'.
		'<span class="vc_om-title"'. ($custom_color_code && ($style == 'colored_text' || $style == 'colored_all') ? ' style="background-color:'.$custom_color_code.'"' : '' ) .'>'. $title .'</span>'.
		'<span class="vc_om-icon-w vc_om-after"'. ($custom_color_code && ($style == 'colored_icon' || $style == 'colored_all') ? ' style="background-color:'.$custom_color_code.'"' : '' ) .'>'. $f_icon .'</span>'.
	'</span>'.
	'<span class="vc_om-brd"></span>'.
	'</a>'.
	"\n"
;
