<?php

if (!function_exists('om_get_options_template')) {
	
	function om_get_options_template($id_as_key=false) {

		// Set the Options Array
		$options = array();
		
		$options[] = array( "name" => __('General settings','om_theme'),
		                    "type" => "heading");
		/*
		$options[] = array( "name" => "",
							"message" => __('You can import demo content in a one click:','om_theme').' <a href="'.admin_url('tools.php?page=om_import_tool').'" class="button button-primary" style="text-shadow:none">'.__('Demo Content Import Tool &rarr;','om_theme').'</a>',
							"type" => "intro");
		*/

		$options[] = array( "name" => __('Site favicon','om_theme'),
					"desc" => __('Upload an *.ico file or 16px x 16px Png/Gif image that will for your website\'s favicon.','om_theme'),
					"id" => OM_THEME_PREFIX."favicon",
					"std" => "",
					"type" => "upload");

		$options[] = array( "name" => __('Header tagline','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."header_tagline",
					"std" => "",
					"type" => "textarea",
					"rows" => 5);

		$options[] = array( "name" => __('Sub-footer text line','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."subfooter_text",
					"std" => "",
					"type" => "textarea",
					"rows" => 5);

		/*										
		$options[] = array( 'name' => __('Exclude featured image from post/portfolio item page galleries', 'om_theme'),
		                    'desc' => __('Check if you want to exclude image, which was chosen as featured image for post/portfolio item, from the post/portfolio item gallery on the single page', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'exclude_featured_image',
		                    'std' => '',
		                    'type' => 'checkbox');
		*/
		                    
		                    
		$options[] = array( 'name' => __('Use lazy load for images', 'om_theme'),
		                    'desc' => __('Check if you want to load images on scroll to the view area', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'lazyload',
		                    'std' => 'true',
		                    'type' => 'checkbox');

		/*
		$options[] = array( 'name' => __('Replace default WordPress Gallery with the Theme&#39;s custom gallery', 'om_theme'),
		                    'desc' => __('Check if you want the theme to replace standard WordPress gallery', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'do_replace_gallery',
		                    'std' => '',
		                    'type' => 'checkbox');
		*/
		                    
		$options[] = array( 'name' => __('Display search box in the header', 'om_theme'),
		                    'desc' => __('Check if you want to display search button in the header', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'show_header_search',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Disable animation on touch devices', 'om_theme'),
		                    'desc' => __('Check if you want to disable some animation effects to improve perfomance on mobile devices', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'no_animation_on_touch',
		                    'std' => 'true',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Enable animation on page transitions', 'om_theme'),
		                    'desc' => __('Check if you want to enable animation on click, when user is moving to another page.<br/>NOTE: doesn\'t work in Safari browser.', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'enable_page_out_animation',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Disable smooth scroll', 'om_theme'),
		                    'desc' => __('Theme includes SmoothScroll library, you can check this option of you want to disable it', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'disable_smoothscroll',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		/////////////////////////////////////////////////////////////
		                    
		$options[] = array( "name" => __('Logo','om_theme'),
		                    "type" => "heading");

		$options[] = array( 'name' => __('Site logo type', 'om_theme'),
		                    'desc' => __('Choose what do you want to use as site logo: image or plain text.', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'site_logo_type',
		                    'std' => 'text',
		                    'options'=>array(
		                    	'text'=>__('Plain text', 'om_theme'),
		                    	'image'=>__('Image', 'om_theme'),
		                    	'none'=>__('No logo', 'om_theme'),
		                    ),
		                    'type' => 'radio');
		                    
		$options[] = array( "name" => __('Site logo text','om_theme'),
							"desc" => __('Specify logo text, if "Plain text" Logo used.','om_theme'),
							"id" => OM_THEME_PREFIX."site_logo_text",
							"std" => "Amax",
							"type" => "text");

		$options[] = array( "name" => __('Site logo image','om_theme'),
							"desc" => __('Choose a logo for your theme, or specify the image address of your online logo (http://example.com/logo.png).','om_theme'),
							"id" => OM_THEME_PREFIX."site_logo_image",
							"std" => "",
							"type" => "upload");

		$options[] = array( "name" => __('Site logo image for retina displays (optional)','om_theme'),
							"desc" => __('Choose double sized image for retina displays for better quality','om_theme'),
							"id" => OM_THEME_PREFIX."site_logo_image_2x",
							"std" => "",
							"type" => "upload");

		/////////////////////////////////////////////////////////////
		
		$options[] = array( "name" => __('Layout','om_theme'),
		                    "type" => "heading");

		                    
		$options[] = array( 'name' => __('Activate responsive mode for mobile devices', 'om_theme'),
		                    'desc' => __('Check if you want your site to be fitted by width on mobile devices', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'responsive',
		                    'std' => 'true',
		                    'type' => 'checkbox');

		$options[] = array( 'name' => __('Overall layout', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'overall_layout',
		                    'std' => 'wide',
		                    'options'=>array(
		                    	'wide' => __('Wide','om_theme'),
		                    	'boxed' => __('Boxed','om_theme'),
		                    ),
		                    'type' => 'select2');

		$options[] = array( "name" => __('Header layout','om_theme'),
							"desc" => __('Select header layout.','om_theme'),
							"id" => OM_THEME_PREFIX."header_layout",
							"std" => "1",
							"type" => "images",
							"options" => array(
								'1' => TEMPLATE_DIR_URI . '/admin/images/header-1.png',
								'3' => TEMPLATE_DIR_URI . '/admin/images/header-3.png',
								'2' => TEMPLATE_DIR_URI . '/admin/images/header-2.png',
							)
						);
						
		$options[] = array( 'name' => __('Footer layout', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'footer_layout',
		                    'std' => '1v4-1v4-1v4-1v4',
		                    'options'=>array(
		                    	'1v4-1v4-1v4-1v4' => __('4 Columns 1/4 + 1/4 + 1/4 + 1/4', 'om_theme'),
		                    	'2v4-1v4-1v4' => __('3 Columns 2/4 + 1/4 + 1/4', 'om_theme'),
		                    	'1v4-1v4-2v4' => __('3 Columns 1/4 + 1/4 + 2/4', 'om_theme'),
		                    	'1v3-1v3-1v3' => __('3 Columns 1/3 + 1/3 + 1/3', 'om_theme'),
		                    	'2v3-1v3' => __('2 Columns 2/3 + 1/3', 'om_theme'),
		                    	'1v3-2v3' => __('2 Columns 1/3 + 2/3', 'om_theme'),
		                    	'1v2-1v2' => __('2 Columns 1/2 + 1/2', 'om_theme'),
		                    	'1v1' => __('1 Column', 'om_theme'),
		                    ),
		                    'type' => 'select2');
		                    		                    
		$options[] = array( 'name' => __('Uncovering footer', 'om_theme'),
		                    'desc' => __('Check to enable "uncovering footer" effect', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'uncovering_footer',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		/////////////////////////////////////////////////////////////
		
		$options[] = array( "name" => __('Menu','om_theme'),
		                    "type" => "heading");		                    

		$options[] = array( 'name' => __('Menu position', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'menu_position',
		                    'std' => 'top',
		                    'options'=>array(
		                    	'top' => __('At the top, not fixed', 'om_theme'),
		                    	'top_fixed' => __('Fixed on top', 'om_theme'),
		                    ),
		                    'type' => 'select2');

		$options[] = array( 'name' => __('Display drop down symbol for menu items with sublevels', 'om_theme'),
		                    'desc' => __('Check if you want to display drop down symbol in primary menu for items which has sublevels', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'show_dropdown_symbol',
		                    'std' => 'true',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Apply bold font style to root menu elements of primary menu', 'om_theme'),
		                    'desc' => __('Check if you want to apply bold font style to root menu elements of primary menu', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'menu_bold',
		                    'std' => '',
		                    'type' => 'checkbox');

		$options[] = array( 'name' => __('Highlight active menu item', 'om_theme'),
		                    'desc' => __('Check if you want to highlight active menu item of primary menu', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'menu_highlight_active',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Uppercase', 'om_theme'),
		                    'desc' => __('Check to apply uppercase for menu items', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'menu_uppercase',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Enable MegaMenu addon', 'om_theme'),
		                    'desc' => __('Check if you want to enable MegaMenu feature or uncheck if you don\'t need it or you want to use some other plugin for this purpose', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'menu_megamenu_active',
		                    'std' => 'true',
		                    'type' => 'checkbox');
		                    
		////////////////////////////////////////////////////////////


		$options[] = array( "name" => __('Styling','om_theme'),
		                    "type" => "heading");
		                    
		$options[] = array( 'name' => '',
		                    'desc' => __('Apply custom styling by inline code (check this option if you have problems with styling because of styling file rewrite permissions)', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'use_inline_css',
		                    'std' => '',
		                    'type' => 'checkbox');

		$options[] = array( "name" => "",
							"message" => __('Style Presets:','om_theme'),
							"type" => "subheader");

		                    
		$options[] = array( 'name' => '',
		                    'desc' => __('Choose one of the preseted styles or create your own one', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'styling_presets',
		                    'std' => unserialize('a:10:{s:5:"Basic";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#f75148";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:10:"Light Blue";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#0277bd";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:5:"Brown";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#5d4037";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:6:"Indigo";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#283593";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:5:"Green";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#2e7d32";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:11:"Light Green";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#558b2f";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:6:"Orange";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#ef6c00";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:4:"Grey";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#424242";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:4:"Lime";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#827717";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}s:11:"Deep Purple";a:25:{s:24:"om_amax_background_color";s:7:"#4c4c4c";s:22:"om_amax_background_img";s:4:"none";s:29:"om_amax_background_img_custom";s:0:"";s:22:"om_amax_background_pos";s:6:"repeat";s:25:"om_amax_background_attach";s:5:"fixed";s:31:"om_amax_background_dots_overlay";N;s:26:"om_amax_background_dimming";s:1:"0";s:32:"om_amax_background_dimming_color";s:5:"black";s:24:"om_amax_hightlight_color";s:7:"#4527a0";s:35:"om_amax_pre_header_background_color";s:7:"#ffffff";s:21:"om_amax_tagline_color";s:7:"#a3a3a3";s:33:"om_amax_social_icons_color_header";s:4:"dark";s:31:"om_amax_header_background_color";s:7:"#ffffff";s:24:"om_amax_menu_items_color";s:7:"#4d4d4d";s:30:"om_amax_menu_items_color_hover";s:7:"#000000";s:28:"om_amax_menu_sub_items_color";s:7:"#4d4d4d";s:34:"om_amax_menu_sub_items_color_hover";s:7:"#000000";s:37:"om_amax_background_main_content_color";s:7:"#ffffff";s:23:"om_amax_main_text_color";s:7:"#353535";s:23:"om_amax_side_text_color";s:7:"#b2b2b2";s:31:"om_amax_background_footer_color";s:7:"#000000";s:27:"om_amax_footer_titles_color";s:7:"#e5e5e5";s:30:"om_amax_footer_main_text_color";s:7:"#a0a0a0";s:30:"om_amax_footer_side_text_color";s:7:"#7c7c7c";s:33:"om_amax_social_icons_color_footer";s:5:"light";}}'),
		                    'options' => array(
			                    OM_THEME_PREFIX . 'background_color',
			                    OM_THEME_PREFIX . 'background_img',
			                    OM_THEME_PREFIX . 'background_img_custom',
			                    OM_THEME_PREFIX . 'background_pos',
			                    OM_THEME_PREFIX . 'background_attach',
			                    OM_THEME_PREFIX . 'background_dots_overlay',
			                    OM_THEME_PREFIX . 'background_dimming',
			                    OM_THEME_PREFIX . 'background_dimming_color',
			                    OM_THEME_PREFIX . 'hightlight_color',
			                    OM_THEME_PREFIX . 'pre_header_background_color',
			                    OM_THEME_PREFIX . 'tagline_color',
			                    OM_THEME_PREFIX . 'social_icons_color_header',
			                    OM_THEME_PREFIX . 'header_background_color',
			                    OM_THEME_PREFIX . 'menu_items_color',
			                    OM_THEME_PREFIX . 'menu_items_color_hover',
			                    OM_THEME_PREFIX . 'menu_sub_items_color',
			                    OM_THEME_PREFIX . 'menu_sub_items_color_hover',
			                    OM_THEME_PREFIX . 'background_main_content_color',
			                    OM_THEME_PREFIX . 'main_text_color',
			                    OM_THEME_PREFIX . 'side_text_color',
			                    OM_THEME_PREFIX . 'background_footer_color',
			                    OM_THEME_PREFIX . 'footer_titles_color',
			                    OM_THEME_PREFIX . 'footer_main_text_color',
			                    OM_THEME_PREFIX . 'footer_side_text_color',
			                    OM_THEME_PREFIX . 'social_icons_color_footer',
		                    ),
		                    'type' => 'styling_presets');		
		                    
		$options[] = array( "name" => "",
							"message" => __('Overall Background (in case "Boxed" layout is enabled):','om_theme'),
							"type" => "subheader");
							
		$options[] = array( "name" => __('Background color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."background_color",
		                    "std" => "#4c4c4c",
		                    "type" => "color");
		                    
		$options[] = array( 'name' => __('Background pattern', 'om_theme'),
		                    'desc' => __('Choose one of the built-in background', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'background_img',
		                    'std' => 'none',
		                    'options'=>array(
		                    	'none' => 'none',
		                    	'bg-1.png' => 'Pattern #1',
		                    	'bg-2.jpg' => 'Pattern #2',
		                    	'bg-3.png' => 'Pattern #3',
		                    	'bg-4.png' => 'Pattern #4',
		                    	'bg-5.png' => 'Pattern #5',
		                    	'bg-6.png' => 'Pattern #6',
		                    	'bg-7.png' => 'Pattern #7',
		                    	'bg-8.png' => 'Pattern #8',
		                    	'bg-9.png' => 'Pattern #9',
		                    	'bg-10.png' => 'Pattern #10',
		                    	'bg-11.png' => 'Pattern #11',
		                    	'bg-12.png' => 'Pattern #12',
		                    	'bg-13.png' => 'Pattern #13',
		                    	'bg-14.png' => 'Pattern #14',
		                    	'bg-15.png' => 'Pattern #15',
		                    	'bg-16.png' => 'Pattern #16',
		                    	'bg-17.png' => 'Pattern #17',
		                    	'bg-18.png' => 'Pattern #18',
		                    	'bg-19.png' => 'Pattern #19',
		                    	'bg-20.png' => 'Pattern #20',
		                    	'bg-21.png' => 'Pattern #21',
		                    	'bg-22.png' => 'Pattern #22',
		                    	'bg-23.png' => 'Pattern #23',
		                    	'bg-24.png' => 'Pattern #24',
		                    	'bg-25.png' => 'Pattern #25',
		                    	'bg-26.png' => 'Pattern #26',
		                    	'bg-27.png' => 'Pattern #27',
		                    	'bg-28.png' => 'Pattern #28',
		                    	'bg-29.png' => 'Pattern #29',
		                    	'bg-30.png' => 'Pattern #30',
		                    ),
		                    'type' => 'select2');
		$mess='<a href="#" onclick="jQuery(\'#om_patterns_preview\').slideToggle();return false"><b>'.__('Background pattern preview','om_theme').' (+)</b></a><div id="om_patterns_preview" style="display:none">';
		for($i=1;$i<=30;$i++) {
			$mess.='<div style="width:70px;height:70px;background:url('.TEMPLATE_DIR_URI.'/img/bg/bg-'.$i.'.png);display:inline-block;margin:0 10px 10px 0;padding:5px;">Pattern #'.$i.'</div>';
		}
		$mess.='</div>';
		$options[] = array( "name" => "",
							"message" => $mess,
							"type" => "intro");
		                    
		$options[] = array( 'name' => __('Custom Background image', 'om_theme'),
		                    'desc' => __('Upload your background, or leave this field empty to choose one of the above dropdown', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'background_img_custom',
		                    'std' => '',
		                    'type' => 'upload');
		                    
		$options[] = array( 'name' => __('Custom Background position', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'background_pos',
		                    'std' => 'repeat',
		                    'options'=>om_get_bg_img_pos_options(),
		                    'type' => 'select2');
		                    
		$options[] = array( 'name' => __('Background attachment', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'background_attach',
		                    'std' => 'fixed',
		                    'options'=>array(
		                    	'fixed' => 'Fixed',
		                    	'scroll' => 'Scroll',
		                    ),
		                    'type' => 'select2');
		                    
		$options[] = array( 'name' => __('Enable additional dots overlay layer', 'om_theme'),
		                    'desc' => __('Useful for full screen background images', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'background_dots_overlay',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Background image dimmer (percent)', 'om_theme'),
		                    'desc' => __('Value between 0 and 100 to dim background image. 0 - no dim, 100 - maximum dim', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'background_dimming',
		                    'std' => '0',
		                    'type' => 'text');

		$options[] = array( 'name' => __('Background image dimmer color', 'om_theme'),
		                    'desc' => __('Choose the dimming color', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'background_dimming_color',
		                    'std' => 'black',
		                    'options' => array(
		                    	'black'=>'Black',
		                    	'white'=>'White',
		                    ),
		                    'type' => 'select2');

		$options[] = array( "name" => "",
							"message" => __('Common:','om_theme'),
							"type" => "subheader");
							
		$options[] = array( "name" => __('Hightlight color', 'om_theme'),
		                    "desc" => 'For highlighted blocks, text, links, controls',
		                    "id" => OM_THEME_PREFIX."hightlight_color",
		                    "std" => "#f75148",
		                    "type" => "color");
							
		$options[] = array( "name" => "",
							"message" => __('Header:','om_theme'),
							"type" => "subheader");
							
		$options[] = array( "name" => __('Pre-Header background color', 'om_theme'),
		                    "desc" => __('Tiny block which holds tagline and socials icons if enabled', 'om_theme'),
		                    "id" => OM_THEME_PREFIX."pre_header_background_color",
		                    "std" => "#ffffff",
		                    "type" => "color");

		$options[] = array( "name" => __('Tagline color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."tagline_color",
		                    "std" => "#a3a3a3",
		                    "type" => "color");
		                    
		$options[] = array( 'name' => __('Social Icons color in the header', 'om_theme'),
		                    'desc' => __('With light overall background use dark icons and vice versa.','om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'social_icons_color_header',
		                    'std' => 'dark',
		                    'options' => array(
		                    	'dark'=>__('Dark','om_theme'),
		                    	'light'=>__('Light','om_theme'),
		                    ),
		                    'type' => 'select2');

		$options[] = array( "name" => __('Header background color', 'om_theme'),
		                    "desc" => __('Block which holds logo and menu', 'om_theme'),
		                    "id" => OM_THEME_PREFIX."header_background_color",
		                    "std" => "#ffffff",
		                    "type" => "color");

		                    
		$options[] = array( "name" => "",
							"message" => __('Header menu:','om_theme'),
							"type" => "subheader");

		$options[] = array( "name" => __('Menu items color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."menu_items_color",
		                    "std" => "#4d4d4d",
		                    "type" => "color");

		$options[] = array( "name" => __('Menu items color by hover', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."menu_items_color_hover",
		                    "std" => "#000000",
		                    "type" => "color");
		                    
		$options[] = array( "name" => __('Sub-Menu items color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."menu_sub_items_color",
		                    "std" => "#4d4d4d",
		                    "type" => "color");

		$options[] = array( "name" => __('Sub-Menu items color by hover', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."menu_sub_items_color_hover",
		                    "std" => "#000000",
		                    "type" => "color");
	                    
		                    
		$options[] = array( "name" => "",
							"message" => __('Main Content:','om_theme'),
							"type" => "subheader");

		$options[] = array( "name" => __('Main content background color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."background_main_content_color",
		                    "std" => "#ffffff",
		                    "type" => "color");

		$options[] = array( "name" => __('Main text color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."main_text_color",
		                    "std" => "#666666",
		                    "type" => "color");
		                    
		$options[] = array( "name" => __('Side text color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."side_text_color",
		                    "std" => "#9c9c9c",
		                    "type" => "color");

/*		                    
		$options[] = array( "name" => __('Side text color (less inportant information)', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."side_text_color2",
		                    "std" => "#dedede",
		                    "type" => "color");
*/

/*
		$options[] = array( 'name' => __('Main content panes background transparency', 'om_theme'),
		                    'desc' => __('Value between 0 and 100. 0 - opaque, 100 - transparent', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'background_main_content_opacity',
		                    'std' => '0',
		                    'type' => 'text');
*/

/*		                    
		$options[] = array( "name" => '',
		                    "desc" => __('Check this option if you chose dark background for content panes (needed for adjusting few blocks)', 'om_theme'),
		                    "id" => OM_THEME_PREFIX."content_panes_dark_bg",
		                    "std" => "",
		                    "type" => "checkbox");
*/
/*
		$options[] = array( "name" => __('Sidebar panes background color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."background_sidebar_color",
		                    "std" => "#ffffff",
		                    "type" => "color");

*/

		$options[] = array( "name" => "",
							"message" => __('Footer:','om_theme'),
							"type" => "subheader");

		$options[] = array( "name" => __('Footer background color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."background_footer_color",
		                    "std" => "#4c4c4c",
		                    "type" => "color");
		                    
		$options[] = array( "name" => __('Footer titles color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."footer_titles_color",
		                    "std" => "#e5e5e5",
		                    "type" => "color");

		$options[] = array( "name" => __('Footer text color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."footer_main_text_color",
		                    "std" => "#a0a0a0",
		                    "type" => "color");

		                    
		$options[] = array( "name" => __('Footer side text color', 'om_theme'),
		                    "desc" => '',
		                    "id" => OM_THEME_PREFIX."footer_side_text_color",
		                    "std" => "#7c7c7c",
		                    "type" => "color");

/*		                    
		$options[] = array( "name" => __('Footer hightlight color', 'om_theme'),
		                    "desc" => 'For highlighted text, links, controls',
		                    "id" => OM_THEME_PREFIX."footer_hightlight_color",
		                    "std" => "#2bb08f",
		                    "type" => "color");
*/
		                    
		$options[] = array( 'name' => __('Social Icons color in the footer', 'om_theme'),
		                    'desc' => __('With light footer background use dark icons and vice versa.','om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'social_icons_color_footer',
		                    'std' => 'light',
		                    'options' => array(
		                    	'dark'=>__('Dark','om_theme'),
		                    	'light'=>__('Light','om_theme'),
		                    ),
		                    'type' => 'select2');

		////////////////////////////////////////////////////////////


		$options[] = array( "name" => __('Fonts','om_theme'),
		                    "type" => "heading");
		                    		                    
/*							
		$options[] = array( "name" => __('Uppercase', 'om_theme'),
		                    "desc" => __('Use uppercase for titles and some blocks', 'om_theme'),
		                    "id" => OM_THEME_PREFIX."titles_uppercase",
		                    "std" => "true",
		                    "type" => "checkbox");
*/
									                    
		$options[] = array( 'name' => __('Base font', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'base_font',
		                    'std' => array(
		                    	'type'=>'standard',
		                    	'standard'=>array('family'=>'Arial'),
		                    ),
		                    'options'=>array(
		                    	'Arial' => 'Arial',
		                    	'Times New Roman' => 'Times New Roman',
		                    	'Verdana' => 'Verdana',
		                    	'Tahoma' => 'Tahoma',
		                    	'Courier' => 'Courier',
		                    	'Courier New' => 'Courier New',
		                    	'Georgia' => 'Georgia',
		                    	'Impact' => 'Impact',
		                    	'Lucida Console' => 'Lucida Console',
		                    	'Trebuchet MS' => 'Trebuchet MS',
		                    ),
		                    'type' => 'font');
		                    
		$options[] = array( 'name' => __('Highlight font', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'sec_font',
		                    'std' => array(
		                    	'type'=>'google',
		                    	'google'=>array('family'=>'Open Sans'),
		                    ),
		                    'options'=>array(
		                    	'Arial' => 'Arial',
		                    	'Times New Roman' => 'Times New Roman',
		                    	'Verdana' => 'Verdana',
		                    	'Tahoma' => 'Tahoma',
		                    	'Courier' => 'Courier',
		                    	'Courier New' => 'Courier New',
		                    	'Georgia' => 'Georgia',
		                    	'Impact' => 'Impact',
		                    	'Lucida Console' => 'Lucida Console',
		                    	'Trebuchet MS' => 'Trebuchet MS',
		                    ),
		                    'type' => 'font');
		                    
		$options[] = array( 'name' => __('Primary menu font', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'menu_font',
		                    'std' => array(
		                    	'type'=>'google',
		                    	'google'=>array('family'=>'Open Sans'),
		                    ),
		                    'options'=>array(
		                    	'Arial' => 'Arial',
		                    	'Times New Roman' => 'Times New Roman',
		                    	'Verdana' => 'Verdana',
		                    	'Tahoma' => 'Tahoma',
		                    	'Courier' => 'Courier',
		                    	'Courier New' => 'Courier New',
		                    	'Georgia' => 'Georgia',
		                    	'Impact' => 'Impact',
		                    	'Lucida Console' => 'Lucida Console',
		                    	'Trebuchet MS' => 'Trebuchet MS',
		                    ),
		                    'type' => 'font');

		$tmp=array();
		for($i=80;$i<=160;$i++)
			$tmp[$i]=$i.'%';
		$options[] = array( 'name' => __('Font scaling', 'om_theme'),
		                    'desc' => __('You can scale all font sizes in the theme by this selector', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'font_scale',
		                    'std' => '100',
		                    'options' => $tmp,
		                    'type' => 'select2');
		unset($tmp);
		
		$tmp=array();
		for($i=1;$i<3.01;$i+=0.05)
			$tmp[]=sprintf('%01.2f',$i);
		$options[] = array( 'name' => __('Text Line Height', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'line_height',
		                    'std' => '1.60',
		                    'options' => $tmp,
		                    'type' => 'select');
		unset($tmp);
														                    
		////////////////////////////////////////////////////////////
		
		$options[] = array( "name" => __('Comments','om_theme'),
		                    "type" => "heading");

		$options[] = array( 'name' => __('Hide comments block on pages', 'om_theme'),
		                    'desc' => __('Check if you want to hide comments block on single pages. To hide comments on post pages and portfolio - see sections "Post options" and "Portfolio options"', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'hide_comments_page',
		                    'std' => '',
		                    'type' => 'checkbox');

		$options[] = array( 'name' => __('Hide comments block on the post pages', 'om_theme'),
		                    'desc' => __('Check if you want to hide comments block on the post pages.', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'hide_comments_post',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		if(isset($GLOBALS['omPortfolioPlugin'])) {
			$options[] = array( 'name' => __('Hide comments block on the portfolio pages', 'om_theme'),
			                    'desc' => __('Check if you want to hide comments block on the portfolio pages.', 'om_theme'),
			                    'id' =>  OM_THEME_PREFIX . 'hide_comments_portfolio',
			                    'std' => '',
			                    'type' => 'checkbox');
		}

		$options[] = array( "name" => "",
							"message" => __('Facebook comments','om_theme'),
							"type" => "subheader");
									                    
		$options[] = array( 'name' => __('Moderator Facebook user ID', 'om_theme'),
		                    'desc' => __('The easiest way to moderate comments - insert Facebook user ID who can moderate comments. To add multiple moderators, separate the uids by comma without spaces.', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'fb_comments_admin_id',
		                    'std' => '',
		                    'type' => 'text');

		$options[] = array( 'name' => __('Your Facebook application ID', 'om_theme'),
		                    'desc' => __('Second way to moderate comments - insert Facebook application ID. You will be able to moderate comments with Facebook Comment Moderation Tool <a href="http://developers.facebook.com/tools/comments" target="_blank">http://developers.facebook.com/tools/comments</a>', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'fb_comments_app_id',
		                    'std' => '',
		                    'type' => 'text');
		                    
		$options[] = array( 'name' => __('Number of posts to display by default', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'fb_comments_count',
		                    'std' => '2',
		                    'type' => 'text');
		                    
		$options[] = array( 'name' => __('Facebook comments color scheme', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'fb_comments_color',
		                    'std' => '',
		                    'options'=>array(
		                    	'' => 'Light',
		                    	'dark' => 'Dark',
		                    ),
		                    'type' => 'select2');

		$options[] = array( 'name' => __('Show Facebook comments on pages', 'om_theme'),
		                    'desc' => __('Check to show Facebook comments block on single pages', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'fb_comments_page',
		                    'std' => '',
		                    'type' => 'checkbox');

		$options[] = array( 'name' => __('Show Facebook comments on post pages', 'om_theme'),
		                    'desc' => __('Check to show Facebook comments block on single post pages', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'fb_comments_post',
		                    'std' => '',
		                    'type' => 'checkbox');

		if(isset($GLOBALS['omPortfolioPlugin'])) {
			$options[] = array( 'name' => __('Show Facebook comments on portfolio pages', 'om_theme'),
			                    'desc' => __('Check to show Facebook comments block on single portfolio pages', 'om_theme'),
			                    'id' =>  OM_THEME_PREFIX . 'fb_comments_portfolio',
			                    'std' => '',
			                    'type' => 'checkbox');
		}
		                    
		$options[] = array( 'name' => __('Position of Facebook comments', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'fb_comments_position',
		                    'std' => '',
		                    'options'=>array(
		                    	'' => 'Before Wordrpess Comments',
		                    	'after' => 'After Wordpress Comments',
		                    ),
		                    'type' => 'select2');

		////////////////////////////////////////////////////////////

		
		$options[] = array( "name" => __('Page titles','om_theme'),
		                    "type" => "heading");
		                    
		$options[] = array( "name" => "",
							"message" => __('You can set default page titles layout here. Also it\'s possible to set custom page title layout for a specific page when edit it.','om_theme'),
							"type" => "intro");
		
		$options[] = array ( "name" => __('Page Title Layout','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."default_page_title",
					"type" => "select2",
					"std" => 'standard',
					'options' => array(
						'standard' => __('Standard', 'om_theme'),
						'hide' => __('Hide', 'om_theme'),
						'color' => __('Custom background color', 'om_theme'),
						'image' => __('Custom background image', 'om_theme'),
						'parallax' => __('Predefined parallax effect', 'om_theme'),
					),
					'code' => '<script>
						jQuery(function($){
							$("#'.OM_THEME_PREFIX.'default_page_title").change(function(){
								$("#'.OM_THEME_PREFIX.'default_title_align").parents(".om-options-section").hide();
								$("#'.OM_THEME_PREFIX.'default_title_margins").parents(".om-options-section").hide();
								$("#'.OM_THEME_PREFIX.'default_title_size").parents(".om-options-section").hide();
								$("#'.OM_THEME_PREFIX.'default_title_bg_color").parents(".om-options-section").hide();
								$("#'.OM_THEME_PREFIX.'default_title_text_color").parents(".om-options-section").hide();
								$("#'.OM_THEME_PREFIX.'default_title_bg_img").parents(".om-options-section").hide();
								$("#'.OM_THEME_PREFIX.'default_title_bg_img_pos").parents(".om-options-section").hide();
								$("#'.OM_THEME_PREFIX.'default_title_bg_img_att").parents(".om-options-section").hide();
								$("#'.OM_THEME_PREFIX.'default_title_parallax").parents(".om-options-section").hide();
								
								if($(this).val() == "standard") {
									$("#'.OM_THEME_PREFIX.'default_title_align").parents(".om-options-section").show();
								} else if($(this).val() == "color") {
									$("#'.OM_THEME_PREFIX.'default_title_align").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_margins").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_size").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_bg_color").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_text_color").parents(".om-options-section").show();
								} else if($(this).val() == "image") {
									$("#'.OM_THEME_PREFIX.'default_title_align").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_bg_color").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_bg_img").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_bg_img_pos").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_bg_img_att").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_margins").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_size").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_text_color").parents(".om-options-section").show();
								} else if($(this).val() == "parallax") {
									$("#'.OM_THEME_PREFIX.'default_title_align").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_bg_color").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_margins").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_size").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_text_color").parents(".om-options-section").show();
									$("#'.OM_THEME_PREFIX.'default_title_parallax").parents(".om-options-section").show();
								}
							}).change();
						});
					</script>',
			);
			
		$options[] = array ( "name" => __('Title align','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."default_title_align",
					"type" => "select2",
					"std" => '',
					'options' => array(
						'' => __('Left', 'om_theme'),
						'center' => __('Center', 'om_theme'),
						'center_bottom' => __('Center, bottom', 'om_theme'),
					),
			);
			
		$options[] = array ( "name" => __('Title margins','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."default_title_margins",
					"type" => "select2",
					"std" => '',
					'options' => array(
						'' => __('Small', 'om_theme'),
						'medium' => __('Medium', 'om_theme'),
						'large' => __('Large', 'om_theme'),
						'xlarge' => __('X-Large', 'om_theme'),
						'xxlarge' => __('XX-Large', 'om_theme'),
					),
			);
			
		$options[] = array ( "name" => __('Title size','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."default_title_size",
					"type" => "select2",
					"std" => '',
					'options' => array(
						'' => __('Standard', 'om_theme'),
						'large' => __('Large', 'om_theme'),
						'xlarge' => __('X-Large', 'om_theme'),
						'xxlarge' => __('XX-Large', 'om_theme'),
					),
			);
			
		$options[] = array ( "name" => __('Title background color','om_theme'),
					"desc" => __('To automatically apply theme Hightlight color from Theme Options type "theme" or click "default"'),
					"id" => OM_THEME_PREFIX."default_title_bg_color",
					"type" => "color",
					"std" => 'theme',
			);
			
		$options[] = array ( "name" => __('Title text color','om_theme'),
					"desc" => __('To automatically apply theme Hightlight color from Theme Options type "theme"'),
					"id" => OM_THEME_PREFIX."default_title_text_color",
					"type" => "color",
					"std" => '#FFFFFF',
			);
			
		$options[] = array ( "name" => __('Title background image','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."default_title_bg_img",
					"type" => "upload",
					"std" => '',
					"library" => 'image',
			);
			
		$options[] = array ( "name" => __('Title background image position','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."default_title_bg_img_pos",
					"type" => "select2",
					"std" => '',
          'options'=>om_get_bg_img_pos_options(),
			);
			
		$options[] = array ( "name" => __('Title background image attachment','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."default_title_bg_img_att",
					"type" => "select2",
					"std" => 'scroll',
          'options'=>array(
          	'scroll' => __('Scroll','om_theme'),
          	'fixed' => __('Fixed','om_theme'),
          ),
			);
			
		$options[] = array ( "name" => __('Parallax effect','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."default_title_parallax",
					"type" => "select2",
					"std" => '',
					'options' => array(
						'' => __('Lines', 'om_theme'),
						'geometry' => __('Geometry', 'om_theme'),
						'circles' => __('Circles', 'om_theme'),
					),
			);

		                    		                    
		////////////////////////////////////////////////////////////

		
		$options[] = array( "name" => __('Blog options','om_theme'),
		                    "type" => "heading");
		                    
		$options[] = array( 'name' => __('Excerpt mode', 'om_theme'),
		                    'desc' => __('&lt;!--more--&gt; tag can be inserted with "Insert More Tag" button at the toolbar pane. Custom excerpt field can be enabled under "Screen options - Excerpt" when you edit the post','om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'blog_excerpt_mode',
		                    'std' => 'more',
		                    'options'=>array(
		                    	'more' => __('Excerpt separated by &lt;!--more--&gt; tag or set by custom excerpt field','om_theme'),
		                    	'auto' => __('Excerpt generated automatically if not set by custom excerpt field','om_theme'),
		                    ),
		                    'type' => 'select2');
		                    
		$options[] = array( 'name' => __('Auto excerpt length', 'om_theme'),
		                    'desc' => __('Specify the length of excerpt in number of words, if the automatically generated excerpt chosen above', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'blog_excerpt_length',
		                    'std' => '30',
		                    'type' => 'text');

		$options[] = array( 'name' => __('Hide post author', 'om_theme'),
		                    'desc' => __('Check, if you want to hide post author name', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'post_hide_author',
		                    'std' => '',
		                    'type' => 'checkbox');

		$options[] = array( 'name' => __('Hide post categories', 'om_theme'),
		                    'desc' => __('Check, if you want to hide post categories', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'post_hide_categories',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Hide post tags', 'om_theme'),
		                    'desc' => __('Check, if you want to hide post tags', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'post_hide_tags',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Hide post date', 'om_theme'),
		                    'desc' => __('Check, if you want to hide post date', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'post_hide_date',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Hide comments counter', 'om_theme'),
		                    'desc' => __('Check, if you want to hide post comments counter', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'post_hide_comments',
		                    'std' => '',
		                    'type' => 'checkbox');

		$options[] = array( 'name' => __('Show featured image on the post page', 'om_theme'),
		                    'desc' => __('Check to show the featured image at the beginning of the post on the single post page', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'post_single_show_thumb',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Previous/next navigation links', 'om_theme'),
		                    'desc' => __('Show previous/next links on post pages', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'show_prev_next_post',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => __('Pagination mode', 'om_theme'),
		                    'desc' => __('Choose the pagination mode for blog (number of posts per page can be set under "Settings - Reading")', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'blog_pagination',
		                    'std' => '',
		                    'options'=>array(
		                    	'' => __('Older/Newer links','om_theme'),
		                    	'pages' => __('Links to pages (1, 2, 3, ...)','om_theme'),
		                    ),
		                    'type' => 'select2');

		$options[] = array( "name" => "",
							"message" => __('Archive/Category Options','om_theme'),
							"type" => "subheader");

		$options[] = array( 'name' => __('Pull sidebar/slider settings for Archive/Category pages from page:', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'archive_category_page_settings',
		                    'std' => '',
		                    'type' => 'select-page');
		                    
		$options[] = array( "name" => "",
							"message" => __('Frontpage displays latest posts','om_theme'),
							"type" => "subheader");

		$options[] = array( 'name' => __('Pull sidebar/slider settings for Frontpage from page:', 'om_theme'),
		                    'desc' => __('Use this option if Frontpage displays latest posts','om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'front_page_settings',
		                    'std' => '',
		                    'type' => 'select-page');
		                    
		////////////////////////////////////////////////////////////

		$options[] = array( "name" => __('Lightbox','om_theme'),
		                    "type" => "heading");
		                    
		$options[] = array( 'name' => __('PrettyPhoto Lightbox', 'om_theme'),
		                    'desc' => __('Check to show navigation chain', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'prettyphoto_lightbox',
		                    'std' => 'enabled',
		                    'options'=>array(
													'enabled' => __('Use Lightbox for images and galleries', 'om_theme'),
													'disabled' => __('Disable Lightbox', 'om_theme'),
													'disabled_no_action' => __('Disable Lightbox and disable click on image in galleries', 'om_theme'),
		                    ),
		                    'type' => 'select2');

		$options[] = array( 'name' => '',
		                    'desc' => __('Show title', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'prettyphoto_show_title',
		                    'std' => 'true',
		                    'type' => 'checkbox');
		                    
		$options[] = array( 'name' => '',
		                    'desc' => __('Show social buttons', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'prettyphoto_social_tools',
		                    'std' => 'false',
		                    'type' => 'checkbox');

		$options[] = array( 'name' => '',
		                    'desc' => __('Overlay gallery on the fullscreen image on mouse over', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'prettyphoto_overlay_gallery',
		                    'std' => 'false',
		                    'type' => 'checkbox');
		                    		                    
		                    
		                    
		////////////////////////////////////////////////////////////

		$options[] = array( "name" => __('Breadcrumbs','om_theme'),
		                    "type" => "heading");
		                    
		$options[] = array( 'name' => __('Show breadcrumbs', 'om_theme'),
		                    'desc' => __('Check to show navigation chain', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'show_breadcrumbs',
		                    'std' => 'true',
		                    'type' => 'checkbox');

		$options[] = array( 'name' => __('Breadcrumbs caption', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'breadcrumbs_caption',
		                    'std' => '',
		                    'type' => 'text');

		$options[] = array( 'name' => __('Current page title', 'om_theme'),
		                    'desc' => __('Check to include current page title to breadcrumbs', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'breadcrumbs_show_current',
		                    'std' => '',
		                    'type' => 'checkbox');
		                    
	
		////////////////////////////////////////////////////////////
		

		$options[] = array( "name" => __('Sidebars','om_theme'),
		                    "type" => "heading");

		$options[] = array( "name" => __('Sidebar position','om_theme'),
							"desc" => __('Select sidebar alignment.','om_theme'),
							"id" => OM_THEME_PREFIX."sidebar_position",
							"std" => "right",
							"type" => "images",
							"options" => array(
								'right' => TEMPLATE_DIR_URI . '/admin/images/2cr.png',
								'left' => TEMPLATE_DIR_URI . '/admin/images/2cl.png'
							)
						);

/*						
		$options[] = array( "name" => "",
							"message" => __('You can set the number of available alternative sidebars, set them up at the "Appearance > Widgets" section and choose for every page one of them at the page settings.','om_theme'),
							"type" => "intro");
							
		$options[] = array( "name" => __('Number of alternative sidebars','om_theme'),
					"desc" => '',
					"id" => OM_THEME_PREFIX."sidebars_num",
					"std" => "3",
					"type" => "text");
*/

		$options[] = array( "name" => __('Sidebar sliding','om_theme'),
							"desc" => __('Check to enable sidebar sliding up and down when it\'s height less than page content height.','om_theme'),
							"id" => OM_THEME_PREFIX."sidebar_sliding",
							"std" => "true",
							"type" => "checkbox",
						);
						
		$options[] = array( "name" => __('Sidebar delay before sliding','om_theme'),
					"desc" => __('Value in milliseconds','om_theme'),
					"id" => OM_THEME_PREFIX."sidebar_sliding_delay",
					"std" => "1200",
					"type" => "text");


		$options[] = array( "name" => '',
												"message" => '<b>'.sprintf( __('You can create new sidebars on <a href="%s">Appearance &gt; Sidebars</a> page','om_theme'), admin_url('themes.php?page=om_sidebars') ).'</b>',
		                    "type" => "note");

					
		////////////////////////////////////////////////////////////

		$options[] = array( "name" => __('Social icons','om_theme'),
		                    "type" => "heading");

		$options[] = array( "name" => __('Social icons in the header','om_theme'),
							"desc" => __('Check to display social icons in the header.','om_theme'),
							"id" => OM_THEME_PREFIX . 'social_icons_header',
							"std" => "true",
							"type" => "checkbox",
						);

		$options[] = array( "name" => __('Social icons in the footer','om_theme'),
							"desc" => __('Check to display social icons in the footer.','om_theme'),
							"id" => OM_THEME_PREFIX . 'social_icons_footer',
							"std" => "true",
							"type" => "checkbox",
						);
								                    
		$options[] = array( "name" => '',
												"message" => __('Specify necessary links and icons will be shown in the header. Note, that link should begins with http://','om_theme'),
		                    "type" => "intro");

		$options[] = array( "name" => '',
												"message" => '<b>'.sprintf(__('You can set order of icons for the front page <a href="%s">here</a>','om_theme'), admin_url('options.php?page=social_icons_sort')).'</b>',
		                    "type" => "note");

		
		$icons=om_social_icons_list();
		foreach($icons as $k=>$v) {
			$options[] = array( 'name' => $v.' '.__('link','om_theme'),
			                    'id' =>  OM_THEME_PREFIX . 'social_'.$k,
			                    'std' => '',
			                    'type' => 'text');
		}                    

		////////////////////////////////////////////////////////////


		$options[] = array( "name" => __('Sliders','om_theme'),
		                    "type" => "heading");

		$options[] = array( "name" => "",
							"message" => __('LayerSlider','om_theme'),
							"type" => "subheader");
							
		if(isset($GLOBALS['lsPluginVersion']) || defined('LS_PLUGIN_VERSION')){
			$options[] = array( "name" => "",
								"message" => sprintf(__('LayerSlider can be deactivated via <a href="%s">plugins manager tool</a>.','om_theme'),admin_url('plugins.php')),
								"type" => "note");
		} else {
			$options[] = array( "name" => "",
								"message" => sprintf(__('LayerSlider can be installed and activated via <a href="%s">theme plugins manager tool</a>.','om_theme'),admin_url('themes.php?page=install-required-plugins')),
								"type" => "note");
		}
		                    
		$options[] = array( "name" => "",
							"message" => __('Revolution slider','om_theme'),
							"type" => "subheader");

		if(class_exists('RevSlider')){
			$options[] = array( "name" => "",
								"message" => sprintf(__('Revolution slider can be deactivated via <a href="%s">plugins manager tool</a>.','om_theme'),admin_url('plugins.php')),
								"type" => "note");
		} else {
			$options[] = array( "name" => "",
								"message" => sprintf(__('Revolution slider can be installed and activated via <a href="%s">theme plugins manager tool</a>.','om_theme'),admin_url('themes.php?page=install-required-plugins')),
								"type" => "note");
		}		

		////////////////////////////////////////////////////////////


		$options[] = array( "name" => __('Visual Composer','om_theme'),
		                    "type" => "heading");
		                    
		if(om_wpb_activated()){
			$options[] = array( "name" => "",
								"message" => sprintf(__('Visual Composer can be deactivated via <a href="%s">plugins manager tool</a>.','om_theme'),admin_url('plugins.php')),
								"type" => "note");
								
			$options[] = array( 'name' => 'Deactivate Visual Composer Theme`s Addons',
			                    'desc' => __('Check this option if you want to deactivate all addons and modifications, provided by the Theme. It can be handy, if you want to use some other addon for Visual Composer, but it cause a conflict.', 'om_theme'),
			                    'id' =>  OM_THEME_PREFIX . 'disable_wpb_addons',
			                    'std' => '',
			                    'type' => 'checkbox');
			                    
		} else {
			$options[] = array( "name" => "",
								"message" => sprintf(__('Visual Composer can be installed and activated via <a href="%s">theme plugins manager tool</a>.','om_theme'),admin_url('themes.php?page=install-required-plugins')),
								"type" => "note");
								
		}
		
		////////////////////////////////////////////////////////////

		/*
		$options[] = array( "name" => __('Theme updates','om_theme'),
		                    "type" => "heading");

		$options[] = array( "name" => "",
								"message" => __('If you want to receive notifications about new Theme versions in WordPress Dashboard, please, specify your ThemeForest(Envato) username and API key below.','om_theme'),
								"type" => "note");		                    
								
		$options[] = array( 'name' => __('Your ThemeForest(Envato) username', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'envato_username',
		                    'std' => '',
		                    'type' => 'text');
		                    
		$options[] = array( 'name' => __('Your ThemeForest(Envato) API key', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'envato_api',
		                    'std' => '',
		                    'type' => 'text');
		*/			
		////////////////////////////////////////////////////////////


		                    
		$options[] = array( "name" => __('Extra code blocks, counters','om_theme'),
		                    "type" => "heading");
		                    
		$options[] = array( 'name' => __('Code block for custom CSS', 'om_theme'),
		                    'desc' => __('Here you can add custom CSS code', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'code_custom_css',
		                    'std' => '',
		                    'rows' => '20',
		                    'type' => 'textarea');
		                    
		$options[] = array( 'name' => __('Google Analytics Tracking ID', 'om_theme'),
		                    'desc' => __('Specify your Tracking ID to enable Google Analytics.<br/>NOTE: you don\'t need to insert whole tracking code, only Tracking ID (UA-XXXXXXXX)', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'google_tracking_id',
		                    'std' => '',
		                    'type' => 'text');

/*		                    
		$options[] = array( 'name' => __('Code block before &lt;/head&gt;', 'om_theme'),
		                    'desc' => __('Here you can add Google.Analytics code', 'om_theme'),
		                    'id' =>  OM_THEME_PREFIX . 'code_before_head',
		                    'std' => '',
		                    'type' => 'textarea');
		                    
		$options[] = array( 'name' => __('Code block before &lt;/body&gt;', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'code_before_body',
		                    'std' => '',
		                    'type' => 'textarea');
		                    
		$options[] = array( 'name' => __('Code block after page header (&lt;/H1&gt;)', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'code_after_page_h1',
		                    'std' => '',
		                    'type' => 'textarea');

		$options[] = array( 'name' => __('Code block after page content', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'code_after_page_content',
		                    'std' => '',
		                    'type' => 'textarea');
		                    
		$options[] = array( 'name' => __('Code block after post header (&lt;/H1&gt;) on the single page', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'code_after_post_h1',
		                    'std' => '',
		                    'type' => 'textarea');

		$options[] = array( 'name' => __('Code block after post content on the single page', 'om_theme'),
		                    'desc' => '',
		                    'id' =>  OM_THEME_PREFIX . 'code_after_post_content',
		                    'std' => '',
		                    'type' => 'textarea');

		if(isset($GLOBALS['omPortfolioPlugin'])) {		                    
			$options[] = array( 'name' => __('Code block after portfolio header (&lt;/H1&gt;) on the single page', 'om_theme'),
			                    'desc' => '',
			                    'id' =>  OM_THEME_PREFIX . 'code_after_portfolio_h1',
			                    'std' => '',
			                    'type' => 'textarea');
	
			$options[] = array( 'name' => __('Code block after portfolio content on the single page', 'om_theme'),
			                    'desc' => '',
			                    'id' =>  OM_THEME_PREFIX . 'code_after_portfolio_content',
			                    'std' => '',
			                    'type' => 'textarea');

			$options[] = array( 'name' => __('Code block after portfolio description on the single page', 'om_theme'),
			                    'desc' => '',
			                    'id' =>  OM_THEME_PREFIX . 'code_after_portfolio_description',
			                    'std' => '',
			                    'type' => 'textarea');

		}
*/
		if(defined('ICL_SITEPRESS_VERSION')) {

			$options[] = array( "name" => __('WPML','om_theme'),
			                    "type" => "heading");
			                    
			$options[] = array( 'name' => '',
			                    'desc' => __('Display WPML language selector in the header', 'om_theme'),
			                    'id' =>  OM_THEME_PREFIX . 'show_wpml_language_selector',
			                    'std' => '',
			                    'type' => 'checkbox');
			                    
		}
			

		/* IF WPML PLUGIN INSTALLED */
		/*
		global $sitepress;
		if(defined('ICL_SITEPRESS_VERSION') && isset($sitepress) && $sitepress->get_default_language()) {
			$active_languages = $sitepress->get_active_languages();
			if(!empty($active_languages)) {
				$options_new=array();
				foreach($options as $k=>$v) {
					if($v['type'] == 'form_fields') {
						$v['mode']='toggle';
						$v_=$v;
						$v_['name'].=' ('.@$active_languages[$sitepress->get_default_language()]['display_name'].')';
						$options_new[]=$v_;
		
						foreach($active_languages as $lang=>$lang_arr) {
							if($lang != $sitepress->get_default_language()) {
								$v_=$v;
								$v_['id'].='_'.$lang;
								$v_['name'].=' ('.$lang_arr['display_name'].')';
								$options_new[]=$v_;
							}
						}
					} else {
						$options_new[]=$v;
					}
				}
				$options=$options_new;
			}
		}
		*/
		/* /IF WPML PLUGIN INSTALLED */
		
		if($id_as_key) {
			$options_=array();
			foreach($options as $v) {
				if(isset($v['id'])) {
					$options_[$v['id']]=$v;
				}
			}
			$options=$options_;
		}
		
		return $options;
	}
}