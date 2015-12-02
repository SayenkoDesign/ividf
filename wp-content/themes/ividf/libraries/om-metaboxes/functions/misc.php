<?php

function ommb_check_slider_exists($sliders='') {
	
	if(empty($sliders)) {
		$sliders=array(
			'revslider',
			'lslider',
		);
	} else {
		if(!is_array($sliders))
			$sliders=array($sliders);
	}
	
	foreach($sliders as $slider) {
		
		switch($slider) {
			
			case 'revslider':
				if( class_exists('RevSlider') )
					return true;
			break;
					
			case 'lslider':
				if( isset($GLOBALS['lsPluginVersion']) || defined('LS_PLUGIN_VERSION') )
					return true;
			break;
					
		}		
	}
	
	return false;
}