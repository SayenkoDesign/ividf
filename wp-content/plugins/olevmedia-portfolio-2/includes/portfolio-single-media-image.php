<?php

	if(has_filter( 'ompf_single_media_image' )) {
		
		echo apply_filters( 'ompf_single_media_image', array() );
		
	} else {
		
		$images=ompf_get_post_images($post->ID);
		if(!empty($images)) {

			echo '<div class="ompf-portfolio-single-image-block">';

			$img_width=700;
			if(
				isset($width100) &&
				$width100 &&
				isset($GLOBALS['omPortfolioPlugin']['config']['single_page_image_sizes']['100width']['width'])
			) {
				$img_width=$GLOBALS['omPortfolioPlugin']['config']['single_page_image_sizes']['100width']['width'];
			} elseif(isset($GLOBALS['omPortfolioPlugin']['config']['single_page_image_sizes'][$ratio]['width'])) {
				$img_width=$GLOBALS['omPortfolioPlugin']['config']['single_page_image_sizes'][$ratio]['width'];
			}

			foreach($images as $img) {
					
				$img_=omaq_resize($img[0],$img_width);
				if($img_) {
					$arr=array(
						'full_link' => $img[0],
						'img_src' => $img_,
						'img_alt' => $img['alt'],
						'100width' => $width100,
					);
					$html=apply_filters('ompf_single_media_image_block', '<a href="'.$img[0].'" rel="prettyPhoto[postgal_'.$post->ID.']"><img src="'.$img_.'" alt="'.esc_attr($img['alt']).'" /></a>', $arr);
					echo '<div class="ompf-psib-item">'.$html.'</div>';
				}
			}
			
			echo '</div>';
		}
		
	}