<?php

function ompf_portfolio_archive_posts_per_page($posts_per_page) {
	
	if(is_tax('portfolio-type')) {
		$pagination=intval(get_option('ompf_archive_portfolio_per_page'));
		if($pagination) {
			$posts_per_page=$pagination;
		}
	}
	
	return $posts_per_page;
}
add_filter('pre_option_posts_per_page', 'ompf_portfolio_archive_posts_per_page');

function ompf_portfolio_archive_page($settings_page_page_id = false) {
	
	global $wp_query;
	
	$args=array(
		'portfolio_post_id' => $settings_page_page_id,
		'wp_query' => $wp_query,
	);

	$portfolio=ompf_get_portfolio_thumbnails($args);

	/**
	 * Portfolio content
	 */	

	$uberwrapper_classes=array('ompf-portfolio-wrapper');
	$uberwrapper_classes=apply_filters('ompf_portfolio_wrapper_classes', $uberwrapper_classes);

	$wrapper_classes=array('ompf-portfolio');
	$wrapper_classes[]='ompf-layout-'.$portfolio['args']['layout'];
	$wrapper_classes[]='ompf-size-'.$portfolio['args']['size'];
	$wrapper_classes[]='ompf-margins-'.$portfolio['args']['margins'];
	$wrapper_classes[]='ompf-pagination-'.$portfolio['pagination'];
	if($portfolio['pagination'] != 'pages')
		$wrapper_classes[]='ompf-isotope';
	$wrapper_classes[]='ompf-preview-layout-'.$portfolio['args']['preview_layout'];
	
	$wrapper_classes=apply_filters('ompf_portfolio_classes', $wrapper_classes);	
	
	$tmp = '
	<div class="'. implode(' ',$uberwrapper_classes) .'">
		<div class="'. implode(' ',$wrapper_classes) .'" id="ompf-portfolio"'.($GLOBALS['omPortfolioPlugin']['config']['fit_thumbnails_height']?' data-fit-height="true"':'').' data-portfolio-post-id="'.$settings_page_page_id.'">
	';
	$tmp=apply_filters('ompf_portfolio_header', $tmp);
	echo $tmp;
	
	echo $portfolio['html'];
	
	$tmp = '
		</div>	
	</div>
	';
	$tmp=apply_filters('ompf_portfolio_footer', $tmp);
	echo $tmp;

	echo '<div id="ompf-pagination-holder">';
	echo ompf_pagination_links($portfolio['paged'], $portfolio['max_num_pages']);
	echo '</div>';
	
}