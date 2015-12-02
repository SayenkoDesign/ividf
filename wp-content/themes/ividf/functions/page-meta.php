<?php

/*************************************************************************************
 *	Add MetaBox to Page edit page
 *************************************************************************************/

$om_page_meta_box=array();

$om_page_meta_box['blog'] = array (
	'id' => 'om-page-meta-box-blog',
	'name' => __('Blog options', 'om_theme'),
	'fields' => array (
		array ( "name" => __('Blog Layout','om_theme'),
				"desc" => '',
				"id" => OM_THEME_SHORT_PREFIX."blog_layout",
				"type" => "select",
				"std" => 'small',
				'options' => array(
					'small' => __('Standard / Small thumbnails', 'om_theme'),
					'medium' => __('Standard / Medium thumbnails', 'om_theme'),
					'large' => __('Standard / Large thumbnails', 'om_theme'),
					'grid-2' => __('Grid Medium', 'om_theme'),
					'grid-3' => __('Grid Small', 'om_theme'),
				)
		),

		array ( "name" => __('Categories to display','om_theme'),
				"desc" => '',
				"id" => OM_THEME_SHORT_PREFIX."blog_categories",
				"type" => "categories_list_multiple",
				"std" => '',
		),
		
	),
);

om_add_common_meta_boxes($om_page_meta_box, array('pagetitle', 'slider', 'header', 'sidebar'), 'om-page-meta-box-');
	
function om_add_page_meta_box() {
	global $om_page_meta_box;

	ommb_add_meta_boxes($om_page_meta_box, 'page');
	
}
add_action('add_meta_boxes', 'om_add_page_meta_box');


/*************************************************************************************
 *	Save MetaBox data
 *************************************************************************************/

function om_save_page_metabox($post_id) {
	global $om_page_meta_box;
 
	ommb_save_metabox($post_id, $om_page_meta_box);

}
add_action('save_post', 'om_save_page_metabox');

/*************************************************************************************
 *	Load JS Scripts and Styles
 *************************************************************************************/
 
function om_page_meta_box_scripts($hook) {
	if( 'post.php' != $hook && 'post-new.php' != $hook )
		return;

	wp_enqueue_script('om-admin-page-meta', TEMPLATE_DIR_URI . '/admin/js/page-meta.js', array('jquery'));
}
add_action('admin_enqueue_scripts', 'om_page_meta_box_scripts');
