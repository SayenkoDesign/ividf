<?php

$atts = vc_shortcode_attribute_parse( array(
	'title' => '',
	'link' => '',
	'icon_type' => '',
	'el_class' => '',
), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$tag_attributes=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-click-icon-box wpb_content_element' . $el_class, $this->settings['base'], $atts ));

$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

echo '<div class="'.implode(' ',$classes).'">';
if($a_href)
	echo '<a href="'. $a_href .'" title="'. esc_attr( $a_title ) .'" target="'. $a_target .'">';
if($icon_type && isset( ${"icon_" . $icon_type} )) {
	vc_icon_element_fonts_enqueue( $icon_type );
	echo '<span class="om-cib-icon"><span class="om-cib-icon-inner"><i class="'.${"icon_" . $icon_type}.'"></i></span><span class="om-cib-icon-inner om-cib-back"><i class="'.${"icon_" . $icon_type}.'"></i></span></span>';
}
if($title)
	echo '<span class="om-cib-title">'.$title.'</span>';
if($content)
	echo '<span class="om-cib-content">'.wpb_js_remove_wpautop($content, true).'</span>';
if($a_href)
	echo '</a>';
echo '</div>';

