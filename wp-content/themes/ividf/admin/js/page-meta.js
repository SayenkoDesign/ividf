jQuery(function($) {
	//"use strict";

	if($('#page_template').length) {

		function hideAllMetaBox() {
			$('#om-page-meta-box-sidebar, #om-page-meta-box-portfolio, #om-page-meta-box-blog').hide();
		}
		hideAllMetaBox();
		
		$('#page_template').change(function(){
			hideAllMetaBox();
			var val=jQuery(this).val();
			if(val != 'template-100width.php' && val != 'template-content-only-100width.php' && val != 'template-portfolio.php' && val != 'template-sitemap.php')
				$('#om-page-meta-box-sidebar').show();
			if(val == 'template-portfolio.php')
				$('#ompf-page-meta-box-portfolio').show();
			if(val == 'template-blog.php')
				$('#om-page-meta-box-blog').show();
	
		}).change();
		
	}
	
});