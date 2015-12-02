<?php

	$embed_code=get_post_meta($post->ID, 'ompf_audio_embed', true);
	if(trim($embed_code)) {

		echo '<div class="ompf-portfolio-audio-block ompf-portfolio-audio-block-embed">';
		
		if(stripos($embed_code, 'http://') === 0 || stripos($embed_code, 'https://') === 0) {
			global $wp_embed;
			echo '<div class="ompf-w-responsive-embed">'.$wp_embed->run_shortcode('[embed]'.esc_url($embed_code).'[/embed]').'</div>';
		} else {
			echo '<div class="ompf-w-responsive-embed">'.ompf_esc_embed($embed_code).'</div>';
		}
		
	} else {
		
		echo '<div class="ompf-portfolio-audio-block ompf-portfolio-audio-block-selfhosted">';

		$attr=array();
				
		$src_fields=array(
			'src' => 'ompf_audio_src',
			'mp3' => 'ompf_audio_mp3',
			'm4a' => 'ompf_audio_m4a',
			'ogg' => 'ompf_audio_ogg',
			'wav' => 'ompf_audio_wav',
			'wma' => 'ompf_audio_wma',
		);
		foreach($src_fields as $k=>$v) {
			$meta=get_post_meta($post->ID, $v, true);
			if($meta) {
				$attr[$k]=$meta;
			}
		}
		
		if(!empty($attr)) {

			//$attr['width']=100;
			
			$shortcode='[audio';
			foreach($attr as $k=>$v) {
				$shortcode.=' '.$k.'="'.esc_attr($v).'"';
			}
			$shortcode.=']';
			
			//add_filter('wp_video_shortcode', 'ompf_set_mediaelementplayer_video_100p');
			echo do_shortcode($shortcode);
			//remove_filter('wp_video_shortcode', 'ompf_set_mediaelementplayer_video_100p');
		}
	}
	
	echo '</div>';
	
