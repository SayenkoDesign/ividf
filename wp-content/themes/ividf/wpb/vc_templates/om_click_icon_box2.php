<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-click-icon-box-2 wpb_content_element' . $el_class, $this->settings['base'], $atts ));

$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

if($bg_color) {
	if($bg_color == 'om-theme-color') {
		$bg_color = get_option(OM_THEME_PREFIX . 'hightlight_color');
	} elseif($bg_color == 'custom') {
		if($bg_custom_color)
			$bg_color = $bg_custom_color ;
	} else {
		if($tmp=om_wpb_get_std_color_code($bg_color)) {
			$bg_color = $tmp;
		}
	}
}
if(!$bg_color)
	$bg_color = '#575757';

$styles[]='background-color:'.$bg_color;
$bg_alt_color=om_color_lightness($bg_color, -0.07);
$bg_alt_color2=om_color_lightness($bg_color, -0.11);

if($text_color) {
	$styles[]='color:'.$text_color;
}

echo '<div class="'.implode(' ',$classes).'"'.(!empty($styles)?' style="'.implode(';',$styles).'"':'').'>';
echo '<div class="om-cib2-corner-hover" style="border-color:'.$bg_alt_color2.'"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="-10,0 0,0 100,50 0,100 -10,100" fill="'.$bg_alt_color2.'" /></svg></div>';
echo '<div class="om-cib2-icon" style="background-color:'.$bg_alt_color.'">';
	if($icon_type && isset( ${"icon_" . $icon_type} )) {
		vc_icon_element_fonts_enqueue( $icon_type );
		echo '<div class="om-cib2-icon-wrapper"><i class="'.${"icon_" . $icon_type}.'"></i></div>';
	}
	echo '<div class="om-cib2-corner"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="-10,0 0,0 100,50 0,100 -10,100" fill="'.$bg_alt_color.'" /></svg></div>';
echo '</div>';
echo '<div class="om-cib2-content">'.($title != '' ? '<div class="om-cib2-content-title">'.$title.'</div>' : '').'<div class="om-cib2-content-text">'.wpb_js_remove_wpautop($content, true).'</div></div>';

if($a_href)
	echo '<a href="'. $a_href .'" title="'. esc_attr( $a_title ) .'" target="'. $a_target .'" class="om-cib2-link"></a>';

echo '</div>';

