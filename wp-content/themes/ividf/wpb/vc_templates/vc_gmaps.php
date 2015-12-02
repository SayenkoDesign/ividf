<?php
$output = $title = $link = $size = $zoom = $type = $bubble = $el_class = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if ( $link == '' ) {
	return null;
}
$link = trim( vc_value_from_safe( $link ) );
$bubble = ( $bubble != '' && $bubble != '0' ) ? '&amp;iwloc=near' : '';
$size = str_replace( array( 'px', ' ' ), array( '', '' ), $size );

$el_class = $this->getExtraClass( $el_class );
//$el_class .= ( $size == '' ) ? ' vc_map_responsive' : '';

if ( is_numeric( $size ) ) {
	$link = preg_replace( '/height="[0-9]*"/', 'height="' . $size . '"', $link );
} else {
	$paddingb='';
	if(preg_match('|width="([0-9]+)".*?height="([0-9]+)"|',$link,$m)) {
		if($m[1] && $m[2])
			$paddingb=' style="padding-bottom:'.($m[2]/$m[1]*100).'%"';
	}
	$link = '<div class="responsive-embed"'.$paddingb.'>'.$link.'</div>';
}

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gmaps_widget wpb_content_element' . $el_class, $this->settings['base'], $atts );
?>
<div class="<?php echo esc_attr($css_class); ?>">
	<?php echo wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_map_heading' ) ); ?>
	<div class="wpb_map_wraper">
		<?php	echo  $link;  /* no need to escape */ ?>
	</div>
</div><?php echo  $this->endBlockComment( '.wpb_gmaps_widget' ); ?>