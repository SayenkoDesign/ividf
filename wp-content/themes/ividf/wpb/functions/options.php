<?php

add_action( 'init', 'om_wpb_init' );

function om_wpb_init() {

	vc_remove_element('vc_widget_sidebar');
	vc_remove_element('vc_basic_grid');
	vc_remove_element('vc_media_grid');
	vc_remove_element('vc_masonry_grid');
	vc_remove_element('vc_masonry_media_grid');
	vc_remove_element('vc_round_chart');
	vc_remove_element('vc_line_chart');


	/**
	 * Row
	 */
	 
  vc_remove_param("vc_row", "css");
  vc_remove_param("vc_row", "parallax");
  vc_remove_param("vc_row", "parallax_image");
  vc_remove_param("vc_row", "full_height");
  vc_remove_param("vc_row", "content_placement");
  vc_remove_param("vc_row", "video_bg");
  vc_remove_param("vc_row", "video_bg_url");
  vc_remove_param("vc_row", "video_bg_parallax");

  $param = WPBMap::getParam('vc_row', 'full_width');
  $param['description']=__( 'Please, note, that if you use "Stretch row" option you must hide the sidebar on the page to make use of this option.', 'om_theme' );
  WPBMap::mutateParam('vc_row', $param);
    
  /*
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => __('Row Layout', 'om_theme'),
		'param_name' => 'row_layout',
		'value' => array(
			__('Standard', 'om_theme') => 'standard',
			__('Background - full width, content - standard width', 'om_theme') => 'expand_standard_paddings',
			__('Background - full width, content - full width with small paddings', 'om_theme') => 'expand_tiny_paddings',
			__('Background - full width, content - full width with no paddings', 'om_theme') => 'expand_no_paddings',
		),
		'description' => __( 'Please, note, that if you use "Expand to full width" option you must hide the sidebar on the page to make use of this option.', 'om_theme' ),
	));
	*/
	
	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => __('Font color', 'om_theme'),
		'param_name' => 'font_color',
		'description' => __( 'Select custom font color or leave empty to use default.', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => __('Row Background', 'om_theme'),
		'param_name' => 'bg_type',
		'value' => array(
			__('Solid Color', 'om_theme') => 'color',
			__('Gradient Color', 'om_theme') => 'gradient',
			__('Image', 'om_theme') => 'image',
			__('Video', 'om_theme') => 'video',
		),
		'group' => __( 'Background', 'om_theme' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => __('Background color', 'om_theme'),
		'param_name' => 'bg_color',
		//'description' => __( 'Select background color for the row. Notice: if you set background image, background color will be invisible (covered by image).', 'om_theme' ),
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('color','gradient'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => __('Background color 2', 'om_theme'),
		'param_name' => 'bg_color2',
		'description' => __( 'Second color of the gradient.', 'om_theme' ),
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('gradient'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => __('Gradient type', 'om_theme'),
		'param_name' => 'gradient_type',
		'value' => array(
			__('Vertical', 'om_theme').' ↓' => 'vertical',
			__('Horisontal', 'om_theme').' →' => 'horisontal',
			__('Diagonal', 'om_theme').' ↗' => 'diagonal1',
			__('Diagonal', 'om_theme').' ↘' => 'diagonal2',
			__('Radial', 'om_theme').' o' => 'radial',
		),
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('gradient'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_image',
		'heading' => __('Background image', 'om_theme'),
		'param_name' => 'bg_image',
		'description' => __( 'Select background image for the row.', 'om_theme' ),
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('image'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => __('Background image position', 'om_theme'),
		'param_name' => 'bg_image_pos',
		'value' => array_flip(om_get_bg_img_pos_options()),
		'dependency' => array(
			'element' => 'bg_image',
			'not_empty' => true,
		),
		'group' => __( 'Background', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => __('Background image attachment', 'om_theme'),
		'param_name' => 'bg_image_att',
		'value' => array(
			__('Scroll', 'om_theme') => 'scroll',
			__('Fixed', 'om_theme') => 'fixed',
			__('Parallax, up direction', 'om_theme') => 'parallax',
			__('Parallax, down direction', 'om_theme') => 'parallax_down',
		),
		'dependency' => array(
			'element' => 'bg_image',
			'not_empty' => true,
		),
		'group' => __( 'Background', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => __('Background Video File', 'om_theme'),
		'param_name' => 'bg_video_src',
		'description' => __( 'Select background video for the row.', 'om_theme' ),
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('video'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => __('MP4 Video File URL (Optional)', 'om_theme'),
		'param_name' => 'bg_video_mp4',
		'description' => __( 'Use as a fallback format in addition to the main video file.', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => __( 'Background', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => __('M4V Video File URL (Optional)', 'om_theme'),
		'param_name' => 'bg_video_m4v',
		'description' => __( 'Use as a fallback format in addition to the main video file.', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => __( 'Background', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => __('WebM Video File URL (Optional)', 'om_theme'),
		'param_name' => 'bg_video_webm',
		'description' => __( 'Use as a fallback format in addition to the main video file.', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => __( 'Background', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => __('OGV Video File URL (Optional)', 'om_theme'),
		'param_name' => 'bg_video_ogv',
		'description' => __( 'Use as a fallback format in addition to the main video file.', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => __( 'Background', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => __('WMV Video File URL (Optional)', 'om_theme'),
		'param_name' => 'bg_video_wmv',
		'description' => __( 'Use as a fallback format in addition to the main video file.', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => __( 'Background', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_video',
		'heading' => __('FLV Video File URL (Optional)', 'om_theme'),
		'param_name' => 'bg_video_flv',
		'description' => __( 'Use as a fallback format in addition to the main video file.', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_video_src',
			'not_empty' => true,
		),
		'group' => __( 'Background', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => __('Fallback background color', 'om_theme'),
		'param_name' => 'bg_color_fallback',
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('video'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'attach_image',
		'heading' => __('Fallback background image', 'om_theme'),
		'param_name' => 'bg_image_fallback',
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('video'),
		),
	));

	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => __('Fancy bottom edge', 'om_theme'),
		'param_name' => 'fancy_edge',
		'value' => array(
			__('No', 'om_theme') => '',
			__('Diagonal', 'om_theme').' /' => 'diagonal_left',
			__('Diagonal', 'om_theme').' \\' => 'diagonal_right',
			__('Corner', 'om_theme').' \/' => 'corner_down',
			__('Corner', 'om_theme').' /\\' => 'corner_up',
		),
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'bg_type',
			'value' => array('color'),
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'dropdown',
		'heading' => __('Edge size', 'om_theme'),
		'param_name' => 'fancy_edge_size',
		'value' => array(
			__('Small', 'om_theme') => 'sm',
			__('Medium', 'om_theme') => 'md',
			__('Large', 'om_theme') => 'lg',
			__('X-Large', 'om_theme') => 'xlg',
		),
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'fancy_edge',
			'not_empty' => true,
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'colorpicker',
		'heading' => __('Edge transient color', 'om_theme'),
		'param_name' => 'fancy_edge_t_color',
		'description' => __( 'Set this color if you want to apply transition to custom color (for instance background color of next section). Leave empty to disable transition.', 'om_theme' ),
		'group' => __( 'Background', 'om_theme' ),
		'dependency' => array(
			'element' => 'fancy_edge',
			'not_empty' => true,
		),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'textfield',
		'heading' => __('Top padding', 'om_theme'),
		'param_name' => 'padding_top',
		'description' => __( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'om_theme' ),
		'group' => __( 'Extra', 'om_theme' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'textfield',
		'heading' => __('Bottom padding', 'om_theme'),
		'param_name' => 'padding_bottom',
		'description' => __( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'om_theme' ),
		'group' => __( 'Extra', 'om_theme' ),
	));
	
	vc_add_param('vc_row', array(
		'type' => 'textfield',
		'heading' => __('Top margin', 'om_theme'),
		'param_name' => 'margin_top',
		'description' => __( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'om_theme' ),
		'group' => __( 'Extra', 'om_theme' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'textfield',
		'heading' => __('Bottom margin', 'om_theme'),
		'param_name' => 'margin_bottom',
		'description' => __( 'You can use px, em, %, etc. or enter just number and it will use pixels.', 'om_theme' ),
		'group' => __( 'Extra', 'om_theme' ),
	));

	vc_add_param('vc_row', array(
		'type' => 'textarea',
		'heading' => __('Custom CSS Style', 'om_theme'),
		'param_name' => 'custom_css',
		'description' => __( 'You can add custom CSS style for the row.', 'om_theme' ),
		'group' => __( 'Extra', 'om_theme' ),
	));	
	
	/**
	 * Video
	 */
	 
	vc_add_param('vc_video', array(
		'type' => 'dropdown',
		'value' => array(
			'2:1' => '2',
			'16:9' => '1.777778',
			'Golden ratio (1.61)' => '1.61',
			'3:2' => '1.5',
			'4:3' => '1.333333',
			'1:1' => '1',
			'3:4' => '0.75',
			'2:3' => '0.666667',
			'9:16' => '0.5625',
			'1:2' => '0.5',
		),
		'std' => '1.61',
		'heading' => __('Width/Height Ratio', 'om_theme'),
		'param_name' => 'ratio',
	));	

	vc_add_param('vc_video', array(
		'type' => 'textfield',
		'heading' => __('Maximum width (pixels)', 'om_theme'),
		'param_name' => 'maxwidth',
		'description' => __( 'By default video will fit all available width, you can specify maximum width', 'js_composer' )
	));	
	
	/**
	 * Gallery
	 */
	 
  $param = WPBMap::getParam('vc_gallery', 'type');
  unset($param['value']['Flex slider fade']);
  unset($param['value']['Flex slider slide']);
  $param['value']=array_merge(array(
  	__('OM slider','om_theme') => 'om',
  	__('Sliced','om_theme') => 'sliced',
  	__('Masonry','om_theme') => 'masonry',
  ),$param['value']);
  WPBMap::mutateParam('vc_gallery', $param);
  
  vc_remove_param("vc_gallery", "img_size");
  vc_remove_param("vc_gallery", "el_class");

	vc_add_param('vc_gallery', array(
		'type' => 'dropdown',
		'heading' => __('Columns number', 'om_theme'),
		'param_name' => 'columns',
		'value' => array(
			'1',
			'2',
			'3',
			'4',
			'5',
			'6',
			'7',
			'8',
			'9',
		),
		'dependency' => array(
			'element' => 'type',
			'value' => array('masonry','image_grid'),
		),
	));
	
	vc_add_param('vc_gallery', array(
		'type' => 'dropdown',
		'heading' => __('Images width/height ratio', 'om_theme'),
		'param_name' => 'ratio',
		'value' => array(
			'2:1' => '2:1',
			'16:9' => '16:9',
			'3:2' => '3:2',
			'4:3' => '4:3',
			'1:1' => '1:1',
			'3:4' => '3:4',
			'2:3' => '2:3',
			'9:16' => '9:16',
			'1:2' => '1:2',
		),
		'dependency' => array(
			'element' => 'type',
			'value' => array('image_grid'),
		),
	));
	
	vc_add_param('vc_gallery', array(
		'type' => 'checkbox',
		'heading' => __('Display captions', 'om_theme'),
		'param_name' => 'captions',
		'value' => array( __( 'Yes, please', 'om_theme' ) => 'yes' ),
		'dependency' => array(
			'element' => 'type',
			'value' => array('om','sliced','masonry','image_grid'),
		),
	));
	
	vc_add_param('vc_gallery', array(
		'type' => 'checkbox',
		'heading' => __('Use hi-res images', 'om_theme'),
		'description' => __( 'Check this option of you use gallery in a row without padding and the dimendions of images is not enough. Source images also must be high resolution in this case.', 'om_theme' ),
		'param_name' => 'hires',
		'value' => array( __( 'Yes, please', 'om_theme' ) => 'yes' ),
		'dependency' => array(
			'element' => 'type',
			'value' => array('sliced','masonry','image_grid'),
		),
	));
	
	vc_add_param('vc_gallery', array(
		'type' => 'textfield',
		'heading' => __( 'Extra class name', 'js_composer' ),
		'param_name' => 'el_class',
		'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
	));
	
	/**
	 * VC Column
	 */
	 
	$tmp=array(
		'type' => 'dropdown',
		'heading' => __( 'Delimiter', 'om_theme' ),
		'description' => __( 'Delimiter at right hand side, between columns.', 'om_theme' ),
		'param_name' => 'delimiter',
		'value' => array(
			__( 'No', 'om_theme' ) => '',
			__( 'Vertical line', 'om_theme' ) => 'vline',
			__( 'Horisontal line', 'om_theme' ) => 'hline',
			__( 'Dot', 'om_theme' ) => 'dot',
			__( 'Arrow', 'om_theme' ) => 'rarr',
		),
	);
	vc_add_param('vc_column', $tmp);
	vc_add_param('vc_column_inner', $tmp);
	
	/**
	 * Animation
	 */
	
	$css_animation = array(
		'type' => 'dropdown',
		'heading' => __( 'CSS Animation', 'js_composer' ),
		'param_name' => 'css_animation',
		'admin_label' => true,
		'value' => array(
			__( 'No', 'js_composer' ) => '',
			__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
			__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
			__( 'Left to right', 'js_composer' ) => 'left-to-right',
			__( 'Right to left', 'js_composer' ) => 'right-to-left',
			__( 'Appear from center', 'js_composer' ) => 'appear',
			/***/			
			__( 'Bounce', 'om_theme' ) => 'bounce',
			__('Zoom In','om_theme') => 'zoom-in',
			__('Zoom In Down','om_theme') => 'zoom-in-down',
			__('Zoom In Up','om_theme') => 'zoom-in-up',
			__('Zoom Out','om_theme') => 'zoom-out',
			__('Spin','om_theme') => 'spin',
			__('Spin around Left Top','om_theme') => 'spin-lt',
			__('Spin around Right Top','om_theme') => 'spin-rt',
			__('Flip','om_theme') => 'flip',
			__('Flip X','om_theme') => 'flip-x',
			__('Flip Y','om_theme') => 'flip-y',
		),
		'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
	);
	$css_animation_delay = array(
		'type' => 'textfield',
		'heading' => __( 'Delay before animation starts (milliseconds)', 'js_composer' ),
		'param_name' => 'css_animation_delay',
		'dependency' => array(
			'element' => 'css_animation',
			'not_empty' => true,
		),
	);
	
	vc_add_param('vc_column', $css_animation);
	vc_add_param('vc_column', $css_animation_delay);
	vc_add_param('vc_column_inner', $css_animation);
	vc_add_param('vc_column_inner', $css_animation_delay);
	
	vc_add_param('vc_row', $css_animation);
	vc_add_param('vc_row', $css_animation_delay);
	vc_add_param('vc_row_inner', $css_animation);
	vc_add_param('vc_row_inner', $css_animation_delay);
	
	WPBMap::mutateParam('vc_btn', $css_animation);
	WPBMap::mutateParam('vc_column_text', $css_animation);
	WPBMap::mutateParam('vc_cta', $css_animation);
	WPBMap::mutateParam('vc_message', array_merge($css_animation, array('admin_label' => false)));
	WPBMap::mutateParam('vc_single_image', $css_animation);
	WPBMap::mutateParam('vc_toggle', $css_animation);

	/**
	 * Toggle
	 */
	 
	vc_remove_param('vc_toggle', 'style');
	vc_remove_param('vc_toggle', 'color');
	vc_remove_param('vc_toggle', 'size');

	
 /**
  * om_icon_separator
  */
  
  $tmp=om_wpb_icon_params();
  $tmp=array_merge($tmp, array(
		array(
			'type' => 'dropdown',
			'heading' => __( 'Icon position', 'om_theme' ),
			'param_name' => 'title_align',
			'value' => array(
				__( 'Align center', 'js_composer' ) => 'separator_align_center',
				__( 'Align left', 'js_composer' ) => 'separator_align_left',
				__( 'Align right', 'js_composer' ) => "separator_align_right"
			),
			'description' => __( 'Select title location.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Color', 'js_composer' ),
			'param_name' => 'color',
			'value' => array_merge( getVcShared( 'colors' ), array( __( 'Custom color', 'js_composer' ) => 'custom' ) ),
			'std' => 'grey',
			'description' => __( 'Separator color.', 'js_composer' ),
			'param_holder_class' => 'vc_colored-dropdown'
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => __( 'Custom Color', 'js_composer' ),
			'param_name'  => 'accent_color',
			'description' => __( 'Custom separator color for your element.', 'js_composer' ),
			'dependency'  => array(
				'element' => 'color',
				'value'   => array( 'custom' )
			),
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Style', 'js_composer' ),
			'param_name' => 'style',
			'value' => getVcShared( 'separator styles' ),
			'description' => __( 'Separator style.', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'value' => getVcShared( 'separator border widths' ),
			'description' => __( 'Border width in pixels.', 'js_composer' ),
			'heading' => __('Border width', 'om_theme'),
			'param_name' => 'border_width',
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Element width', 'js_composer' ),
			'param_name' => 'el_width',
			'value' => getVcShared( 'separator widths' ),
			'description' => __( 'Separator element width in percents.', 'js_composer' )
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		),
  ));
  
	vc_map_update ('om_icon_separator', array(
		'params' => $tmp,
	));
	
	/**
	 * Message box
	 */

  $param = WPBMap::getParam('vc_message', 'color');
  $tmp=array();
	foreach($param['options'] as $v) {
		if(!in_array($v['value'], array('alert-info','alert-warning','alert-success','alert-danger'))) {
			$tmp[]=$v;
		}
	}
	$param['options']=$tmp;
  WPBMap::mutateParam('vc_message', $param);

  $param = WPBMap::getParam('vc_message', 'icon_type');
  $param['value']=array_merge( array_diff($param['value'], array('pixelicons')) );
  WPBMap::mutateParam('vc_message', $param);

  $param = WPBMap::getParam('vc_message', 'message_box_color');
  $param['value']=array_merge( array_diff($param['value'], array('alert-info','alert-warning','alert-success','alert-danger')) );
  WPBMap::mutateParam('vc_message', $param);

	
  $param = WPBMap::getParam('vc_message', 'style');
  $param['std']='square';
  $param['type']='hidden';
  WPBMap::mutateParam('vc_message', $param);

	/**
	 * Single image
	 */
	
  $param = WPBMap::getParam('vc_single_image', 'style');
  unset($param['value']['3D Shadow']);
  WPBMap::mutateParam('vc_single_image', $param);
  
  $param = WPBMap::getParam('vc_single_image', 'img_size');
  $param['value']='full';
  $param['description'] = __('Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.','om_theme');
  WPBMap::mutateParam('vc_single_image', $param);
  
  
  /**
   * Button
   */
  
  $params=new OMWPBScParams('vc_btn');
  
 	$params->remove('custom_background');
  $params->remove('custom_text');
  $params->remove('shape');
  
  $param=$params->get('style');
  $param['value']=array(
		__('Classic','om_theme') => 'flat',
		__('Outlined','om_theme') => 'outline',
		//__('3D','om_theme') => '3d',
  );
  $params->update($param);

	$param=$params->get('color');
	$param['value']=array_merge(om_wpb_get_std_colors(), array(__('Custom','om_theme') => 'custom'));
	$param['edit_field_class'] = 'vc_col-sm-6 vc_column vc_block_clear';
	$params->update($param);
  
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => __( 'Custom color', 'js_composer' ),
		'param_name' => 'custom_color',
		'description' => __( 'Select custom color for button.', 'om_theme' ),
		'dependency'  => array(
			'element' => 'color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'color');


	$params->add(array(
		'type' => 'dropdown',
		'heading' => __( 'Hover color', 'js_composer' ),
		'param_name' => 'hover_color',
		'description' => __( 'Select color for button by hover.', 'om_theme' ),
		'value' => array(
			__('Auto','om_theme') => 'auto',
			__('Custom','om_theme') => 'custom',
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
	), 'custom_color');
	
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => __( 'Custom hover color', 'js_composer' ),
		'param_name' => 'hover_custom_color',
		'dependency'  => array(
			'element' => 'hover_color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'hover_color');
	
	$params->add(array(
		'type' => 'dropdown',
		'heading' => __( 'Text color', 'js_composer' ),
		'param_name' => 'text_color',
		'value' => array(
			__('Default','om_theme') => 'auto',
			__('Custom','om_theme') => 'custom',
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
	), 'hover_custom_color');
	
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => __( 'Custom text color', 'js_composer' ),
		'param_name' => 'text_custom_color',
		'dependency'  => array(
			'element' => 'text_color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'text_color');
	
	$params->add(array(
		'type' => 'dropdown',
		'heading' => __( 'Hover text color', 'js_composer' ),
		'param_name' => 'hover_text_color',
		'value' => array(
			__('Default','om_theme') => 'auto',
			__('Custom','om_theme') => 'custom',
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
	), 'text_custom_color');
	
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => __( 'Custom hover text color', 'js_composer' ),
		'param_name' => 'hover_text_custom_color',
		'dependency'  => array(
			'element' => 'hover_text_color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'hover_text_color');

  $param=$params->get('size');
  $param['value']['XLarge']='xlg';
  $params->update($param);


	$params->add(array(
		'type' => 'dropdown',
		'heading' => __( 'Icon color', 'js_composer' ),
		'param_name' => 'icon_color',
		'value' => array(
			__('Default','om_theme') => 'auto',
			__('Custom','om_theme') => 'custom',
		),
		'dependency'  => array(
			'element' => 'add_icon',
			'value' => 'true',
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column vc_block_clear',
	), 'i_align');
	
	$params->add(array(
		'type' => 'colorpicker',
		'heading' => __( 'Custom icon color', 'js_composer' ),
		'param_name' => 'icon_custom_color',
		'dependency'  => array(
			'element' => 'icon_color',
			'value'   => array( 'custom' )
		),
		'edit_field_class' => 'vc_col-sm-6 vc_column',
	), 'icon_color');

  $param=$params->get('i_type');
  $param['value']=om_wpb_remove_pixel_icons($param['value']);
  $params->update($param);

	$params->add(array(
		'type' => 'om_get_code',
		'heading' => __( 'Get code', 'om_theme' ),
		'param_name' => 'code',
		'description' => __( 'If you wish to use button shortcode somewhere out of Visual Composer or insert it into text inline, you can generate the code which you can use separately.', 'js_composer' )
	));
	
	  
  $params->save();

	
	/**
	 * CTA Button
	 */

  $params=new OMWPBScParams('vc_cta');
  $params->remove('use_custom_fonts_h2');
  $params->removeIntegratedShortcode('vc_custom_heading', 'h2_');
  $params->remove('use_custom_fonts_h4');
  $params->removeIntegratedShortcode('vc_custom_heading', 'h4_');
  $params->remove('shape');
  $params->remove('color');
  
  $param=$params->get('style');
  $param['value']=array(
  	__('Classic','om_theme') => 'classic',
  	__('Outline','om_theme') => 'outline',
  );
  $params->update($param);
  
  $param=$params->get('custom_background');
  unset($param['dependency']);
  $params->update($param);
  $param=$params->get('custom_text');
	unset($param['dependency']);
  $params->update($param);
  
  $param=$params->get('add_button');
  foreach($param['value'] as $k=>$v) {
  	if($v == 'top') {
  		unset($param['value'][$k]);
  		break;
  	}
  }
  $param['std']='';
  $params->update($param);

	$params->remove('add_icon');
	$params->remove('i_on_border');
	$params->removeIntegratedShortcode('vc_icon', 'i_');

  
  $params->save();
  
  	
	/**
	 * Progress Bars
	 */
	
	vc_remove_param('vc_progress_bar', 'el_class');
	
	vc_add_param('vc_progress_bar', array(
		'type' => 'dropdown',
		'heading' => __( 'Titles color', 'js_composer' ),
		'param_name' => 'titles_color',
		'value' => array(
			__('Default','om_theme') => 'auto',
			__('Custom','om_theme') => 'custom',
		),
	));
	
	vc_add_param('vc_progress_bar', array(
		'type' => 'colorpicker',
		'heading' => __( 'Titles custom color', 'js_composer' ),
		'param_name' => 'titles_custom_color',
		'dependency'  => array(
			'element' => 'titles_color',
			'value'   => array( 'custom' )
		),
	));
	
	vc_add_param('vc_progress_bar', array(
		'type' => 'textfield',
		'heading' => __( 'Extra class name', 'js_composer' ),
		'param_name' => 'el_class',
		'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
	));
	
	/**
	 * Pie charts
	 */
	 
	vc_remove_param('vc_pie', 'el_class');
	vc_remove_param('vc_pie', 'label_value');
	vc_remove_param('vc_pie', 'units');
	vc_remove_param('vc_pie', 'color');
	 
	vc_add_param('vc_pie', array(
		'type' => 'dropdown',
		'heading' => __( 'Pie label inside circle', 'om_theme' ),
		'param_name' => 'label_type',
		'value' => array(
			__('Number','om_theme') => 'number',
			__('Display widget title','om_theme') => 'title',
			__('Icon','om_theme') => 'icon',
		),
	));
	
	vc_add_param('vc_pie', array(
		'type' => 'textfield',
		'heading' => __( 'Pie label value', 'js_composer' ),
		'param_name' => 'label_value',
		'description' => __( 'Input integer value for label. If empty "Pie value" will be used.', 'js_composer' ),
		'value' => '',
		'dependency'  => array(
			'element' => 'label_type',
			'value'   => array( 'number' )
		),
	));
	
	vc_add_param('vc_pie', array(
		'type' => 'textfield',
		'heading' => __( 'Units', 'js_composer' ),
		'param_name' => 'units',
		'description' => __( 'Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', 'js_composer' ),
		'dependency'  => array(
			'element' => 'label_type',
			'value'   => array( 'number' )
		),
	));
	
	$tmp=om_wpb_icon_params(false, array(
			'element' => 'label_type',
			'value'   => array( 'icon' )
	));
	foreach($tmp as $v) {
		vc_add_param('vc_pie',$v);
	}
	
	vc_add_param('vc_pie', array(
		'type' => 'dropdown',
		'heading' => __( 'Bar color', 'js_composer' ),
		'param_name' => 'color',
		'value' => array(
			__( 'Grey', 'js_composer' ) => 'wpb_button',
			__( 'Blue', 'js_composer' ) => 'btn-primary',
			__( 'Turquoise', 'js_composer' ) => 'btn-info',
			__( 'Green', 'js_composer' ) => 'btn-success',
			__( 'Orange', 'js_composer' ) => 'btn-warning',
			__( 'Red', 'js_composer' ) => 'btn-danger',
			__( 'Black', 'js_composer' ) => "btn-inverse",
			__('Custom','om_theme') => 'custom',
		),
		'description' => __( 'Select pie chart color.', 'js_composer' ),
		'admin_label' => true,
		'param_holder_class' => 'vc_colored-dropdown'
	));

	vc_add_param('vc_pie', array(
		'type' => 'colorpicker',
		'heading' => __( 'Custom color', 'js_composer' ),
		'param_name' => 'custom_color',
		'dependency'  => array(
			'element' => 'color',
			'value'   => array( 'custom' )
		),
	));

	vc_add_param('vc_pie', array(
		'type' => 'textfield',
		'heading' => __( 'Width', 'js_composer' ),
		'param_name' => 'width',
		'description'  => __('Leave this field blank for auto width or specify maximum width', 'om_theme'),
	));	
	
	vc_add_param('vc_pie', array(
		'type' => 'textfield',
		'heading' => __( 'Extra class name', 'js_composer' ),
		'param_name' => 'el_class',
		'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
	));
	
	/**
	 * GMaps
	 */
	
	vc_remove_param('vc_gmaps', 'link');
	vc_remove_param('vc_gmaps', 'size');
	vc_remove_param('vc_gmaps', 'el_class');
	
	vc_add_param('vc_gmaps', array(
		'type' => 'textarea_safe',
		'heading' => __( 'Map embed iframe', 'js_composer' ),
		'param_name' => 'link',
		'description' => sprintf( __( 'Visit %s or %s to create your map. 1) Find location 2) Click "Share" and make sure map is public on the web 3) Copy iframe code and paste it here.', 'js_composer' ), '<a href="https://maps.google.com/" target="_blank">Google maps</a>', '<a href="https://mapsengine.google.com/" target="_blank">Google Maps Engine</a>' )
	));
	vc_add_param('vc_gmaps', array(
		'type' => 'textfield',
		'heading' => __( 'Map height', 'js_composer' ),
		'param_name' => 'size',
		'admin_label' => true,
		'description' => __( 'Enter map height in pixels. Example: 200 or leave it empty to make map responsive.', 'js_composer' )
	));
	vc_add_param('vc_gmaps', array(
		'type' => 'textfield',
		'heading' => __( 'Extra class name', 'js_composer' ),
		'param_name' => 'el_class',
		'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
	));
	
	/**
	 * Tabs
	 */
	 
  vc_remove_param("vc_tta_tabs", "style");
  vc_remove_param("vc_tta_tabs", "shape");
  vc_remove_param("vc_tta_tabs", "color");
  vc_remove_param("vc_tta_tabs", "no_fill_content_area");
  vc_remove_param("vc_tta_tabs", "spacing");
  vc_remove_param("vc_tta_tabs", "gap");
  vc_remove_param("vc_tta_tabs", "tab_position");
  vc_remove_param("vc_tta_tabs", "alignment");
  vc_remove_param("vc_tta_tabs", "pagination_style");
  vc_remove_param("vc_tta_tabs", "pagination_color");
  
	/**
	 * Tour
	 */
	 
  vc_remove_param("vc_tta_tour", "style");
  vc_remove_param("vc_tta_tour", "shape");
  vc_remove_param("vc_tta_tour", "color");
  vc_remove_param("vc_tta_tour", "no_fill_content_area");
  vc_remove_param("vc_tta_tour", "spacing");
  vc_remove_param("vc_tta_tour", "gap");
  vc_remove_param("vc_tta_tour", "tab_position");
  vc_remove_param("vc_tta_tour", "alignment");
  vc_remove_param("vc_tta_tour", "pagination_style");
  vc_remove_param("vc_tta_tour", "pagination_color");

	/**
	 * Accordion
	 */

  vc_remove_param("vc_tta_accordion", "style");
  vc_remove_param("vc_tta_accordion", "shape");
  vc_remove_param("vc_tta_accordion", "color");
  vc_remove_param("vc_tta_accordion", "no_fill");
  vc_remove_param("vc_tta_accordion", "spacing");
  vc_remove_param("vc_tta_accordion", "gap");
  vc_remove_param("vc_tta_accordion", "c_icon");
  vc_remove_param("vc_tta_accordion", "c_position");
  vc_remove_param("vc_tta_accordion", "c_align");
  vc_remove_param("vc_tta_accordion", "pagination_style");
  vc_remove_param("vc_tta_accordion", "pagination_color");
    
	
	/**
	 * Adding "Theme Color" option to some shortcodes.
	 */
	
	$theme_color=array(__('Theme Hightlight Color', 'om_theme') => 'om-theme-color');
	
  $param = WPBMap::getParam('vc_separator', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_separator', $param);
  
  $param = WPBMap::getParam('vc_text_separator', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_text_separator', $param);
  
  $param = WPBMap::getParam('om_icon_separator', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('om_icon_separator', $param);

  $param = WPBMap::getParam('vc_single_image', 'border_color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_single_image', $param);
  
  $param = WPBMap::getParam('vc_btn', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_btn', $param); 
  
  $param = WPBMap::getParam('vc_progress_bar', 'bgcolor');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_progress_bar', $param);
  
  $param = WPBMap::getParam('vc_pie', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_pie', $param); 
  
  $param = WPBMap::getParam('vc_message', 'message_box_color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_message', $param); 
  
  $param = WPBMap::getParam('vc_icon', 'color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_icon', $param); 
  
  $param = WPBMap::getParam('vc_icon', 'background_color');
  $param['value']=array_merge($theme_color,$param['value']);
  WPBMap::mutateParam('vc_icon', $param); 
   
  
	/**
	 * Update some integrated shortcodes
	 */
	 
  $params=new OMWPBScParams('vc_cta');
  $params->updateIntegratedShortcode('vc_btn', 'btn_', __( 'Button', 'js_composer' ),
		false,
		array(
			'element' => 'add_button',
			'not_empty' => true,
		)
	);
	$params->remove('btn_code');
  $params->save();
}
