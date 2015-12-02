<?php
$atts = vc_shortcode_attribute_parse( array(
	'link' => '',
	'title' => __( 'Text on the button', "js_composer" ),
	'color' => 'om-theme-color',
	'icon' => '',
	'size' => 'md',
	'style' => '',
	'el_class' => '',
	
	'custom_color' => '',
	'hover_color' => 'auto',
	'hover_custom_color' => '',
	'text_color' => 'auto',
	'text_custom_color' => '',
	'hover_text_color' => 'auto',
	'hover_text_custom_color' => '',
	'icon_type' => '',
	'icon_color' => 'auto',
	'icon_custom_color' => '',
	'width' => '',
	'align' => '',
), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' ); // shortcode may be used out of content area, for instance in widgets area, but it needs this file

$class = 'vc_btn';
//parse link
$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$a_href = $link['url'];
$a_title = $link['title'];
$a_target = $link['target'];

if($icon_type) {
	$iconClass = isset( ${"icon_" . $icon_type} ) ? ${"icon_" . $icon_type} : false;
	if($iconClass) {
		vc_icon_element_fonts_enqueue( $icon_type );
		$icon_type=$iconClass;
	} else {
		$icon_type=false;
	}
}

$class .= ( $color != '' ) ? ( ' vc_btn_' . $color . ' vc_btn-' . $color ) : '';
$class .= ( $size != '' ) ? ( ' vc_btn_' . $size . ' vc_btn-' . $size ) : '';
$class .= ( $style != '' ) ? ' vc_btn_' . $style : '';
$class .= ( $hover_color != '' ) ? ' vc_btn_hover_color-' . $hover_color : '';
$class .= ( $icon_type ) ? ' vc_btn_with_icon' : '';

$cssstyle = '';
$cssstyle .= ( $color == 'custom' && $custom_color && ($style == 'square' || $style == '3d') ) ? 'background-color:'.$custom_color.';' : '';
$cssstyle .= ( $color == 'custom' && $custom_color && $style == 'square_outlined' ) ? 'color:'.$custom_color.';border-color:'.$custom_color.';' : '';
$cssstyle .= ( $text_color == 'custom' && $text_custom_color ) ? 'color:'.$text_custom_color.' !important;' : '';
if($style == '3d' && $color == 'custom' && $custom_color) {
	$cssstyle.='box-shadow:0 5px 0 '.om_color_lightness($custom_color, -0.15).';';
}

if(is_numeric($width))
	$width.='px';
$cssstyle .= ( $width ) ? 'width:'.$width.';' : '';

$attr_data=array();
if ($hover_color == 'custom' && $hover_custom_color && ($style == 'square' || $style == '3d') )
	$attr_data['data-hover-bg-color']=$hover_custom_color;
if ($hover_color == 'custom' && $hover_custom_color && $style == 'square_outlined' )
	$attr_data['data-hover-color']=$attr_data['data-hover-border-color']=$hover_custom_color;
if ( $hover_text_color == 'custom' && $hover_text_custom_color )
	$attr_data['data-hover-color']=$hover_text_custom_color;
$attr_str='';
if(!empty($attr_data)) {
	foreach($attr_data as $k=>$v) {
		$attr_str .= $k.'="'.$v.'" ';
	}
}

$el_class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ' . $class . $el_class, $this->settings['base'], $atts );

$wrapper_css_class = 'vc_button-2-wrapper';
if ( $align ) {
	$wrapper_css_class .= ' vc_button-2-align-'.$align;
}

?>
<div class="<?php echo esc_attr($wrapper_css_class) ?>"><a class="<?php echo esc_attr( trim( $css_class ) ); ?>" href="<?php echo esc_url($a_href); ?>" <?php echo ($cssstyle ? 'style="'.$cssstyle.'"' : '') ?> title="<?php echo esc_attr( $a_title ); ?>" target="<?php echo esc_attr($a_target); ?>" <?php echo  $attr_str ?>><?php if($icon_type) echo '<i class="vc_btn_icon '.$icon_type.'"'.($icon_color == 'custom' && $icon_custom_color ? ' style="color:'.$icon_custom_color.'"' : '').'></i>' ?><?php echo  $title; ?></a></div><?php echo  $this->endBlockComment( 'vc_button' ) . "\n";