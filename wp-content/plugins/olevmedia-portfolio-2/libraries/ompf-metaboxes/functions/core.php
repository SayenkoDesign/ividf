<?php

/*************************************************************************************
 *	Add metaboxes
 *************************************************************************************/

function ompfmb_add_meta_boxes($metaboxes, $post_type, $context='normal', $priority='high') {

	foreach($metaboxes as $metabox) {
		
		add_meta_box(
			$metabox['id'],
			$metabox['name'],
			( isset($metabox['callback']) ? $metabox['callback'] : 'ompfmb_generate_meta_box' ),
			$post_type,
			( isset($metabox['context']) ? $metabox['context'] : 'normal' ),
			( isset($metabox['priority']) ? $metabox['priority'] : 'high' ),
			$metabox
		);
		
	}
 
}

/*************************************************************************************
 *	MetaBox Generator
 *************************************************************************************/

function ompfmb_generate_meta_box($post, $metabox) {

	$fields=$metabox['args']['fields'];

	$output='';
	
	$extra_code='';

	$output.= '<input type="hidden" name="ompfmb_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	$output.= '<table class="form-table"><col width="25%"/><col/>';
 
	foreach ($fields as $field) {
		
		$meta = get_post_meta($post->ID, $field['id'], true);
		
		if(isset($field['code']))
			$extra_code.=$field['code'];
		
		if(has_filter('ompfmb_metabox_'.$field['type'])) {
			$output .= apply_filters('ompfmb_metabox_'.$field['type'], $field, $meta, $post->ID);
			continue;
		}

		switch ($field['type']) {

			case 'info':
				$output.= '
					<tr>
						<td colspan="2">
							<div class="howto">'. $field['desc'].'</div>
						</td>
					</tr>
				';
			break;	
			
			case 'textarea':
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'">
								<strong>'.$field['name'].'</strong>
								<div class="howto">'. $field['desc'].'</div>
							</label>
						</th>
						<td>
							<textarea name="'.$field['id'].'" id="'.$field['id'].'" rows="'.(@$field['rows']?$field['rows']:8).'" style="width:100%;">'.esc_textarea(($meta ? $meta : $field['std'])).'</textarea>
						</td>
					</tr>
				';
			break;
			
			case 'text':
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
							<div class="howto">'. $field['desc'].'</div>
						</th>
						<td>
							<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.esc_attr(($meta ? $meta : $field['std'])). '" style="width:75%;" />
						</td>
					</tr>
				';
			break;
			
			case 'text_browse':

				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
							<div class="howto">'. $field['desc'].'</div>
						</th>
						<td>
							<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.esc_attr(($meta ? $meta : $field['std'])). '" style="width:75%;" />
							<a href="#" class="button om-metabox-input-browse-button" rel="'.$field['id'].'"'.(@$field['library']?' data-library="'.$field['library'].'"':'').' data-choose="'.__('Choose a file',$GLOBALS['ompfMetaboxes']['text_domain']).'" data-select="'.__('Select',$GLOBALS['ompfMetaboxes']['text_domain']).'">'.__('Browse',$GLOBALS['ompfMetaboxes']['text_domain']).'</a>
						</td>
					</tr>
				';
			break;

			case 'select':
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
							<div class="howto">'. $field['desc'].'</div>
						</th>
						<td>
							<select id="' . $field['id'] . '" name="'.$field['id'].'">
				';
				$selected=($meta ? $meta : $field['std']);
				foreach ($field['options'] as $k=>$option) {
					$output.= '<option'.($selected == $k ? ' selected="selected"':'').' value="'. $k .'">'. $option .'</option>';
				} 
				$output.='
							</select>
						</td>
					</tr>
				';
			break;
			
			case 'color':
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
							<div class="howto">'. $field['desc'].'</div>
						</th>
						<td>
							<input class="om-metabox-color-picker-field" name="'. $field['id'] .'" id="'. $field['id'] .'" type="text" value="'.esc_attr(($meta ? $meta : $field['std'])). '" data-default-color="'. esc_attr($field['std']) .'" />
						</td>
					</tr>
				';
			break;

			case 'portfolio_root_cats':
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
							<div class="howto">'. $field['desc'].'</div>
						</th>
						<td>
				';

					$args = array(
						'show_option_all'    => __('All Categories', $GLOBALS['ompfMetaboxes']['text_domain']),
						'show_option_none'   => '',
						'hide_empty'         => 0, 
						'echo'               => 0,
						'selected'           => $meta,
						'hierarchical'       => 1, 
						'name'               => $field['id'],
						'id'         		     => $field['id'],
						'class'              => '',
						'depth'              => 1,
						'tab_index'          => 0,
						'taxonomy'           => 'portfolio-type',
						'hide_if_empty'      => false 	
					);
			
					$output .= wp_dropdown_categories( $args );

				$output .='			
						</td>
					</tr>
				';
			break;
			
			case 'gallery':
						
				$button_title=__('Manage Images', $GLOBALS['ompfMetaboxes']['text_domain']);
				if(@$field['button_title'])
					$button_title=$field['button_title'];
					
				$ids=explode(',',@$meta['images']);
				$images=array();
				if(!empty($ids)) {
					foreach($ids as $id) {
						$src=wp_get_attachment_image_src( $id, 'thumbnail' );
						if($src) {
							$images[]='<div class="om-item" data-attachment-id="'.$id.'"><img src="'.$src[0].'" width="'.$src[1].'" height="'.$src[2].'" /><span class="om-remove"></span></div>';
						}
					}
				}
				
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.__('Choose which images you want to show in gallery', $GLOBALS['ompfMetaboxes']['text_domain']).'</strong>
						</th>
						<td>
							';
				if(isset($field['mode']) && $field['mode'] == 'custom_gallery') {
					$output.='
							<input type="hidden" name="'.$field['id'].'[type]" id="'.$field['id'].'-type" class="om-metabox-gallery-select" data-field-id="'.$field['id'].'" value="custom" />
					';
				} else {
					$options=array(
						'<option value="custom"'.(@$meta['type']=='custom'?' selected="selected"':'').'>'.__('Custom images set from Media Library',$GLOBALS['ompfMetaboxes']['text_domain']).'</option>',
						'<option value="attached"'.(@$meta['type']=='attached'?' selected="selected"':'').'>'.__('Images uploaded and attached to current post via WordPress standard Media Manager',$GLOBALS['ompfMetaboxes']['text_domain']).'</option>',
					);
					if(isset($field['attached_first']) && $field['attached_first'])
						$options=array_reverse($options);
					$output.='<select name="'.$field['id'].'[type]" id="'.$field['id'].'-type" class="om-metabox-gallery-select" data-field-id="'.$field['id'].'" style="max-width:300px">'.implode('',$options).'</select>';
				}
				$output.='
							<input type="hidden" name="'.$field['id'].'[images]" id="'.$field['id'].'-images" value="'.(@$meta['images']).'" />
							<div class="om-metabox-gallery-attached" id="'.$field['id'].'-gallery-attached">
				';
				$output.='<a href="#" class="button om-metabox-manage-attached-button" data-choose="'.__('Gallery images',$GLOBALS['ompfMetaboxes']['text_domain']).'" data-post-id="'.($post->ID).'">'.$button_title.'</a>';
				$output.='
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="om-metabox-gallery-wrapper" id="'.$field['id'].'-gallery-wrapper" data-current-page="1" data-images-input-id="'.$field['id'].'-images">
								<div class="om-metabox-gallery-images-wrapper">
									<div class="om-metabox-gallery-images-title">'.__('Chosen Images', $GLOBALS['ompfMetaboxes']['text_domain']).'</div>
									<div class="om-metabox-gallery-images-no-images"'.(count($images)?' style="display:none"':'').'>'.__('No images yet, choose from the images below', $GLOBALS['ompfMetaboxes']['text_domain']).'</div>
									<div class="om-metabox-gallery-images" data-count="'.count($images).'">'.implode('',$images).'</div>
									<div class="clear"></div>
								</div>
								<div class="om-metabox-gallery-library">
									<div class="om-metabox-gallery-library-controls"></div>
									<div class="om-metabox-gallery-library-images"></div>
									<div class="om-metabox-gallery-library-add">
										<a href="#" class="button om-metabox-media-add-button" data-choose="'.__('Upload images',$GLOBALS['ompfMetaboxes']['text_domain']).'" data-post-id="'.($post->ID).'">'.__('Add media',$GLOBALS['ompfMetaboxes']['text_domain']).'</a>
										<a href="#" class="button om-metabox-gallery-library-refresh" data-field-id="'.$field['id'].'">'.__('Refresh',$GLOBALS['ompfMetaboxes']['text_domain']).'</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				';
			break;
			
			case 'slider':
			
				if( ompfmb_check_slider_exists() ){
					
					$output.= '
						<tr>
							<th>
								<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
								<div class="howto">'. $field['desc'].'</div>
							</th>
							<td>
								<select id="' . $field['id'] . '" name="'.$field['id'].'"><option value="">'.__('Select a Slider',$GLOBALS['ompfMetaboxes']['text_domain']).'</option>
					';
					$selected=($meta ? $meta : $field['std']);

					if( ompfmb_check_slider_exists('lslider') ) {
						$output .= '<optgroup label="LayerSlider">';

				    global $wpdb;
				    $table_name = $wpdb->prefix . "layerslider";
				    $sliders = $wpdb->get_results( "SELECT * FROM $table_name
				                                        WHERE flag_hidden = '0' AND flag_deleted = '0'
				                                        ORDER BY date_c ASC LIMIT 100" );
				    foreach($sliders as $key => $item) {
				        $output .= '<option'.($selected == 'lslider_'.$item->id ? ' selected="selected"':'').' value="lslider_'.$item->id.'">'.esc_html($item->name).'</option>';
				    }
				    
						$output .= '</optgroup>';
					}	
	
					if( ompfmb_check_slider_exists('revslider') ) {
						$output .= '<optgroup label="Slider Revolution">';
				    $slider = new RevSlider();
						$arrSliders = $slider->getArrSliders();
						foreach($arrSliders as $revSlider) {
							$k=$revSlider->getAlias();
							$output.= '<option'.($selected == 'revslider_'.$k ? ' selected="selected"':'').' value="revslider_'. $k .'">'. esc_html($revSlider->getTitle()) .'</option>';
						}
						$output .= '</optgroup>';
					}

					$output.='
								</select>
							</td>
						</tr>
					';
				}
				
			break;
			
		}

	}
	$output.= '</table>'.$extra_code;
	
	echo $output;
}

/*************************************************************************************
 *	Save MetaBox data
 *************************************************************************************/

function ompfmb_save_metabox($post_id, $om_meta_box) {

 	if (!isset($_POST['ompfmb_meta_box_nonce']) || !wp_verify_nonce($_POST['ompfmb_meta_box_nonce'], basename(__FILE__))) {
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
 
 	foreach ($om_meta_box as $metabox_key=>$metabox) {
		foreach ($metabox['fields'] as $field) {
			if(isset($_POST[$field['id']])) {
				update_post_meta($post_id, $field['id'], $_POST[$field['id']]);
			}
		}
	}
}

/*************************************************************************************
 *	Load JS Scripts and Styles
 *************************************************************************************/

function ompfmb_common_meta_box_scripts() {
	wp_enqueue_style('ommb-metaboxes', $GLOBALS['ompfMetaboxes']['path_url'] . 'assets/css/common-meta.css');
	wp_enqueue_style('wp-color-picker');

	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('ommb-metaboxes', $GLOBALS['ompfMetaboxes']['path_url'] . 'assets/js/common-meta.js', array('jquery'));
	wp_enqueue_script('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'ompfmb_common_meta_box_scripts');

/*************************************************************************************
 *	Handling AJAX Queries from Metabox Custom Gallery
 *************************************************************************************/

function ompfmb_ajax_metabox_gallery() {

	$per_page=12;
	$current_page=intval($_POST['page']);
	if(!$current_page)
		$current_page=1;

	$ret=array();
	$ret['page']=$current_page;
	
	
	$query_images = new WP_Query( array(
		'post_type' => 'attachment',
		'post_mime_type' =>'image',
		'post_status' => 'inherit',
		'posts_per_page' => $per_page,
		'paged' => $current_page,
	));
	
	$ret['max_num_pages'] = $query_images->max_num_pages;
	$ret['images'] = array();
	
	foreach ( $query_images->posts as $image ) {
		$src=wp_get_attachment_image_src( $image->ID, 'thumbnail' );
		$ret['images'][]=array(
			'ID' => $image->ID,
			'title' => $image->post_title,
			'src' => $src[0],
			'width' => $src[1],
			'height' => $src[2],
		);
	}
	
	header('Content-type: application/json');
	echo json_encode($ret);
	exit;
	
}
add_action('wp_ajax_ompfmb_metabox_gallery', 'ompfmb_ajax_metabox_gallery');
