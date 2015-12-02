<?php

/*************************************************************************************
 *	Add MetaBox to Page edit page
 *************************************************************************************/

$ompf_page_meta_box=array (
	
	'portfolio' => array (
		'id' => 'ompf-page-meta-box-portfolio',
		'name' => __('Portfolio options', 'om_portfolio'),
		'fields' => array (
			'ompf_portfolio_display' => array (
				'name' => __('Display Portfolio on this page','om_portfolio'),
				'desc' => '',
				'id' => 'ompf_portfolio_display',
				'type' => 'select',
				'std' => '0',
				'options' => array(
					'0' => __('No', 'om_portfolio'),
					'1' => __('Yes', 'om_portfolio'),
				)
			),
			'ompf_portfolio_layout' => array (
				'name' => __('Portfolio layout','om_portfolio'),
				'desc' => '',
				'id' => 'ompf_portfolio_layout',
				'type' => 'select',
				'std' => 'fixed',
				'options' => ompf_get_options_arr('layout'),
			),
			'ompf_portfolio_thumbs_size' => array (
				'name' => __('Thumbnail size','om_portfolio'),
				'desc' => '',
				'id' => 'ompf_portfolio_thumbs_size',
				'type' => 'select',
				'std' => 'medium',
				'options' => ompf_get_options_arr('size'),
			),
			'ompf_portfolio_fixed_ratio' => array (
				'name' => __('Thumbnail width/height ratio','om_portfolio'),
				'desc' => __('If fixed cells layout chosen above choose the ratio','om_portfolio'),
				'id' => 'ompf_portfolio_fixed_ratio',
				'type' => 'select',
				'std' => '1.5',
				'options' => ompf_get_options_arr('ratio'),
				'code' => '
					<script>
						jQuery(function($){
							$("#ompf_portfolio_layout").change(function(){
								if($(this).val() == "fixed") {
									$("#ompf_portfolio_fixed_ratio").parents("tr").show();
								} else {
									$("#ompf_portfolio_fixed_ratio").parents("tr").hide();
								}
							}).change();
						});
					</script>
				',
			),
			'ompf_portfolio_preview_layout' => array (
				'name' => __('Preview layout','om_portfolio'),
				'desc' => '',
				'id' => 'ompf_portfolio_preview_layout',
				'type' => 'select',
				'std' => 'full',
				'options' => ompf_get_options_arr('preview_layout'),
			),
			'ompf_portfolio_item_margins' => array (
				'name' => __('Item margins','om_portfolio'),
				'desc' => __('Gap between portfolio items in the grid','om_portfolio'),
				'id' => 'ompf_portfolio_item_margins',
				'type' => 'select',
				'std' => 'standard',
				'options' => array(
					'standard' => __('Standard','om_portfolio'),
					'none' => __('No margins','om_portfolio'),
				)
			),
			'ompf_portfolio_full_width' => array (
				'name' => __('Expand to full width','om_portfolio'),
				'desc' => __('Remove page left/right paddings','om_portfolio'),
				'id' => 'ompf_portfolio_full_width',
				'type' => 'select',
				'std' => '',
				'options' => array(
					'' => __('No','om_portfolio'),
					'1' => __('Yes','om_portfolio'),
				)
			),
			'ompf_portfolio_sort' => array(
				'name' => __('Items order', 'om_portfolio'),
				'desc' => __('If custom sort chosen, porfolio items should be sorted on "Portfolio Sort" page', 'om_portfolio'),
				'id' =>  'ompf_portfolio_sort',
				'std' => 'date_desc',
				'options'=>ompf_get_options_arr('sort'),
				'type' => 'select',
			),
			'ompf_portfolio_categories_selector' => array (
				'name' => __('Display categories selector','om_portfolio'),
				'desc' => '',
				'id' => 'ompf_portfolio_categories_selector',
				'type' => 'select',
				'std' => 'yes',
				'options' => array(
					'yes' => __('Yes','om_portfolio'),
					'no' => __('No','om_portfolio'),
				)
			),
			'ompf_portfolio_categories_sort' => array(
				'name' => __('Categories order in selector', 'om_portfolio'),
				'desc' => '',
				'id' =>  'ompf_portfolio_categories_sort',
				'std' => 'name',
				'options'=>array(
					'name' => __('by Name','om_portfolio'),
					'count' => __('by Count of the posts','om_portfolio'),
					'slug' => __('by Slug','om_portfolio'),
				),
				'type' => 'select',
				'code' => '
					<script>
						jQuery(function($){
							$("#ompf_portfolio_categories_selector").change(function(){
								if($(this).val() == "yes") {
									$("#ompf_portfolio_categories_sort").parents("tr").show();
								} else {
									$("#ompf_portfolio_categories_sort").parents("tr").hide();
								}
							}).change();
						});
					</script>
				',
			),
			'ompf_portfolio_pagination' => array(
				'name' => __('Portfolio Pagination', 'om_portfolio'),
				'desc' => '',
				'id' =>  'ompf_portfolio_pagination',
				'std' => 'no',
				'options'=>array(
					'no' => __('No pagination, display all items','om_portfolio'),
					'pages' => __('Enable pagination','om_portfolio'),
					'scroll' => __('Infitine scroll (load items on page scroll)','om_portfolio'),
				),
				'type' => 'select',
			),
		
			'ompf_portfolio_per_page' => array(
				'name' => __('Number of items per page', 'om_portfolio'),
				'desc' => '',
				'id' =>  'ompf_portfolio_per_page',
				'std' => '0',
				'type' => 'text',
				'code' => '
					<script>
						jQuery(function($){
							$("#ompf_portfolio_pagination").change(function(){
								if($(this).val() == "pages" || $(this).val() == "scroll") {
									$("#ompf_portfolio_per_page").parents("tr").show();
								} else {
									$("#ompf_portfolio_per_page").parents("tr").hide();
								}
							}).change();
						});
					</script>
				',
			),

			'ompf_portfolio_categories' => array (
				'name' => __('Choose the category to display','om_portfolio'),
				'desc' => __('You can create multiple portfolio pages and show different categories on the each page. If you want to display specific portfolio category firstly create it, then add child sub-categories for it and choose the root category here','om_portfolio'),
				'id' => 'ompf_portfolio_categories',
				'type' => 'portfolio_root_cats',
				'std' => ''
			),
		),
	),
	
);
 
