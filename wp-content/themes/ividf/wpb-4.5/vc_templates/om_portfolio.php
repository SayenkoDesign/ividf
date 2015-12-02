<?php

if(isset($atts['el_class'])) {
	$el_class=' '.$atts['el_class'];
	unset($atts['el_class']);
} else {
	$el_class='';
}
if(isset($atts['title'])) {
	$title=$atts['title'];
	unset($atts['title']);
} else {
	$title='';
}

$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-portfolio wpb_content_element' . $el_class, 'om_portfolio', $atts ));

$atts_str='';
foreach($atts as $k=>$v) {
	$atts_str.=' '.$k.'="'.$v.'"';
}

echo '<div class="'.implode(' ',$classes).'">';
echo  wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_om_portfolio_heading' ) );
echo do_shortcode('[portfolio'.$atts_str.']');
echo '</div>';

