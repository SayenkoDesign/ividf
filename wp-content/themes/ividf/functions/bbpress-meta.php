<?php


/*************************************************************************************
 *	Add MetaBox to Product page
 *************************************************************************************/

$om_bbpress_meta_box=array ();
om_add_common_meta_boxes($om_bbpress_meta_box, array('sidebar'), 'om-bbpress-meta-box-');

function om_add_bbpress_meta_box() {
	global $om_bbpress_meta_box;

	if(function_exists('bbp_get_forum_post_type'))
		ommb_add_meta_boxes($om_bbpress_meta_box, bbp_get_forum_post_type());
	
}
add_action('add_meta_boxes', 'om_add_bbpress_meta_box');

 
/*************************************************************************************
 *	Save MetaBox data
 *************************************************************************************/

function om_save_bbpress_metabox($post_id) {
	global $om_bbpress_meta_box;
 
	ommb_save_metabox($post_id, $om_bbpress_meta_box);

}
add_action('save_post', 'om_save_bbpress_metabox');
