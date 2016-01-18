<?php

/*************************************************************************************
 *	Add MetaBox to Testimonials edit page
 *************************************************************************************/

function omtm_add_testimonials_meta_box() {
	
	$metabox=array (
		'id' => 'omtm-testimonials-meta-box-details',
		'name' =>  __('Testimonial Details', 'om_testimonials'),
		'fields' => array (
			array ( "name" => __('Author','om_testimonials'),
					"desc" => '',
					"id" => "om_testimonial_author_desc",
					"type" => "text",
					"std" => '',
			),
		),
	);

	add_meta_box(
		$metabox['id'],
		$metabox['name'],
		'ommb_testimonials_meta_box_html',
		'testimonials',
		( isset($metabox['context']) ? $metabox['context'] : 'normal' ),
		( isset($metabox['priority']) ? $metabox['priority'] : 'high' ),
		$metabox
	);
	
}
add_action('add_meta_boxes', 'omtm_add_testimonials_meta_box');

/*************************************************************************************
 *	Display MetaBox data
 *************************************************************************************/
 
function ommb_testimonials_meta_box_html($post, $metabox) {
	
	$fields=$metabox['args']['fields'];

	$output='';
	
	$output.= '<input type="hidden" name="omtm_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	$output.= '<table class="form-table"><col width="25%"/><col/>';
 
	foreach ($fields as $field) {
		
		$meta = get_post_meta($post->ID, $field['id'], true);
		
		switch ($field['type']) {

			case 'text':
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
							<div class="howto">'. $field['desc'].'</div>
						</th>
						<td>
							<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.esc_attr( ($meta ? $meta : $field['std']) ). '" style="width:75%;" />
						</td>
					</tr>
				';
			break;
			
		}

	}
	$output.= '</table>';
	
	echo $output;
}

/*************************************************************************************
 *	Save MetaBox data
 *************************************************************************************/

function omtm_save_testimonials_metabox($post_id) {

 	if (!isset($_POST['omtm_meta_box_nonce']) || !wp_verify_nonce($_POST['omtm_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}
		
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
 
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		}
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	if( isset($_POST['om_testimonial_author_desc']) ) {
		update_post_meta($post_id, 'om_testimonial_author_desc', $_POST['om_testimonial_author_desc']);
	}

}
add_action('save_post', 'omtm_save_testimonials_metabox');
