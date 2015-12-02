<?php

function om_add_common_meta_boxes(&$arr, $boxes, $prefix) {

	$meta_boxes = array (
	
		'pagetitle' => array (
			'id' => 'pagetitle',
			'name' => __('Page Title', 'om_theme'),
			'fields' => array (
				array ( "name" => __('Page Title Layout','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."page_title",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('Default (as in Theme Options)', 'om_theme'),
							'standard' => __('Standard', 'om_theme'),
							'hide' => __('Hide', 'om_theme'),
							'color' => __('Custom background color', 'om_theme'),
							'image' => __('Custom background image', 'om_theme'),
							'parallax' => __('Predefined parallax effect', 'om_theme'),
						),
						'code' => '<script>
							jQuery(function($){
								$("#'.OM_THEME_SHORT_PREFIX.'page_title").change(function(){
									$("#'.OM_THEME_SHORT_PREFIX.'title_align").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'title_margins").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'title_size").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'title_bg_color").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'title_text_color").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'title_bg_img").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'title_bg_img_pos").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'title_bg_img_att").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'title_parallax").parents("tr").hide();
									
									if($(this).val() == "standard") {
										$("#'.OM_THEME_SHORT_PREFIX.'title_align").parents("tr").show();
									} else if($(this).val() == "color") {
										$("#'.OM_THEME_SHORT_PREFIX.'title_align").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_margins").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_size").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_bg_color").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_text_color").parents("tr").show();
									} else if($(this).val() == "image") {
										$("#'.OM_THEME_SHORT_PREFIX.'title_align").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_bg_color").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_bg_img").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_bg_img_pos").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_bg_img_att").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_margins").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_size").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_text_color").parents("tr").show();
									} else if($(this).val() == "parallax") {
										$("#'.OM_THEME_SHORT_PREFIX.'title_align").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_bg_color").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_margins").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_size").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_text_color").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'title_parallax").parents("tr").show();
									}
								}).change();
							});
						</script>',
				),
				
				array ( "name" => __('Title align','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."title_align",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('Left', 'om_theme'),
							'center' => __('Center', 'om_theme'),
							'center_bottom' => __('Center, bottom', 'om_theme'),
						),
				),
				
				array ( "name" => __('Title margins','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."title_margins",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('Small', 'om_theme'),
							'medium' => __('Medium', 'om_theme'),
							'large' => __('Large', 'om_theme'),
							'xlarge' => __('X-Large', 'om_theme'),
							'xxlarge' => __('XX-Large', 'om_theme'),
						),
				),

				array ( "name" => __('Title size','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."title_size",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('Standard', 'om_theme'),
							'large' => __('Large', 'om_theme'),
							'xlarge' => __('X-Large', 'om_theme'),
							'xxlarge' => __('XX-Large', 'om_theme'),
						),
				),				
				
				array ( "name" => __('Title background color','om_theme'),
						"desc" => __('To automatically apply theme Hightlight color from Theme Options type "theme" or click "default"'),
						"id" => OM_THEME_SHORT_PREFIX."title_bg_color",
						"type" => "color",
						"std" => 'theme',
				),
				
				array ( "name" => __('Title text color','om_theme'),
						"desc" => __('To automatically apply theme Hightlight color from Theme Options type "theme"'),
						"id" => OM_THEME_SHORT_PREFIX."title_text_color",
						"type" => "color",
						"std" => '#FFFFFF',
				),
				
				array ( "name" => __('Title background image','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."title_bg_img",
						"type" => "text_browse",
						"std" => '',
						"library" => 'image',
				),
				
				array ( "name" => __('Title background image position','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."title_bg_img_pos",
						"type" => "select",
						"std" => '',
	          'options'=>om_get_bg_img_pos_options(),
				),
				
				array ( "name" => __('Title background image attachment','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."title_bg_img_att",
						"type" => "select",
						"std" => 'scroll',
	          'options'=>array(
	          	'scroll' => __('Scroll','om_theme'),
	          	'fixed' => __('Fixed','om_theme'),
	          ),
				),
				
				array ( "name" => __('Parallax effect','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."title_parallax",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('Lines', 'om_theme'),
							'geometry' => __('Geometry', 'om_theme'),
							'circles' => __('Circles', 'om_theme'),
						),
				),
	
			),
		),
		
		'slider' => array (
			'id' => 'slider',
			'name' => __('Slider', 'om_theme'),
			'fields' => array (
	
				array (
					'name' => __('Choose the slider','om_theme'),
					'desc' => '',
					'id' => OM_THEME_SHORT_PREFIX.'slider_id',
					'type' => 'slider',
					'std' => ''
				),
	
				array ( "name" => __('Slider layout','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."slider_layout",
						"type" => "select",
						"std" => 'full',
						'options' => array(
							'full' => __('Full width slider', 'om_theme'),
							'boxed' => __('Boxed width slider', 'om_theme'),
							'before_header' => __('Before Header', 'om_theme'),
						)
				),
				
			),
			
		),
		
		'header' => array (
			'id' => 'header',
			'name' => __('Header', 'om_theme'),
			'fields' => array (
	
				array ( "name" => __('Header background','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX.'header_bg',
						"type" => "select",
						"std" => 'default',
						'options' => array(
							'default' => __('Default', 'om_theme'),
							'color' => __('Custom color', 'om_theme'),
							'image' => __('Custom image', 'om_theme'),
							'transparent' => __('Transparent (slider or page title background will be used)', 'om_theme'),
						),
						'code' => '<script>
							jQuery(function($){
								$("#'.OM_THEME_SHORT_PREFIX.'header_bg").change(function(){
									var val=$(this).val();

									$("#'.OM_THEME_SHORT_PREFIX.'header_bg_image").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'header_bg_image_pos").parents("tr").hide();
									$("#'.OM_THEME_SHORT_PREFIX.'header_bg_color").parents("tr").hide();
									
									if(val == "image") {
										$("#'.OM_THEME_SHORT_PREFIX.'header_bg_image").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'header_bg_image_pos").parents("tr").show();
									} else if(val == "color") {
										$("#'.OM_THEME_SHORT_PREFIX.'header_bg_color").parents("tr").show();
									}
									
									if(val == "image" || val == "transparent" || val == "color") {
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_menu_color").change().parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image").change().parents("tr").show();
									} else {
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_menu_color").parents("tr").hide();
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_menu_color_color").parents("tr").hide();
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image").parents("tr").hide();
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image_src").parents("tr").hide();
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image_src_2x").parents("tr").hide();
									}
								}).change();
							});
						</script>',
				),
				
				array ( "name" => __('Background color','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."header_bg_color",
						"type" => "color",
						"std" => '',
				),
				
				array ( "name" => __('Background image','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."header_bg_image",
						"type" => "text_browse",
						"std" => '',
						"library" => 'image',
				),
				
				array ( "name" => __('Background image position','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."header_bg_image_pos",
						"type" => "select",
						"std" => 'repeat',
						'options' => array(
							'repeat' => __('Repeat', 'om_theme'),
							'cover' => __('Cover', 'om_theme'),
						),
				),
				
				array ( "name" => __('Set custom menu color','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."header_custom_menu_color",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('No', 'om_theme'),
							'1' => __('Yes', 'om_theme'),
						),
						'code' => '<script>
							jQuery(function($){
								$("#'.OM_THEME_SHORT_PREFIX.'header_custom_menu_color").change(function(){
									if($(this).val() == "1") {
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_menu_color_color").parents("tr").show();
									} else {
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_menu_color_color").parents("tr").hide();
									}
								}).change();
							});
						</script>',
				),

				array ( "name" => __('Custom menu color','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."header_custom_menu_color_color",
						"type" => "color",
						"std" => '',
				),
				
				array ( "name" => __('Set custom logo image','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."header_custom_logo_image",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('No', 'om_theme'),
							'1' => __('Yes', 'om_theme'),
						),
						'code' => '<script>
							jQuery(function($){
								$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image").change(function(){
									if($(this).val() == "1") {
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image_src").parents("tr").show();
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image_src_2x").parents("tr").show();
									} else {
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image_src").parents("tr").hide();
										$("#'.OM_THEME_SHORT_PREFIX.'header_custom_logo_image_src_2x").parents("tr").hide();
									}
								}).change();
							});
						</script>',
				),

				array ( "name" => __('Custom logo image','om_theme'),
						"desc" => '',
						"id" => OM_THEME_SHORT_PREFIX."header_custom_logo_image_src",
						"type" => "text_browse",
						"library" => 'image',
						"std" => '',
				),

				array ( "name" => __('Custom logo image for retina displays','om_theme'),
						"desc" => __('Double sized image for retina displays for better quality','om_theme'),
						"id" => OM_THEME_SHORT_PREFIX."header_custom_logo_image_src_2x",
						"type" => "text_browse",
						"library" => 'image',
						"std" => '',
				),
								
			),
			
		),
		
		'sidebar' => array (
			'id' => 'sidebar',
			'name' => __('Sidebar', 'om_theme'),
			'fields' => array (
				array ( "name" => __('Sidebar','om_theme'),
						"desc" => __('You can create any number of sidebars under "Appearance > Sidebars".','om_theme'),
						"id" => OM_THEME_SHORT_PREFIX."sidebar_show",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('Display Sidebar', 'om_theme'),
							'hide' => __('Hide Sidebar', 'om_theme'),
						)
				),
	
				array (
					'name' => __('Choose the sidebar','om_theme'),
					'desc' => '',
					'id' => OM_THEME_SHORT_PREFIX.'sidebar',
					'type' => 'sidebar',
					'std' => ''
				),
	
				array ( "name" => __('Sidebar Position','om_theme'),
						"desc" => __('Sidebar position for current page.','om_theme'),
						"id" => OM_THEME_SHORT_PREFIX."sidebar_custom_pos",
						"type" => "select",
						"std" => '',
						'options' => array(
							'' => __('Default (As in "Theme Options")', 'om_theme'),
							'left' => __('Left Side', 'om_theme'),
							'right' => __('Right Side', 'om_theme'),
						)
				),
			),
		),
		
	);
		
	foreach($boxes as $id) {
		
		if( isset($meta_boxes[$id]) ) {
			
			if($id == 'slider') {
				if( ommb_check_slider_exists() ) { 
					$arr[$id]=$meta_boxes[$id];
					$arr[$id]['id']=$prefix.$arr[$id]['id'];
				}
			} else {
				$arr[$id]=$meta_boxes[$id];
				$arr[$id]['id']=$prefix.$arr[$id]['id'];
			}
			
		}
		
		
	}
	
}