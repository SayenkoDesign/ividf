<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-counter wpb_content_element' . $el_class, 'om_counter', $atts ));

$duration=intval($duration);

$classes_number=array('vc_om-counter-number');
$styles_number=array();

if($size)
	$classes[]='vc_om-size-'.$size;
	
if($color == 'om-theme-color') {
	$classes[]='vc_om-om-theme-color';
} elseif($color == 'custom') {
	if($custom_color) {
		$styles_number[]='color:'.$custom_color;
	}
} else {
	if($tmp=om_wpb_get_std_color_code($color)) {
		$styles_number[]='color:'.$tmp;
	}
}
			
echo
	'<div class="'.implode(' ',$classes).'"'.($number?' data-count="'.intval($number).'"':'').($prefix?' data-prefix="'.$prefix.'"':'').($suffix?' data-suffix="'.$suffix.'"':'').($duration?' data-duration="'.$duration.'"':'').'>'.
		'<div class="'.implode(' ',$classes_number).'"'.($styles_number ? ' style="'.implode(';',$styles_number).'"' : '').'>'.$prefix.$number.$suffix.'</div>'.
		($title ? '<div class="vc_om-counter-title">'.$title.'</div>' : '').
	'</div>'
;

