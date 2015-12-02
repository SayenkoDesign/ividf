<?php

function ompf_portfolio_ajax() {
	
	$out=array('error'=>0);
	
	$args=array();
	
	if(isset($_POST['portfolio_id']) && $_POST['portfolio_id']) {
		$args['portfolio_post_id'] = $_POST['portfolio_id'];
	} else {
		$out['error']=1;
		wp_send_json($out);
	}

	if(isset($_POST['category_id']) && $_POST['category_id'])
		$args['category_id'] = $_POST['category_id'];
		
	if(isset($_POST['paged']) && $paged=intval($_POST['paged']))
		$args['query_args']['paged'] = $paged;
		
	$portfolio=ompf_get_portfolio_thumbnails($args);
	
	$out['html']=$portfolio['html'];
	
	if($portfolio['pagination'] == 'pages') {
		$out['html_pagination']=ompf_pagination_links($portfolio['paged'], $portfolio['max_num_pages'], array('empty_href' => true));
	} elseif($portfolio['pagination'] == 'scroll') {
		$out['html_pagination']=ompf_loadmore_link($portfolio['paged'], $portfolio['max_num_pages'], array('empty_href' => true));
	} else {
		$out['html_pagination'] = '';
	}
	
	wp_send_json($out);
	
}

add_action( 'wp_ajax_ompf_portfolio_ajax', 'ompf_portfolio_ajax' );
add_action( 'wp_ajax_nopriv_ompf_portfolio_ajax', 'ompf_portfolio_ajax' );