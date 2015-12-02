<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_pos = $bg_image_att = $font_color = $css = $row_layout ='';
extract(shortcode_atts(array(
    'el_class'        => '',
   	'bg_type' => '',
   	'bg_color2' => '',
   	'gradient_type' => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'fancy_edge' => '',
    'fancy_edge_t_color' => '',
    'fancy_edge_size' => '',
    'bg_image_pos' => '',
    'bg_image_att' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'full_width' => '',
    'css' => '',
		'bg_video_src' => '',
		'bg_video_mp4' => '',
		'bg_video_m4v' => '',
		'bg_video_webm' => '',
		'bg_video_ogv' => '',
		'bg_video_wmv' => '',
		'bg_video_flv' => '',
		'bg_color_fallback' => '',
		'bg_image_fallback' => '',
		'padding_top' => '',
		'padding_bottom' => '',
		'margin_top' => '',
		'margin_bottom' => '',
		'custom_css' => '',
		'el_id' => '',

), $atts));

//wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
//wp_enqueue_style('js_composer_custom_css');

//migrate from custom row_layout option to default full_width
switch($full_width) {
	case 'stretch_row':
		$row_layout='expand_standard_paddings';
		break;
		
	case 'stretch_row_content':
		$row_layout='expand_tiny_paddings';
		break;
		
	case 'stretch_row_content_no_spaces':
		$row_layout='expand_no_paddings';
		break;
		
	default:
		$row_layout='standard';
}

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class /*. vc_shortcode_custom_css_class( $css, ' ' )*/, $this->settings['base'], $atts );

$style=array();
$om_css_class=array();
$tag_attributes=array();

if($font_color)
	$style[]='color:'.$font_color;

if($bg_color) {
	if($bg_color == 'theme') {
		$bg_color=get_option(OM_THEME_PREFIX . 'hightlight_color');
	}
	$style[]='background-color:'.$bg_color;
	$om_css_class[]='om-with-background';
}

$parallax_html='';	
if($bg_type == 'image' && $bg_image && ( $image_url = wp_get_attachment_url( $bg_image, 'full' ) ) !== false ) {

	$om_css_class[]='om-with-background';
		
	if($bg_image_att == 'parallax' || $bg_image_att == 'parallax_down') {
		
		$om_css_class[]='om-parallax';
		
		if($bg_image_att == 'parallax')
			$tag_attributes[]='data-parallax-direction="up"';
		elseif($bg_image_att == 'parallax_down')
			$tag_attributes[]='data-parallax-direction="down"';
		
		$parallax_html .= '<div class="om-wpb-row-bg-parallax om-parallax-inner" style="background-image:url('.$image_url.');'.($bg_image_pos ? implode(';',om_bg_img_pos_style($bg_image_pos)) : '').'"></div>';
		
	} else {
		$style[]='background-image:url('.$image_url.')';
		if($bg_image_pos)
			$style=array_merge($style,om_bg_img_pos_style($bg_image_pos));
		$style[]='background-attachment:'.$bg_image_att;
	}

}

