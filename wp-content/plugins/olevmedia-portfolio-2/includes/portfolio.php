<?php

	$args=array(
		'portfolio_post_id' => $portfolio_post_id,
	);

	$portfolio_category=intval(get_post_meta($portfolio_post_id, 'ompf_portfolio_categories', true));
	if($portfolio_category) {
		$args['category_id']=$portfolio_category;
	}

	$portfolio=ompf_get_portfolio_thumbnails($args);

	/**
	 * Portfolio categories
	 */
		
	$display_selector=get_post_meta($portfolio_post_id, 'ompf_portfolio_categories_selector', true);
	
	if($display_selector == 'yes') {
		include $GLOBALS['omPortfolioPlugin']['path'] . 'includes/portfolio-categories.php';
	}

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
		<div class="'. implode(' ',$wrapper_classes) .'" id="ompf-portfolio"'.($GLOBALS['omPortfolioPlugin']['config']['fit_thumbnails_height']?' data-fit-height="true"':'').' data-portfolio-post-id="'.$portfolio_post_id.'" data-portfolio-category-id="'.($portfolio_category ? $portfolio_category : '').'">
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
	
	if($portfolio['pagination'] == 'pages') {
		echo '<div id="ompf-pagination-holder">';
		echo ompf_pagination_links($portfolio['paged'], $portfolio['max_num_pages']);
		echo '</div>';
	} elseif($portfolio['pagination'] == 'scroll') {
		echo '<div class="ompf-loadmore-holder" id="ompf-loadmore-holder">';
		echo ompf_loadmore_link($portfolio['paged'], $portfolio['max_num_pages']);
		echo '</div>';
	}
