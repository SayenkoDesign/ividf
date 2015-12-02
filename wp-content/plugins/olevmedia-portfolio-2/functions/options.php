<?php

$ompf_portfolio_options=array(

	'portfolio_prev_next' => array(
		'name' => __('Previous/next item links on single portfolio page', 'om_portfolio'),
		'desc' => '',
		'id' =>  'ompf_portfolio_prev_next',
		'std' => 'none',
		'options'=>array(
				'none' => __('Hide links','om_portfolio'),
				'all' => __('Show Prev/next links on all portfolio items','om_portfolio'),
				'category' => __('Show Prev/next links on portfolio items only from the same category','om_portfolio'),
		),
		'type' => 'select',
	),
		                    
	/*	
	'pagination_notice' => array(
		"name" => '',
		'id' => 'ompf_pagination_notice',
		'message'=> __('<b style="color:red">Notice:</b>','om_portfolio').'<br/><br/>'.
			__('Please note, when you apply pagination an animation effect when sorting items by category does not work.','om_portfolio').'<br/><br/>'.
			__('If you have 404 page error on single portfolio pages after changing pagination option, please, navigate to Settings-Permalinks and click "Save changes".', 'om_portfolio').'<br/><br/>'.
			__('If you use portfolio pagination and permalinks setting is not default, due to WordPress core particularity the "Custom portfolio URL directory" (see below) must differ from the root portfolio page URL slug. Otherwise you will get an 404 error on the root portfolio paginated pages.', 'om_portfolio').'<br/><br/>'
		,
		"type" => "intro",
		'code' => '
			<script>
				jQuery(function($){
					$("#ompf_portfolio_pagination").change(function(){
						if($(this).val() == "pages") {
							$("#ompf_pagination_notice").show();
							$("#ompf_portfolio_per_page").parents("tr").show();
						} else {
							$("#ompf_pagination_notice").hide();
							$("#ompf_portfolio_per_page").parents("tr").hide();
						}
					}).change();
				});
			</script>
		',
	),	
	*/ 
		                    
	'portfolio_slug' => array(
		'name' => __('Custom portfolio URL directory', 'om_portfolio'),
		'desc' => __('when using custom permalinks wordpress mode you can change the "portfolio" key in URLs like website.com/portfolio/item-name/', 'om_portfolio'),
		'id' =>  'ompf_portfolio_slug',
		'std' => '',
		'type' => 'text'
	),

	'portfolio_cat_slug' => array(
		'name' => __('Custom portfolio category URL directory', 'om_portfolio'),
		'desc' => __('when using custom permalinks wordpress mode you can change the "portfolio-type" key in URLs like website.com/portfolio-type/category-name/', 'om_portfolio'),
		'id' =>  'ompf_portfolio_cat_slug',
		'std' => '',
		'type' => 'text',
	),
	
	'random_notice' => array(
		"name" => "",
		'id' => 'random_notice',
		"message" => '<b style="font-size:130%">'.__('Random items on single page:','om_portfolio').'</b>',
		"type" => "intro"
	),
							
	'portfolio_single_show_random' => array(
		'name' => __('Show random portfolio items on single portfolio page', 'om_portfolio'),
		'desc' => '',
		'id' =>  'ompf_portfolio_single_show_random',
		'std' => '',
		'options' => array_merge( array('' => __('No','om_portfolio')), ompf_get_options_arr('size')),
		'type' => 'select',
	),
		                    
	'portfolio_single_random_ratio' => array(
		'name' => __('Random portfolio items thumbnail width/height ratio', 'om_portfolio'),
		'desc' => '',
		'id' =>  'ompf_portfolio_single_random_ratio',
		'std' => '1.5',
		'options' => ompf_get_options_arr('ratio'),
		'type' => 'select'
	),

	'portfolio_random_title' => array(
		'name' => __('Title for random items', 'om_portfolio'),
		'desc' => '',
		'id' =>  'ompf_portfolio_random_title',
		'std' => __('Random Items','om_portfolio'),
		'type' => 'text',
	),
	
	'archive_notice' => array(
		"name" => "",
		'id' => 'archive_notice',
		"message" => '<b style="font-size:130%">'.__('Archive/Category page','om_portfolio').'</b>',
		"type" => "intro"
	),
	
	'archive_portfolio_per_page' => array(
		'name' => __('Number of items per page', 'om_portfolio'),
		'desc' => __('Leave empty to use standard value'),
		'id' =>  'ompf_archive_portfolio_per_page',
		'std' => '9',
		'type' => 'text',
	),
	
);

function ompf_portfolio_set_default_options() {
	global $ompf_portfolio_options;
	
	if( is_admin() && get_option('ompf_plugin_just_activated')) {
		delete_option('ompf_plugin_just_activated');

		foreach($ompf_portfolio_options as $option) {
			if(isset($option['id']) && isset($option['std'])) {
				$db_option = get_option($option['id']);
				if($db_option === false){
					update_option($option['id'], $option['std']);
				}
			}
		}
	}
}
add_action('admin_init','ompf_portfolio_set_default_options');

function ompf_portfolio_options_modify() {
	global $ompf_portfolio_options;

	$ompf_portfolio_options = apply_filters('ompf_portfolio_options', $ompf_portfolio_options);
		
}
add_action('admin_init', 'ompf_portfolio_options_modify');