function ompf_add_page_meta_box() {
	global $ompf_page_meta_box;

	if( $GLOBALS['omPortfolioPlugin']['config']['theme_supplies_page_template'] )	
		unset($ompf_page_meta_box['portfolio']['fields']['ompf_portfolio_display']);

	if( !$GLOBALS['omPortfolioPlugin']['config']['theme_support_portfolio_width100'] )	
		unset($ompf_page_meta_box['portfolio']['fields']['ompf_portfolio_full_width']);
		
	$ompf_page_meta_box=apply_filters('ompf_page_meta_box', $ompf_page_meta_box);
	
	ompfmb_add_meta_boxes($ompf_page_meta_box, 'page');
 
}
add_action('add_meta_boxes', 'ompf_add_page_meta_box');

/*************************************************************************************
 *	Save MetaBox data
 *************************************************************************************/

function ompf_save_page_metabox($post_id) {
	global $ompf_page_meta_box;
 
	ompfmb_save_metabox($post_id, $ompf_page_meta_box);

}
add_action('save_post', 'ompf_save_page_metabox');

/*************************************************************************************
 *	Load JS Scripts and Styles
 *************************************************************************************/
 
function ompf_page_meta_box_scripts($hook) {

	if( 'post.php' != $hook && 'post-new.php' != $hook )
		return;
			
	if( $GLOBALS['omPortfolioPlugin']['config']['theme_supplies_page_template'] )	
		wp_enqueue_script('ompf-admin-page-meta', $GLOBALS['omPortfolioPlugin']['path_url'] . 'assets/js/page-meta.js', array('jquery'));
}
add_action('admin_enqueue_scripts', 'ompf_page_meta_box_scripts');
