<?php
$output = $title = $link = $size = $el_class = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( $link == '' ) {
	return null;
}
$el_class = $this->getExtraClass( $el_class );

$video_w = ( isset( $content_width ) ) ? $content_width : 500;
$video_h = round($video_w / $ratio);
global $wp_embed;
$embed = $wp_embed->run_shortcode( '[embed width="' . $video_w . '" height="' . $video_h . '"]' . $link . '[/embed]' );
$embed=preg_replace('|(<iframe.*?width=)"[0-9]+"(.*?height=)"[0-9]+"(.*?>)|','$1"'.$video_w.'"$2"'.$video_h.'"$3',$embed);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'om_wpb_video_widget wpb_content_element' . $el_class . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$output .= "\n\t" . '<div class="' . $css_class . '"'.($maxwidth ? ' style="max-width:'.$maxwidth.'px;margin:0 auto"':'').'>';
$output .= wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_video_heading' ) );
$output .=  $embed ;
$output .= "\n\t" . '</div> ' . $this->endBlockComment( '.om_wpb_video_widget' );

echo  $output; // no need to escape