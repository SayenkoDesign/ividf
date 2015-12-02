<?php

/*************************************************************************************
 *	Recent Portfolios
 *************************************************************************************/

function ompf_sc_portfolio( $atts, $content = null ) {

	if(has_filter('ompf_sc_portfolio'))
		return apply_filters('ompf_sc_portfolio', $atts, $content);	

	global $post, $wp_query;
		
	extract(shortcode_atts(array(
		'size' => 'medium',
		'count' => 0,
		'category' => 0,
		'ids' => '',
		'ratio' => '3:2',
		'sort' => 'menu_order',
		'preview_layout' => 'full',
		'layout' => 'fixed',
		'randomize' => false,
		'margins' => 'standard',
		'hires' => false,
		'widget_mode' => false,
	), $atts));

	if(!isset($GLOBALS['omPortfolioPlugin']['config']['thumbnail_sizes'][$size]))
		$size='medium';

	$ratio=explode(':',$ratio);
	if(@$ratio[1]) {
		$ratio=$ratio[0]/$ratio[1];
		if(!$ratio) {
			$ratio=3/2;
		}
	} else {
		$ratio=3/2;
	}


	$args=array(
		'portfolio_post_id' => false,
		'layout' => $layout,
		'size' => $size,
		'image_size' => $size,
		'ratio' => $ratio,
		'preview_layout' => $preview_layout,
		'margins' => $margins,
	);
	
	if($hires == 'yes')
		$args['image_size'].='-full';

	$args['query_args']=array(
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC',
	);

	if($sort == 'date_asc') {
		$args['query_args']['orderby'] = 'date';
		$args['query_args']['order'] = 'ASC';
	} elseif($sort == 'date_desc') {
		$args['query_args']['orderby'] = 'date';
		$args['query_args']['order'] = 'DESC';
	}

	if($ids) {
		$args['query_args']['post__in']=explode(',',$ids);
		$args['query_args']['orderby']='post__in';		
	} else {
		$count=intval($count);
		$category=intval($category);
	
		$args['query_args']['posts_per_page']=$count;
		if($category > 0) {
			$args['query_args']['tax_query']=array(
				array('taxonomy'=>'portfolio-type', 'terms' => $category),
			);
		}
	}

	if($randomize) {
		$args['query_args']['orderby']='rand';
	}
	
	$out='';
	
	$portfolio=ompf_get_portfolio_thumbnails($args);

	ob_start();
			
	$uberwrapper_classes=array('ompf-portfolio-wrapper');
	$uberwrapper_classes=apply_filters('ompf_portfolio_sc_wrapper_classes', $uberwrapper_classes);
	
	$wrapper_classes=array('ompf-portfolio', 'ompf-sc-portfolio');
	if($widget_mode) {
		$wrapper_classes[]='ompf-widget-mode';
	} else {
	 	$wrapper_classes[]='ompf-isotope';
	}
	$wrapper_classes[]='ompf-layout-'.$args['layout'];
	$wrapper_classes[]='ompf-size-'.$args['size'];
	$wrapper_classes[]='ompf-preview-layout-'.$args['preview_layout'];
	$wrapper_classes[]='ompf-margins-'.$args['margins'];
	$wrapper_classes=apply_filters('ompf_portfolio_sc_classes', $wrapper_classes);	
		
	$tmp = '
	<div class="'. implode(' ',$uberwrapper_classes) .'">
		<div class="'. implode(' ',$wrapper_classes) .'" id="ompf-portfolio"'.($GLOBALS['omPortfolioPlugin']['config']['fit_thumbnails_height']?' data-fit-height="true"':'').'>
	';
	$tmp=apply_filters('ompf_portfolio_sc_header', $tmp);
	echo $tmp;
			
	echo $portfolio['html'];
	
	$tmp = '
			<div class="ompf-clear"></div>
		</div>	
	</div>
	';
	$tmp=apply_filters('ompf_portfolio_sc_footer', $tmp);
	echo $tmp;

	$out .= ob_get_contents();
	ob_end_clean();
	
	return $out;
}
add_shortcode('portfolio', 'ompf_sc_portfolio');
