<?php
extract( shortcode_atts( array(
	'el_width' => '',
	'style' => '',
	'color' => '',
	'accent_color' => '',
	'el_class' => '',
	'border_width' => '',
	'title_align' => '',
	'icon_type' => '',
	'icon_fontawesome' => '',
	'icon_openiconic' => '',
	'icon_typicons' => '',
	'icon_entypo' => '',
	'icon_linecons' => '',
), $atts ) );

echo do_shortcode( '[vc_text_separator layout="separator_with_icon" icon_type="'.$icon_type.'" icon_fontawesome="'.$icon_fontawesome.'" icon_openiconic="'.$icon_openiconic.'" icon_typicons="'.$icon_typicons.'" icon_entypo="'.$icon_entypo.'" icon_linecons="'.$icon_linecons.'" title_align="'.$title_align.'" style="' . $style . '" color="' . $color . '" accent_color="' . $accent_color . '" el_width="' . $el_width . '" el_class="' . $el_class . '" border_width="'.$border_width.'"]' );