<?php
$output = $el_class = '';
extract(shortcode_atts(array(
'el_class' => '',
), $atts));

$el_class = $this->getExtraClass($el_class);
$content =  rawurldecode(base64_decode(strip_tags($content)));
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-table wpb_content_element' . $el_class, $this->settings['base'], $atts );
$css_class .= ' vc_om-table-style-1';

$output .= '<div class="'.esc_attr($css_class).'"><div class="wpb_wrapper">'.$content.'</div></div>';

echo  $output; // no escape needed