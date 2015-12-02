jQuery(function($) {
	"use strict";
	
	function hideAllMetaBox() {
		$('#ompf-portfolio-meta-box-images, #ompf-portfolio-meta-box-video, #ompf-portfolio-meta-box-audio').hide();
	}
	hideAllMetaBox();
	
	$('#ompf-portfolio-meta-box-type #ompf_portfolio_type').change(function(){
		hideAllMetaBox();
		var val=$(this).val();
		if(val == 'image' || val == 'gallery')
			$('#ompf-portfolio-meta-box-images').show();
		else if(val == 'audio')
			$('#ompf-portfolio-meta-box-audio').show();
		else if(val == 'video')
			$('#ompf-portfolio-meta-box-video').show();

	}).change();
	
});