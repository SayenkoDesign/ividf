jQuery(function($) {
	"use strict";
	
	function hideAllMetaBox() {
		$('#ompf-page-meta-box-portfolio').hide();
	}
	hideAllMetaBox();
	
	$('#page_template').change(function(){
		hideAllMetaBox();
		var val=$(this).val();
		if(val == 'template-portfolio.php')
			$('#ompf-page-meta-box-portfolio').show();
	}).change();
	
});