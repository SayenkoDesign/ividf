<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
if(empty($img_size))
	$img_size='large';

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

?>

<?php $uid = uniqid(); ?>

<div class="modal fade popup" id="<?php echo $uid; ?>" role="dialog">
    <div class="modal-dialog about_us_popup">
    	<div class="modal-content">
        	<button type="button" class="close" data-dismiss="modal">&times;</button>
        	<div class="popup_photo"><?php echo $photo; ?></div>
            <div class="popup_name"><?php echo $name; ?></div>
            <div class="popup_job"><?php echo $job; ?></div>
            <!--<div class="popup_contact_us"><a href="<?php //echo $contactuslink; ?>">Contact US</a></div>-->
        </div>
        <div class="popup_description modal-body"><?php echo $description; ?></div>
    </div>    
</div>

<?php
if($style == 'colored') {
	echo
		'<div class="'. $css_class .'">'.
			($photo ? '<div class="om-person-photo"><a href="#" data-toggle="modal" data-target="#'.$uid.'" class="read_more">'.$photo.'</a></div>' : '').
			'<div class="om-person-name-job-social">'.
				'<div class="om-person-name-job">'.
					($name ? '<div class="om-person-name">'.$name.'</div>' : '').
					($job ? '<div class="om-person-job">'.$job.'</div>' : '').
					($readmore ? '<div class="om-person-readmore"><a href="#" data-toggle="modal" data-target="#'.$uid.'" class="read_more">'.$readmore.' ></a></div>' : '').
				'</div>'.
				($social ? '<div class="om-person-social">'.$social.'</div>' : '').
			'</div>'.
			($description ? '<div class="om-person-description" style="display:none;">'.$description.'</div>' : '').
		'</div>'
	;
} else {
	echo
		'<div class="'. $css_class .'">'.
			($photo ? '<div class="om-person-photo">'.$photo.'</div>' : '').
			'<div class="om-person-name-job">'.
				($name ? '<div class="om-person-name">'.$name.'</div>' : '').
				($job ? '<div class="om-person-job">'.$job.'</div>' : '').
				($readmore ? '<div class="om-person-readmore"><a href="#'.$guid.'" data-toggle="modal" data-target="#myModal" class="read_more">'.$readmore.'</a></div>' : '').
			'</div>'.
			($description ? '<div class="om-person-description" style="display:none;">'.$description.'</div>' : '').
			($social ? '<div class="om-person-social">'.$social.'</div>' : '').
		'</div>'
	;
}
