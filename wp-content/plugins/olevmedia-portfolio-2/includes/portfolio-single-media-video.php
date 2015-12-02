<?php

	$embed_code=get_post_meta($post->ID, 'ompf_video_embed', true);
	if(trim($embed_code)) {

		echo '<div class="ompf-portfolio-video-block ompf-portfolio-video-block-embed">';
		
		if(stripos($embed_code, 'http://') === 0 || stripos($embed_code, 'https://') === 0) {
			global $wp_embed;
			echo '<div class="ompf-responsive-embed">'.$wp_embed->run_shortcode('[embed]'.esc_url($embed_code).'[/embed]').'</div>';
		} else {
			echo '<div class="ompf-responsive-embed">'.ompf_esc_embed($embed_code).'</div>';
		}
		
	} else {
		
		echo '<div class="ompf-portfolio-video-block ompf-portfolio-video-block-selfhosted">';

		$attr=array();
				
		$src_fields=array(
			'src' => 'ompf_video_src',
			'mp4' => 'ompf_video_mp4',
			'm4v' => 'ompf_video_m4v',
			'webm' => 'ompf_video_webm',
			'ogv' => 'ompf_video_ogv',
			'wmv' => 'ompf_video_wmv',
			'flv' => 'ompf_video_flv',
		);
		foreach($src_fields as $k=>$v) {
			$meta=get_post_meta($post->ID, $v, true);
			if($meta) {
				$attr[$k]=$meta;
			}
		}
		
		if(!empty($attr)) {
			$poster=get_post_meta($post->ID, 'ompf_video_poster', true);
			if($poster) {
				$attr['poster']=$poster;
			}
			
			$shortcode='[video';
			foreach($attr as $k=>$v) {
				$shortcode.=' '.$k.'="'.esc_attr($v).'"';
			}
			$shortcode.=']';
			
			add_filter('wp_video_shortcode', 'ompf_set_mediaelementplayer_video_100p');
			echo do_shortcode($shortcode);
			remove_filter('wp_video_shortcode', 'ompf_set_mediaelementplayer_video_100p');
		}
	}
	
	echo '</div>';
	
