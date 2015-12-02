<?php

/*************************************************************************************
 *	Add metaboxes
 *************************************************************************************/

function ommb_add_meta_boxes($metaboxes, $post_type, $context='normal', $priority='high') {

	foreach($metaboxes as $metabox) {
		
		add_meta_box(
			$metabox['id'],
			$metabox['name'],
			( isset($metabox['callback']) ? $metabox['callback'] : 'ommb_generate_meta_box' ),
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

function ommb_generate_meta_box($post, $metabox) {

	$fields=$metabox['args']['fields'];

	$output='';
	
	$extra_code='';

	$output.= '<input type="hidden" name="ommb_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	$output.= '<table class="form-table"><col width="25%"/><col/>';
 
	foreach ($fields as $field) {
		
		$meta = get_post_meta($post->ID, $field['id'], true);
		
		if(isset($field['code']))
			$extra_code.=$field['code'];
		
		if(has_filter('ommb_metabox_'.$field['type'])) {
			$output .= apply_filters('ommb_metabox_'.$field['type'], $field, $meta, $post->ID);
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
							<a href="#" class="button om-metabox-input-browse-button" rel="'.$field['id'].'"'.(@$field['library']?' data-library="'.$field['library'].'"':'').' data-choose="'.__('Choose a file',$GLOBALS['omMetaboxes']['text_domain']).'" data-select="'.__('Select',$GLOBALS['omMetaboxes']['text_domain']).'">'.__('Browse',$GLOBALS['omMetaboxes']['text_domain']).'</a>
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
							<input class="om-metabox-color-picker-field" name="'. $field['id'] .'" id="'. $field['id'] .'" type="text" value="'.esc_attr(($meta ? $meta : $field['std'])).'" data-default-color="'. esc_attr($field['std']) .'" />
						</td>
					</tr>
				';
			break;

			case 'categories_list_single':
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
							<div class="howto">'. $field['desc'].'</div>
						</th>
						<td>
				';

				$args = array(
					'show_option_all'    => __('All Categories', $GLOBALS['omMetaboxes']['text_domain']),
					'show_option_none'   => '',
					'orderby' => 'name',
					'hide_empty'         => 0, 
					'echo'               => 0,
					'selected'           => $meta,
					'hierarchical'       => 1, 
					'name'               => $field['id'],
					'id'         		     => $field['id'],
					'class'              => '',
					'depth'              => 4,
					'tab_index'          => 0,
					'taxonomy'           => 'category',
					'hide_if_empty'      => false 	
				);
				
				if(isset($field['args'])) {
					$args=array_merge($args, $field['args']);
				}
		
				$output .= wp_dropdown_categories( $args );

				$output .='			
						</td>
					</tr>
				';
			break;
			
			case 'categories_list_multiple':
				$output.= '
					<tr>
						<th>
							<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
							<div class="howto">'. $field['desc'].'</div>
						</th>
						<td>
				';

				$args = array(
					'show_option_all'    => __('All Categories', $GLOBALS['omMetaboxes']['text_domain']),
					'show_option_none'   => '',
					'orderby' => 'name',
					'hide_empty'         => 0, 
					'echo'               => 0,
					'selected'           => '',
					'hierarchical'       => 1, 
					'name'               => $field['id'].'[]',
					'id'         		     => $field['id'],
					'class'              => '',
					'depth'              => 4,
					'tab_index'          => 0,
					'taxonomy'           => 'category',
					'hide_if_empty'      => false 	
				);
				
				if(isset($field['args'])) {
					$args=array_merge($args, $field['args']);
				}
		
				$list = wp_dropdown_categories( $args );
				if(!$meta || $meta == '0') {
					$list = str_replace("value='0'","value='0' selected='selected'",$list);
				} else {
					$tmp=explode(',',$meta);
					foreach($tmp as $k) {
						$list = str_replace('value="'.$k.'"','value="'.$k.'" selected="selected"',$list);
					}
				}
	
				$list = str_replace('<select','<select style="min-width:200px" multiple="multiple" size="4"',$list);
				
				$output .= $list;

				$output .='			
						</td>
					</tr>
				';
			break;
			
			case 'gallery':
						
				$button_title=__('Manage Images', $GLOBALS['omMetaboxes']['text_domain']);
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
							<label for="'.$field['id'].'"><strong>'.__('Choose which images you want to show in gallery', $GLOBALS['omMetaboxes']['text_domain']).'</strong>
						</th>
						<td>
							';
				if(isset($field['mode']) && $field['mode'] == 'custom_gallery') {
					$output.='
							<input type="hidden" name="'.$field['id'].'[type]" id="'.$field['id'].'-type" class="om-metabox-gallery-select" data-field-id="'.$field['id'].'" value="custom" />
					';
				} else {
					$options=array(
						'<option value="custom"'.(@$meta['type']=='custom'?' selected="selected"':'').'>'.__('Custom images set from Media Library',$GLOBALS['omMetaboxes']['text_domain']).'</option>',
						'<option value="attached"'.(@$meta['type']=='attached'?' selected="selected"':'').'>'.__('Images uploaded and attached to current post via WordPress standard Media Manager',$GLOBALS['omMetaboxes']['text_domain']).'</option>',
					);
					if(isset($field['attached_first']) && $field['attached_first'])
						$options=array_reverse($options);
					$output.='<select name="'.$field['id'].'[type]" id="'.$field['id'].'-type" class="om-metabox-gallery-select" data-field-id="'.$field['id'].'" style="max-width:300px">'.implode('',$options).'</select>';
				}
				$output.='
							<input type="hidden" name="'.$field['id'].'[images]" id="'.$field['id'].'-images" value="'.(@$meta['images']).'" />
							<div class="om-metabox-gallery-attached" id="'.$field['id'].'-gallery-attached">
				';
				$output.='<a href="#" class="button om-metabox-manage-attached-button" data-choose="'.__('Gallery images',$GLOBALS['omMetaboxes']['text_domain']).'" data-post-id="'.($post->ID).'">'.$button_title.'</a>';
				$output.='
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div class="om-metabox-gallery-wrapper" id="'.$field['id'].'-gallery-wrapper" data-current-page="1" data-images-input-id="'.$field['id'].'-images">
								<div class="om-metabox-gallery-images-wrapper">
									<div class="om-metabox-gallery-images-title">'.__('Chosen Images', $GLOBALS['omMetaboxes']['text_domain']).'</div>
									<div class="om-metabox-gallery-images-no-images"'.(count($images)?' style="display:none"':'').'>'.__('No images yet, choose from the images below', $GLOBALS['omMetaboxes']['text_domain']).'</div>
									<div class="om-metabox-gallery-images" data-count="'.count($images).'">'.implode('',$images).'</div>
									<div class="clear"></div>
								</div>
								<div class="om-metabox-gallery-library">
									<div class="om-metabox-gallery-library-controls"></div>
									<div class="om-metabox-gallery-library-images"></div>
									<div class="om-metabox-gallery-library-add">
										<a href="#" class="button om-metabox-media-add-button" data-choose="'.__('Upload images',$GLOBALS['omMetaboxes']['text_domain']).'" data-post-id="'.($post->ID).'">'.__('Add media',$GLOBALS['omMetaboxes']['text_domain']).'</a>
										<a href="#" class="button om-metabox-gallery-library-refresh" data-field-id="'.$field['id'].'">'.__('Refresh',$GLOBALS['omMetaboxes']['text_domain']).'</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				';
			break;
			
			case 'slider':
			
				if( ommb_check_slider_exists() ){
					
					$output.= '
						<tr>
							<th>
								<label for="'.$field['id'].'"><strong>'.$field['name'].'</strong>
								<div class="howto">'. $field['desc'].'</div>
							</th>
							<td>
								<select id="' . $field['id'] . '" name="'.$field['id'].'"><option value="">'.__('Select a Slider',$GLOBALS['omMetaboxes']['text_domain']).'</option>
					';
					$selected=($meta ? $meta : $field['std']);

					if( ommb_check_slider_exists('lslider') ) {

				    global $wpdb;
				    $table_name = $wpdb->prefix . "layerslider";
				    $sliders = $wpdb->get_results( "SELECT * FROM $table_name
				                                        WHERE flag_hidden = '0' AND flag_deleted = '0'
				                                        ORDER BY date_c ASC LIMIT 100" );
						$output .= '<optgroup label="LayerSlider'.(empty($sliders) ? ' ('.__('No sliders created yet','om_theme').')' : '').'">';

				    foreach($sliders as $key => $item) {
				        $output .= '<option'.($selected == 'lslider_'.$item->id ? ' selected="selected"':'').' value="lslider_'.$item->id.'">'.esc_html($item->name).'</option>';
				    }
				    
						$output .= '</optgroup>';
					}	
	
					if( ommb_check_slider_exists('revslider') ) {
				    $slider = new RevSlider();
						$arrSliders = $slider->getArrSliders();
						$output .= '<optgroup label="Slider Revolution'.(empty($arrSliders) ? ' ('.__('No sliders created yet','om_theme').')' : '').'">';
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
	
	echo  $output; // no escape needed, all variables, used in the HTML code are escaped
}

/*************************************************************************************
 *	Save MetaBox data
 *************************************************************************************/

function ommb_save_metabox($post_id, $om_meta_box) {

 	if (!isset($_POST['ommb_meta_box_nonce']) || !wp_verify_nonce($_POST['ommb_meta_box_nonce'], basename(__FILE__))) {
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
			if( isset($_POST[$field['id']]) ) {
				if($field['type'] == 'categories_list_multiple') {
					if(is_array($_POST[$field['id']])) {
						update_post_meta($post_id, $field['id'], implode(',',$_POST[$field['id']]));
					} else {
					 	update_post_meta($post_id, $field['id'], '');
					}
				} else {
					update_post_meta($post_id, $field['id'], $_POST[$field['id']]);
				}
			} else {
				if($field['type'] == 'categories_list_multiple') {
				 	update_post_meta($post_id, $field['id'], '');
				}
			}
		}
	}
}

/*************************************************************************************
 *	Load JS Scripts and Styles
 *************************************************************************************/

function ommb_common_meta_box_scripts() {
	wp_enqueue_style('ommb-metaboxes', $GLOBALS['omMetaboxes']['path_url'] . 'assets/css/common-meta.css');
	wp_enqueue_style('wp-color-picker');

	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('ommb-metaboxes', $GLOBALS['omMetaboxes']['path_url'] . 'assets/js/common-meta.js', array('jquery'));
	wp_enqueue_script('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'ommb_common_meta_box_scripts');

/*************************************************************************************
 *	Handling AJAX Queries from Metabox Custom Gallery
 *************************************************************************************/

function ommb_ajax_metabox_gallery() {

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
add_action('wp_ajax_ommb_metabox_gallery', 'ommb_ajax_metabox_gallery');
