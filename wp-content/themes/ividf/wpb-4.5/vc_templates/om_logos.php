<?php
extract( shortcode_atts( array(
	'title' => '',
	'images' => '',
	'onclick' => '',
	'custom_links' => '',
	'links_target' => '',
	'img_size' => 'full',
	'el_class' => '',
), $atts ) );

if($images == '')
	return false;
	
$images=explode(',',$images);

if($el_class)
	$el_class=' '.$el_class;

if($onclick == 'custom_link')
	$custom_links=explode(',',$custom_links);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-logos wpb_content_element' . $el_class, $this->settings['base'], $atts );

echo
	'<div class="'. $css_class .'">'.
		wpb_widget_title( array( 'title' => $title, 'extraclass' => 'vc_om-logos_heading' ) ) .
		'<div class="vc_om-logos-inner">'
;
			foreach($images as $i=>$id) {
				$src = om_img_any_resize($id, $img_size, false, false);
				if($src) {
			    if( get_option(OM_THEME_PREFIX . 'lazyload') == 'true' ) {
			    	$img='<img width="'.$src[1].'" height="'.$src[2].'" src="'. TEMPLATE_DIR_URI .'/img/e.png" data-original="'.$src[0].'" alt="" class="lazyload" />';
			    } else {
			    	$img='<img width="'.$src[1].'" height="'.$src[2].'" src="'.$src[0].'" alt=""/>';
					}
					
					if($onclick == 'custom_link') {
						if(isset($custom_links[$i]))
						$img='<a href="'.esc_attr($custom_links[$i]).'"'.($links_target ? ' target="'.$links_target.'"' : '').'>'.$img.'</a>';
					} elseif ($onclick == 'description') {
						$attachment=get_post($id);
						$href=trim($attachment->post_content);
						if($href) {
							$img='<a href="'.esc_attr($href).'"'.($links_target ? ' target="'.$links_target.'"' : '').'>'.$img.'</a>';
						}
					}
					
					echo '<div class="vc_om-logos-item">'.$img.'</div>';
				}
			}
echo
		'</div>'.
	'</div>'
;
