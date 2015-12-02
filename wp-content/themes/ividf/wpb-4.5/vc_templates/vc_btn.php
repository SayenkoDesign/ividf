<?php
/**
 * @var $this WPBakeryShortCode_VC_Btn
 * @var $atts
 * @var $style
 * @var $shape
 * @var $color
 * @var $custom_background
 * @var $custom_text
 * @var $size
 * @var $align
 * @var $link
 * @var $title
 * @var $button_block
 * @var $el_class
 * @var $inline_css
 *
 * @var $add_icon
 * @var $i_align
 * @var $i_type
 *
 * ///
 * @var $a_href
 * @var $a_title
 * @var $a_target
 */
$defaults = array(
	'style' => 'classic',
	'shape' => 'rounded',
	'color' => 'grey',
	'custom_background' => '',
	'custom_text' => '',
	'size' => 'md',
	'align' => 'inline',
	'link' => '',
	'title' => '',
	'button_block' => '',
	'el_class' => '',
	'add_icon' => '',
	'i_align' => 'left',
	'i_icon_pixelicons' => '',
	'i_type' => 'fontawesome',
	'i_icon_fontawesome' => 'fa fa-adjust',
	'i_icon_openiconic' => 'vc-oi vc-oi-dial',
	'i_icon_typicons' => 'typcn typcn-adjust-brightness',
	'i_icon_entypo' => 'entypo-icon entypo-icon-note',
	'i_icon_linecons' => 'vc_li vc_li-heart',
	'css_animation' => '',
	
	'custom_color' => '',
	'hover_color' => 'auto',
	'hover_custom_color' => '',
	'text_color' => 'auto',
	'text_custom_color' => '',
	'hover_text_color' => 'auto',
	'hover_text_custom_color' => '',
	'icon_color' => 'auto',
	'icon_custom_color' => '',

);

//
$shape='square';
//

$inline_css = '';
$icon_wrapper = false;
$icon_html = false;

$atts = shortcode_atts( $defaults, $atts );
extract( $atts );
//parse link
$link = ( $link == '||' ) ? '' : $link;
$link = vc_build_link( $link );
$use_link = false;
if ( strlen( $link['url'] ) > 0 ) {
	$use_link = true;
	$a_href = $link['url'];
	$a_title = $link['title'];
	$a_target = strlen( $link['target'] ) > 0 ? $link['target'] : '_self';
}

$el_class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' vc_btn3-container ' . $el_class, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );
$button_class = ' vc_btn3-size-' . $size . ' vc_btn3-shape-' . $shape . ' vc_btn3-style-' . $style;
$button_html = $title;

if ( '' == trim( $title ) ) {
	$button_class .= ' vc_btn3-o-empty';
	$button_html = '<span class="vc_btn3-placeholder">&nbsp;</span>';
}
if ( 'true' == $button_block && 'inline' != $align ) {
	$button_class .= ' vc_btn3-block';
}
if ( 'true' === $add_icon ) {
	$button_class .= ' vc_btn3-icon-' . $i_align;
	vc_icon_element_fonts_enqueue( $i_type );

	if ( isset( ${"i_icon_" . $i_type} ) ) {
		if ( 'pixelicons' === $i_type ) {
			$icon_wrapper = true;
		}
		$iconClass = ${"i_icon_" . $i_type};
	} else {
		$iconClass = 'fa fa-adjust';
	}

	if ( $icon_wrapper ) {
		$icon_html = '<i class="vc_btn3-icon"'.($icon_color == 'custom' && $icon_custom_color ? ' style="color:'.$icon_custom_color.'"' : '').'><span class="vc_btn3-icon-inner ' . esc_attr( $iconClass ) . '"></span></i>';
	} else {
		$icon_html = '<i class="vc_btn3-icon ' . esc_attr( $iconClass ) . '"'.($icon_color == 'custom' && $icon_custom_color ? ' style="color:'.$icon_custom_color.'"' : '').'></i>';
	}


	if ( $i_align == 'left' ) {
		$button_html = $icon_html . ' ' . $button_html;
	} else {
		$button_html .= ' ' . $icon_html;
	}
}

$button_class .= ' vc_btn3-color-' . $color . ' ';


//
$inline_css .= ( $color == 'custom' && $custom_color && ($style == 'flat' || $style == '3d') ) ? 'background-color:'.$custom_color.';' : '';
$inline_css .= ( $color == 'custom' && $custom_color && ($style == 'flat' || $style == '3d') ) ? 'background-color:'.$custom_color.';' : '';
$inline_css .= ( $color == 'custom' && $custom_color && $style == 'outline' ) ? 'color:'.$custom_color.';border-color:'.$custom_color.';' : '';
$inline_css .= ( $text_color == 'custom' && $text_custom_color ) ? 'color:'.$text_custom_color.' !important;' : '';
if($style == '3d' && $color == 'custom' && $custom_color) {
	$inline_css.='box-shadow:0 5px 0 '.om_color_lightness($custom_color, -0.15).';';
}
//

if ( '' != $inline_css ) {
	$inline_css = ' style="' . $inline_css . '"';
}

//
$button_class .= ( $hover_color != '' ) ? ' vc_btn3-hover-color-' . $hover_color : '';


$attr_data=array();
if ($hover_color == 'custom' && $hover_custom_color && ($style == 'flat' || $style == '3d') )
	$attr_data['data-hover-bg-color']=$hover_custom_color;
if ($hover_color == 'custom' && $hover_custom_color && $style == 'outline' )
	$attr_data['data-hover-color']=$attr_data['data-hover-border-color']=$hover_custom_color;
if ( $hover_text_color == 'custom' && $hover_text_custom_color )
	$attr_data['data-hover-color']=$hover_text_custom_color;
$attr_str='';
if(!empty($attr_data)) {
	foreach($attr_data as $k=>$v) {
		$attr_str .= $k.'="'.$v.'" ';
	}
}

//

?>
	<div class="<?php echo esc_attr( trim( $css_class ) ); ?> vc_btn3-<?php echo esc_attr( $align ); ?>"><?php
if ( $use_link ):
	?><a class="vc_general vc_btn3 <?php echo esc_attr( trim( $button_class ) ); ?>"
	     href="<?php echo esc_url( $a_href ); ?>"
	     title="<?php echo esc_attr( $a_title ); ?>"
	     target="<?php echo trim( esc_attr( $a_target ) ); ?>"
	<?php echo  $inline_css; ?> <?php echo  $attr_str ?>><?php echo  $button_html; ?></a><?php
else:
	?>
	<button    class="vc_general vc_btn3 <?php echo esc_attr( $button_class ); ?>"<?php echo  $inline_css; ?> <?php echo  $attr_str ?>><?php echo  $button_html; ?></button><?php
endif; ?></div><?php echo  $this->endBlockComment( 'vc_btn3' ) . "\n";
