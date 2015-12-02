<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$tag_attributes=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-click-box wpb_content_element' . $el_class, $this->settings['base'], $atts ));

if($style == 'custom') {
	if($bg_color) {
		if($bg_color == 'custom') {
			if($bg_custom_color)
				$styles[]='background-color:'.$bg_custom_color;
		} else {
			if($tmp=om_wpb_get_std_color_code($bg_color)) {
				$styles[]='background-color:'.$tmp;
			}
		}
	}
	if($hover_bg_color) {
		if($hover_bg_color == 'custom') {
			if($hover_bg_custom_color)
				$tag_attributes[]='data-hover-bg-color="'.$hover_bg_custom_color.'"';
		} else {
			if($tmp=om_wpb_get_std_color_code($hover_bg_color)) {
				$tag_attributes[]='data-hover-bg-color="'.$tmp.'"';
			}
		}
	}
	if($text_color) {
		$styles[]='color:'.$text_color;
	}
} else {
	$classes[]='om-hl-bg-color';
}
$classes[]='om-cb-size-'.$size;

$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

echo '<div class="'.implode(' ',$classes).'"'.(!empty($styles)?' style="'.implode(';',$styles).'"':'').(!empty($tag_attributes) ? ' '.implode(' ',$tag_attributes) : '').'>';
if($a_href)
	echo '<a href="'. $a_href .'" title="'. esc_attr( $a_title ) .'" target="'. $a_target .'">';
echo '<span class="om-cb-inner">'.$title.'</span>';
if($a_href)
	echo '</a>';
echo '</div>';

