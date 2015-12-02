<?php
// extract(shortcode_atts(array(
//     'color' => 'wpb_button',
//     'icon' => 'none',
//     'size' => '',
//     'target' => '',
//     'href' => '',
//     'title' => __('Text on the button', "js_composer"),
//     'call_text' => '',
//     'position' => 'cta_align_right',
//     'el_class' => ''
// ), $atts));
extract(shortcode_atts(array(
    'h2' => '',
    'h4' => '',
    'add_button' => '',
    'el_width' => '',
    'style' => '',
    'txt_align' => '',
    'custom_background' => '',
    'link' => '',
    'title' => __('Text on the button', "js_composer"),
    'color' => '',
    'icon' => '',
    'size' => '',
    'btn_style' => '',
    'el_class' => '',
    'css_animation' => '',
    
    'btn_custom_color' => '',
    'custom_text' => '',
    'btn_custom_text' => '',
    'btn_text_custom_color' => '',
), $atts));

///
if($style=='outline') {
	$style='square_outlined';
} else {
	$style='square';
}

if($el_width != '') {
	switch($el_width) {
		case 'xs':
			$el_width='50';
			break;
		case 'sm':
			$el_width='60';
			break;
		case 'md':
			$el_width='70';
			break;
		case 'lg':
			$el_width='890';
			break;
		case 'xl':
			$el_width='90';
			break;
		default:
			$el_width='';
			break;
	}
}
///

$class = "vc_call_to_action wpb_content_element";
// $position = 'left';
// $width = '90';
// $style = '';
// $txt_align = 'right';
$link = ($link=='||') ? '' : $link;

$class .= ($add_button!='') ? ' vc_cta_btn_pos_'.$add_button : '';
$class .= ($el_width!='') ? ' vc_el_width_'.$el_width : '';
$class .= ($color!='') ? ' vc_cta_'.$color : '';
$class .= ($style!='') ? ' vc_cta_'.$style : '';
$class .= ($txt_align!='') ? ' vc_txt_align_'.$txt_align : '';

$inline_css='';
if($custom_background!='') {
	$inline_css .= vc_get_css_color('background', $custom_background).';';
	if($style=='square_outlined')
		$inline_css .= vc_get_css_color('border-color', $custom_background).';';
	
	$custom_background_l=om_color_lightness($custom_background, 0.03);
	$custom_background_d=om_color_lightness($custom_background, -0.03);
	$inline_css .=
		'background:-moz-linear-gradient(left,  '.$custom_background_d.' 0%, '.$custom_background_l.' 100%);'.
		'background:-webkit-gradient(linear, left top, right top, color-stop(0%,'.$custom_background_d.'), color-stop(100%,'.$custom_background_l.'));'.
		'background:-webkit-linear-gradient(left,  '.$custom_background_d.' 0%,'.$custom_background_l.' 100%);'.
		'background:-ms-linear-gradient(left,  '.$custom_background_d.' 0%,'.$custom_background_l.' 100%);'.
		'background:linear-gradient(to right,  '.$custom_background_d.' 0%,'.$custom_background_l.' 100%);'
	;
}

$inline_css .= ($custom_text!='') ? 'color:'.$custom_text.';' : '';

$button_html='';
if($add_button) {
	$btn_atts='';
	foreach($atts as $k=>$v) {
		if(strpos($k,'btn_') === 0) {
			$btn_atts.=' '.substr($k,4).'="'.esc_attr($v).'"';
		}
	}
	$button_html=do_shortcode('[vc_btn'.$btn_atts.'][/vc_btn]');
	$class .= ' vc_with_btn';
}

$class .= $this->getExtraClass($el_class);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation($css_animation);

?>
<div<?php echo ($inline_css ? ' style="'.$inline_css.'"' : '') ?> class="<?php echo esc_attr(trim($css_class)); ?>">
	<div class="vc_cta-inner">
    <?php if ($button_html && $add_button=='left') echo '<div class="vc_cta-button">'.$button_html.'</div>'; ?>
    <div class="vc_cta-text">
<?php if ($h2!='' || $h4!=''): ?>
    <hgroup>
        <?php if ($h2!=''): ?><h2 class="wpb_heading"><?php echo  $h2; ?></h2><?php endif; ?>
        <?php if ($h4!=''): ?><h4 class="wpb_heading"><?php echo  $h4; ?></h4><?php endif; ?>
    </hgroup>
<?php endif; ?>
    <?php echo wpb_js_remove_wpautop($content, true); ?>
    </div>
    <?php if ($button_html && $add_button!='left') echo '<div class="vc_cta-button">'.$button_html.'</div>'; ?>
  </div>
</div>
<?php $this->endBlockComment('.vc_call_to_action') . "\n";