<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


if($el_class)
	$el_class=' '.$el_class;

$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-moving-box wpb_content_element' . $el_class, $this->settings['base'], $atts ));
$styles=array();

if($align)
	$styles[]='text-align:'.$align;

$content='';
if($content_type == 'image' && $img) {
	$src = om_img_any_resize($img, $img_size);
	if($src) {
		$content='<img src="'.$src.'" class="om-moving-'.$animation.'" alt="" />';
	}
} elseif($content_type == 'icon' && $icon_type && isset( ${"icon_" . $icon_type} )) {

	vc_icon_element_fonts_enqueue( $icon_type );
	
	if($color == 'om-theme-color') {
		$classes[]='om-hl-color';
	} elseif($color == 'custom') {
		if($custom_color) {
			$styles[]='color:'.$custom_color;
		}
	} else {
		if($tmp=om_wpb_get_std_color_code($color)) {
			$styles[]='color:'.$tmp;
		}
	}
	
	if(is_numeric($icon_size))
		$icon_size.='px';
		
	$content='<i class="'.${"icon_" . $icon_type}.' om-moving-'.$animation.'"'.($icon_size ? ' style="font-size:'.$icon_size.'"' : '').'></i>';
}

if($content)
	echo '<div class="'.implode(' ',$classes).'"'.(!empty($styles) ? ' style="'.implode(';',$styles).'"' : '').'>'.$content.'</div>';
