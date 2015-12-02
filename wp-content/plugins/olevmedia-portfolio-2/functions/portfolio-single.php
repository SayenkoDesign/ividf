<?php

function ompf_portfolio_single_the_content( $content ) {
	
	if(is_singular('portfolio')) {
		
		global $post, $wp_query;
		
		ob_start();
		include $GLOBALS['omPortfolioPlugin']['path']. 'includes/portfolio-single.php';
		$content = ob_get_clean();
		
	}
	
	return $content;
}

function ompf_init_portfolio_single_the_content() {
	
	if( ! $GLOBALS['omPortfolioPlugin']['config']['theme_supplies_portfolio_single_template'] ) {
		add_filter('the_content', 'ompf_portfolio_single_the_content');
	}
	
}
add_action('init', 'ompf_init_portfolio_single_the_content');