if($bg_type == 'gradient' && $bg_color && $bg_color2) {
	$om_css_class[]='om-with-background';

	if($gradient_type == 'horisontal') {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-linear-gradient(left, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-gradient(linear, left top, right top, color-stop(0%,'.$bg_color.'), color-stop(100%,'.$bg_color2.'));'.
			'background:-webkit-linear-gradient(left, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-o-linear-gradient(left, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-ms-linear-gradient(left, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:linear-gradient(to right, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}	elseif($gradient_type == 'diagonal1') {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-linear-gradient(45deg, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-gradient(linear, left bottom, right top, color-stop(0%,'.$bg_color.'), color-stop(100%,'.$bg_color2.'));'.
			'background:-webkit-linear-gradient(45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-o-linear-gradient(45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-ms-linear-gradient(45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:linear-gradient(45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}	elseif($gradient_type == 'diagonal2') {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-linear-gradient(-45deg, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-gradient(linear, left top, right bottom, color-stop(0%,'.$bg_color.'), color-stop(100%,'.$bg_color2.'));'.
			'background:-webkit-linear-gradient(-45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-o-linear-gradient(-45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-ms-linear-gradient(-45deg, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:linear-gradient(135deg, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}	elseif($gradient_type == 'radial') {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-radial-gradient(center, ellipse cover, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,'.$bg_color.'), color-stop(100%,'.$bg_color2.'));'.
			'background:-webkit-radial-gradient(center, ellipse cover, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-o-radial-gradient(center, ellipse cover, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-ms-radial-gradient(center, ellipse cover, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:radial-gradient(ellipse at center, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}	else {
		$style[]=
			'background:'.$bg_color.';'.
			'background:-moz-linear-gradient(top, '.$bg_color.' 0%, '.$bg_color2.' 100%);'.
			'background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,'.$bg_color.'), color-stop(100%,'.$bg_color2.'));'.
			'background:-webkit-linear-gradient(top, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-o-linear-gradient(top, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:-ms-linear-gradient(top, '.$bg_color.' 0%,'.$bg_color2.' 100%);'.
			'background:linear-gradient(to bottom, '.$bg_color.' 0%,'.$bg_color2.' 100%)'
		;
	}
}

if($padding_top) {
	if(is_numeric($padding_top))
		$padding_top.='px';
	$style[]='padding-top:'.$padding_top;
}
if($padding_bottom) {
	if(is_numeric($padding_bottom))
		$padding_bottom.='px';
	$style[]='padding-bottom:'.$padding_bottom;
}
if($margin_top) {
	if(is_numeric($margin_top))
		$margin_top.='px';
	$style[]='margin-top:'.$margin_top;
}
if($margin_bottom) {
	if(is_numeric($margin_bottom))
		$margin_bottom.='px';
	$style[]='margin-bottom:'.$margin_bottom;
}
if($custom_css){
	$custom_css=str_replace('"','',$custom_css);
	$style[]=$custom_css;
}

global $_WPB_PAGE_SUPPORT_CUSTOM_ROW;
if(!isset($_WPB_PAGE_SUPPORT_CUSTOM_ROW) || !$_WPB_PAGE_SUPPORT_CUSTOM_ROW)
	$row_layout='standard';

if(!in_array($row_layout, array('expand_standard_paddings', 'expand_tiny_paddings', 'expand_no_paddings')))
	$row_layout='standard';

if(!empty($style))
	$style=' style="'.implode(';',$style).'"';
else
	$style='';

$video_html='';
if($bg_type == 'video') {
	if($bg_video_src || $bg_video_mp4 || $bg_video_m4v || $bg_video_webm || $bg_video_ogv || $bg_video_wmv || $bg_video_flv) {
		$om_css_class[]='om-with-background';
		
		$video_html .= '<div class="om-wpb-row-bg-video om-video-bg-container" style="'.($bg_color_fallback ? 'background-color:'.$bg_color_fallback.';' : '').($bg_image_fallback ? 'background-image:url('.wp_get_attachment_url( $bg_image_fallback, 'full' ).');' : '').'">';
		$video_html .= '<video loop="loop" autoplay="autoplay">'; // '.(($bg_image && $image_url)?' poster="'.$image_url.'"':'').'
		if($bg_video_src)
	 		$video_html.='<source src="'.$bg_video_src.'">';
		if($bg_video_mp4)
	 		$video_html.='<source src="'.$bg_video_mp4.'" type="video/mp4">';
		if($bg_video_m4v)
	 		$video_html.='<source src="'.$bg_video_m4v.'" type="video/mp4">';
		if($bg_video_webm)
	 		$video_html.='<source src="'.$bg_video_webm.'" type="video/webm">';
		if($bg_video_ogv)
	 		$video_html.='<source src="'.$bg_video_ogv.'" type="video/ogg">';
		if($bg_video_wmv)
	 		$video_html.='<source src="'.$bg_video_wmv.'" type="video/wmv">';
		if($bg_video_flv)
	 		$video_html.='<source src="'.$bg_video_flv.'" type="video/x-flv">';
		$video_html .= '</video>';
		$video_html .= '</div>';
	}
}

$fancy_edge_html='';
if($fancy_edge && $bg_type == 'color') {
	$om_css_class[]='om-with-fancy-edge';
	
	if($bg_color) {
		$_bg = $bg_color;
	} else {
	 	$_bg = '#ffffff';
	}
	
	if($fancy_edge == 'diagonal_left') {
		$fancy_edge_html='<div class="om-wpb_row-edge om-edge-'.$fancy_edge.' row-layout-'.$row_layout.' om-edge-size-'.$fancy_edge_size.'"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70" viewBox="0 0 100 100" preserveAspectRatio="none">'.($fancy_edge_t_color ? '<polygon points="0,-10 0,110 100,110 100,-10" fill="'.$fancy_edge_t_color.'" />':'').'<polygon points="0,-10 0,100 100,0 100,-10" fill="'.$_bg.'" /></svg></div>';
	} elseif($fancy_edge == 'diagonal_right') {
		$fancy_edge_html='<div class="om-wpb_row-edge om-edge-'.$fancy_edge.' row-layout-'.$row_layout.' om-edge-size-'.$fancy_edge_size.'"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70" viewBox="0 0 100 100" preserveAspectRatio="none">'.($fancy_edge_t_color ? '<polygon points="0,-10 0,110 100,110 100,-10" fill="'.$fancy_edge_t_color.'" />':'').'<polygon points="0,-10 100,-10 100,100 0,0" fill="'.$_bg.'" /></svg></div>';
	} elseif($fancy_edge == 'corner_down') {
		$fancy_edge_html='<div class="om-wpb_row-edge om-edge-'.$fancy_edge.' row-layout-'.$row_layout.' om-edge-size-'.$fancy_edge_size.'"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70" viewBox="0 0 100 100" preserveAspectRatio="none">'.($fancy_edge_t_color ? '<polygon points="0,-10 0,110 100,110 100,-10" fill="'.$fancy_edge_t_color.'" />':'').'<polygon points="0,-10 100,-10 100,0 50,100 0,0" fill="'.$_bg.'" /></svg></div>';
	} elseif($fancy_edge == 'corner_up') {
		$fancy_edge_html='<div class="om-wpb_row-edge om-edge-'.$fancy_edge.' row-layout-'.$row_layout.' om-edge-size-'.$fancy_edge_size.'"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="70" viewBox="0 0 100 100" preserveAspectRatio="none">'.($fancy_edge_t_color ? '<polygon points="0,-10 0,110 100,110 100,-10" fill="'.$fancy_edge_t_color.'" />':'').'<polygon points="0,-10 50,-10 50,0 0,100" fill="'.$_bg.'" /><polygon points="100,-10 50,-10 50,0 100,100" fill="'.$_bg.'" /></svg></div>';
	}
}

$animation=om_wpb_get_animation($atts);

$om_css_class[]='om-wpb_row row-layout-'.$row_layout;

$om_css_class=implode(' ',array_unique($om_css_class));

if(empty($tag_attributes)) {
	$tag_attributes='';
} else {
	$tag_attributes=' '.implode(' ',$tag_attributes);
}

$vc_row_html = '';

$row_id = ( isset( $el_id ) && ! empty( $el_id ) ? ' id="' . esc_attr( $el_id ) . '"' : '' );

switch($row_layout) {
	case 'expand_standard_paddings':
		$vc_row_html .=
				'</div>'. // closing <div class="om-c-container-inner">							
			'</div>'. // closing <div class="om-c-container">				
			'<div class="'.$om_css_class.$animation['classes'].'"'.$style.$tag_attributes.$animation['atts'].$row_id.'>'.$video_html.$parallax_html.
				'<div class="om-c-container">'.
					'<div class="om-c-container-inner">'.
						'<div class="'.$css_class.'">'.
							wpb_js_remove_wpautop($content).
						'</div>'.$this->endBlockComment('row').
					'</div>'.
				'</div>'.
			'</div>'.
			$fancy_edge_html.
			'<div class="om-c-container">'.			
				'<div class="om-c-container-inner">'
		;
		break;
	
	case 'expand_tiny_paddings':
		$vc_row_html .=
				'</div>'. // closing <div class="om-c-container-inner">							
			'</div>'. // closing <div class="om-c-container">		
			'<div class="'.$om_css_class.$animation['classes'].'"'.$style.$tag_attributes.$animation['atts'].$row_id.'>'.$video_html.$parallax_html.
				'<div class="om-c-container-inner">'.
					'<div class="'.$css_class.'">'.
						wpb_js_remove_wpautop($content).
					'</div>'.$this->endBlockComment('row').
				'</div>'.
			'</div>'.
			$fancy_edge_html.
			'<div class="om-c-container">'.			
				'<div class="om-c-container-inner">'
		;
		break;

	case 'expand_no_paddings':
		$vc_row_html .=
				'</div>'. // closing <div class="om-c-container-inner">							
			'</div>'. // closing <div class="om-c-container">		
			'<div class="'.$om_css_class.$animation['classes'].'"'.$style.$tag_attributes.$animation['atts'].$row_id.'>'.$video_html.$parallax_html.
				'<div class="'.$css_class.'">'.
					wpb_js_remove_wpautop($content).
				'</div>'.$this->endBlockComment('row').
			'</div>'.
			$fancy_edge_html.
			'<div class="om-c-container">'.			
				'<div class="om-c-container-inner">'
		;
		break;
				
	case 'standard':
	default:
		$vc_row_html .=
			'<div class="'.$om_css_class.$animation['classes'].'"'.$style.$tag_attributes.$animation['atts'].$row_id.'>'.$video_html.$parallax_html.
				'<div class="'.$css_class.'">'.
					wpb_js_remove_wpautop($content).
				'</div>'.$this->endBlockComment('row').
			'</div>'.
			$fancy_edge_html
		;
}

echo  $vc_row_html; // no need to escape
