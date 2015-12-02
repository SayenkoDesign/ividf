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
    'position' => '',
    'el_width' => '',
    'style' => '',
    'txt_align' => '',
    'accent_color' => '',
    'link' => '',
    'title' => __('Text on the button', "js_composer"),
    'color' => '',
    'icon' => '',
    'size' => '',
    'btn_style' => '',
    'el_class' => '',
    'css_animation' => '',
    
    'btn_custom_color' => '',
    'text_color' => '',
    'btn_text_color' => '',
    'btn_text_custom_color' => '',
), $atts));

$class = "vc_call_to_action wpb_content_element";
// $position = 'left';
// $width = '90';
// $style = '';
// $txt_align = 'right';
$link = ($link=='||') ? '' : $link;

$class .= ($position!='') ? ' vc_cta_btn_pos_'.$position : '';
$class .= ($el_width!='') ? ' vc_el_width_'.$el_width : '';
$class .= ($color!='') ? ' vc_cta_'.$color : '';
$class .= ($style!='') ? ' vc_cta_'.$style : '';
$class .= ($txt_align!='') ? ' vc_txt_align_'.$txt_align : '';

$inline_css='';
if($accent_color!='') {
	$inline_css .= vc_get_css_color('background', $accent_color).';';
	if($style=='square_outlined')
		$inline_css .= vc_get_css_color('border-color', $accent_color).';';
	
	$accent_color_l=om_color_lightness($accent_color, 0.03);
	$accent_color_d=om_color_lightness($accent_color, -0.03);
	$inline_css .=
		'background:-moz-linear-gradient(left,  '.$accent_color_d.' 0%, '.$accent_color_l.' 100%);'.
		'background:-webkit-gradient(linear, left top, right top, color-stop(0%,'.$accent_color_d.'), color-stop(100%,'.$accent_color_l.'));'.
		'background:-webkit-linear-gradient(left,  '.$accent_color_d.' 0%,'.$accent_color_l.' 100%);'.
		'background:-ms-linear-gradient(left,  '.$accent_color_d.' 0%,'.$accent_color_l.' 100%);'.
		'background:linear-gradient(to right,  '.$accent_color_d.' 0%,'.$accent_color_l.' 100%);'
	;
}

$inline_css .= ($text_color!='') ? 'color:'.$text_color.';' : '';

$button_html='';
if($link) {
	$button_html=do_shortcode('[vc_button2 link="'.$link.'" title="'.$title.'" color="'.$color.'" custom_color="'.$btn_custom_color.'" text_color="'.$btn_text_color.'" text_custom_color="'.$btn_text_custom_color.'" icon="'.$icon.'" size="'.$size.'" style="'.$btn_style.'" el_class="vc_cta_btn"]');
	$class .= ' vc_with_btn';
}

$class .= $this->getExtraClass($el_class);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation($css_animation);

?>
<div<?php echo ($inline_css ? ' style="'.$inline_css.'"' : '') ?> class="<?php echo esc_attr(trim($css_class)); ?>">
	<div class="vc_cta-inner">
    <?php if ($button_html && $position=='left') echo '<div class="vc_cta-button">'.$button_html.'</div>'; ?>
    <div class="vc_cta-text">
<?php if ($h2!='' || $h4!=''): ?>
    <hgroup>
        <?php if ($h2!=''): ?><h2 class="wpb_heading"><?php echo  $h2; ?></h2><?php endif; ?>
        <?php if ($h4!=''): ?><h4 class="wpb_heading"><?php echo  $h4; ?></h4><?php endif; ?>
    </hgroup>
<?php endif; ?>
    <?php echo wpb_js_remove_wpautop($content, true); ?>
    </div>
    <?php if ($button_html && $position!='left') echo '<div class="vc_cta-button">'.$button_html.'</div>'; ?>
  </div>
</div>
<?php $this->endBlockComment('.vc_call_to_action') . "\n";