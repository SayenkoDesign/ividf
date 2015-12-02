<?php
extract( shortcode_atts( array(
	'style' => 'simple',
	'photo' => '',
	'img_size' => 'large',
	'img_round' => '',
	'name' => '',
	'job' => '',
	'description' => '',
	'email' => '',
	'behance' => '',
	'facebook' => '',
	'gplus' => '',
	'instagram' => '',
	'linkedin' => '',
	'pinterest' => '',
	'skype' => '',
	'twitter' => '',
	'youtube' => '',
	'el_class' => '',
), $atts ) );

if($el_class)
	$el_class=' '.$el_class;

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-person wpb_content_element' . $el_class, $this->settings['base'], $atts );

$css_class.=' om-person-style-'.$style;

if($img_round == 'yes') {
	$css_class.=' om-person-round-img';
}

if($photo) {
	$src = om_img_any_resize($photo, $img_size, true);
	if($src) {
		$photo='<img src="'.$src.'" alt="'.esc_attr($name).'" />';
	} else {
	 	$photo = '';
	}
}

$social='';
if($email)
	$social.='<a href="mailto:'.$email.'"><i class="'.om_icon_classes('fa-envelope').'"></i></a>';
if($behance)
	$social.='<a href="'.$behance.'" target="_blank"><i class="'.om_icon_classes('fa-behance').'"></i></a>';
if($facebook)
	$social.='<a href="'.$facebook.'" target="_blank"><i class="'.om_icon_classes('fa-facebook').'"></i></a>';
if($gplus)
	$social.='<a href="'.$gplus.'" target="_blank"><i class="'.om_icon_classes('fa-google-plus').'"></i></a>';
if($instagram)
	$social.='<a href="'.$instagram.'" target="_blank"><i class="'.om_icon_classes('fa-instagram').'"></i></a>';
if($linkedin)
	$social.='<a href="'.$linkedin.'" target="_blank"><i class="'.om_icon_classes('fa-linkedin').'"></i></a>';
if($pinterest)
	$social.='<a href="'.$pinterest.'" target="_blank"><i class="'.om_icon_classes('fa-pinterest').'"></i></a>';
if($twitter)
	$social.='<a href="'.$twitter.'" target="_blank"><i class="'.om_icon_classes('fa-twitter').'"></i></a>';
if($youtube)
	$social.='<a href="'.$youtube.'" target="_blank"><i class="'.om_icon_classes('fa-youtube').'"></i></a>';

if($style == 'colored') {
	echo
		'<div class="'. $css_class .'">'.
			($photo ? '<div class="om-person-photo">'.$photo.'</div>' : '').
			'<div class="om-person-name-job-social">'.
				'<div class="om-person-name-job">'.
					($name ? '<div class="om-person-name">'.$name.'</div>' : '').
					($job ? '<div class="om-person-job">'.$job.'</div>' : '').
				'</div>'.
				($social ? '<div class="om-person-social">'.$social.'</div>' : '').
			'</div>'.
			($description ? '<div class="om-person-description">'.$description.'</div>' : '').
		'</div>'
	;
} else {
	echo
		'<div class="'. $css_class .'">'.
			($photo ? '<div class="om-person-photo">'.$photo.'</div>' : '').
			'<div class="om-person-name-job">'.
				($name ? '<div class="om-person-name">'.$name.'</div>' : '').
				($job ? '<div class="om-person-job">'.$job.'</div>' : '').
			'</div>'.
			($description ? '<div class="om-person-description">'.$description.'</div>' : '').
			($social ? '<div class="om-person-social">'.$social.'</div>' : '').
		'</div>'
	;
}
