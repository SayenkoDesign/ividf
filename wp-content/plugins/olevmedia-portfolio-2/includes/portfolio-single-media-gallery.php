<?php

	if(has_filter( 'ompf_single_media_gallery' )) {
		
		echo apply_filters( 'ompf_single_media_gallery', array('width100' => $width100) );
		
	} else {

		$custom_gallery=get_post_meta($post->ID, 'ompf_gallery', true);
		$columns=get_post_meta($post->ID, 'ompf_portfolio_gallery_columns', true);
		if(!$columns)
			$columns=3;
		
		echo '<div class="ompf-portfolio-gallery-block">';
		
		if(is_array($custom_gallery) && $custom_gallery['type'] == 'custom') {
			
			echo do_shortcode('[gallery columns="'.$columns.'" link="file" ids="'.$custom_gallery['images'].'"]');
			
		} else {
			
			echo do_shortcode('[gallery columns="'.$columns.'" link="file"]');
			
		}
		
		echo '</div>';
		
	}