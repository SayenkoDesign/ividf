<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$style=1;

if($el_class)
	$el_class=' '.$el_class;

$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-pricing-table wpb_content_element' . $el_class, 'om_pricing_table', $atts ));
$classes[]='vc_om-style-'.$style;

echo '<div class="'.implode(' ',$classes).'"><div class="vc_om-pricing-table-inner">'.wpb_js_remove_wpautop($content).'</div></div>';