<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if($el_class)
	$el_class=' '.$el_class;

$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-ptc' . $el_class, 'om_pricing_table_column', $atts ));

if($featured == 'yes') {
	$classes[]='vc_om-ptc-featured';
}

echo '<div class="'.implode(' ',$classes).'"><ul class="vc_om-ptc-inner">';
if($title != '') {
	echo '<li class="vc_om-ptc-title"><div class="vc_om-ptc-title-title">'.$title.'</div>'.($subtitle!='' ? '<div class="vc_om-ptc-title-comment">'.$subtitle.'</div>':'').'</li>';
}
if($price != '') {
	$price_=explode('.',str_replace(',','.',trim($price)));
	if(count($price_) == 2) {
		$price_html='<span class="vc_om-ptc-price-price">'.$price_[0].'</span><span class="vc_om-ptc-price-cents">'.$price_[1].'</span>';
	} else {
		$price_html='<span class="vc_om-ptc-price-price">'.$price.'</span>';
	}
	
	echo '<li class="vc_om-ptc-price">'.($price_prefix ? '<span class="vc_om-ptc-price-prefix">'.$price_prefix.'</span>':'').$price_html.($price_suffix ? '<span class="vc_om-ptc-price-suffix">'.$price_suffix.'</span>':'').'</li>';
}
if($options != '') {
	$options=explode("\n",$options);
	foreach($options as $option) {
		echo '<li class="vc_om-ptc-option">'.do_shortcode($option).'</li>';
	}
}
if($button_title != '') {
	echo '<li class="vc_om-ptc-button">'.do_shortcode('[om_a_button title="'.esc_attr($button_title).'" link="'.$link.'" style="colored_all" size="lg" color="om-theme-color"]').'</li>';
}
echo '</ul></div>';

