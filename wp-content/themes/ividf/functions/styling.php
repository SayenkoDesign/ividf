<?php

if( !function_exists( 'om_include_fonts' ) ) {
	function om_include_fonts() {

		$charsets=array(
			'latin_ext',
			'arabic',
			'cyrillic',
			'cyrillic_ext',
			'devanagari',
			'greek',
			'greek_ext',
			'hebrew',
			'khmer',
			'telugu',
			'vietnamese',
		);
		
		$fonts=array();
		
		$base_font=get_option(OM_THEME_PREFIX . 'base_font');
		if(isset($base_font['type']) && $base_font['type'] == 'google' && isset($base_font['google']))
			$fonts[]=$base_font['google'];

		$sec_font=get_option(OM_THEME_PREFIX . 'sec_font');
		if(isset($sec_font['type']) && $sec_font['type'] == 'google' && isset($sec_font['google']))
			$fonts[]=$sec_font['google'];

		$menu_font=get_option(OM_THEME_PREFIX . 'menu_font');
		if(isset($menu_font['type']) && $menu_font['type'] == 'google' && isset($menu_font['google']))
			$fonts[]=$menu_font['google'];
		
		foreach($fonts as $arr) {
			
			$charsets_include=array();
			foreach($charsets as $charset) {
				if( isset($arr[$charset]) && $arr[$charset] ) {
					$charsets_include[]=$charset;
				}
			}

			$subset='';			
			if(!empty($charsets_include)) {
				$subset='&subset=latin,'.implode(',',$charsets_include);
			}

			$weight_normal=400;
			if(isset($arr['weight_normal']))
				$weight_normal=$arr['weight_normal'];
			$weight_bold=700;
			if(isset($arr['weight_bold']))
				$weight_bold=$arr['weight_bold'];
			
			$family=urlencode($arr['family']).':'.$weight_normal.','.$weight_bold.$subset;
			wp_enqueue_style(sanitize_title($family), '//fonts.googleapis.com/css?family='.$family);

		}
	}
}
add_action('wp_enqueue_scripts', 'om_include_fonts');

if( !function_exists( 'om_theme_get_styling' ) ) {
	
	function om_theme_get_styling() {
		
		ob_start();
		
		/**
		 * Fonts
		 */
		 
		$base_font=get_option(OM_THEME_PREFIX . 'base_font');
		$sec_font=get_option(OM_THEME_PREFIX . 'sec_font');
		$menu_font=get_option(OM_THEME_PREFIX . 'menu_font');
			
		// Base font
		if(isset($base_font['type'])) {
			$base_font_f=$base_font[$base_font['type']]['family'];
			
			$base_weight_normal=400;
			$base_weight_bold=700;
			if($base_font['type'] == 'google') {
				if(isset($base_font['google']['weight_normal']))
					$base_weight_normal=$base_font['google']['weight_normal'];
				if(isset($base_font['google']['weight_bold']))
					$base_weight_bold=$base_font['google']['weight_bold'];
			}
			
			if($base_font_f) {
				echo '
					body,
					input,
					textarea,
					.blockquote-author,
					.om_theme .vc_toggle_title h4,
					.om_theme .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header
					{font-family:'.$base_font_f.'}';
					
				if($base_weight_normal != 400) {
					echo '
						body,
						.om_theme .vc_toggle_title h4,
						.om_theme .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header,
						.header #s,
						.vc_om-table-style-1 table th
						{font-weight:'.$base_weight_normal.'}';
				}
				if($base_weight_bold != 700) {
					echo '
						b, strong, dt,
						.logo-text,
						.comment-meta .author
						{font-weight:'.$base_weight_bold.'}';
				}
			}
		}
		
		// Highlight font
		if(isset($sec_font['type'])) {
			$sec_font_f=@$sec_font[@$sec_font['type']]['family'];

			$sec_weight_normal=400;
			$sec_weight_bold=700;
			if(@$sec_font['type'] == 'google') {
				if(isset($sec_font['google']['weight_normal']))
					$sec_weight_normal=$sec_font['google']['weight_normal'];
				if(isset($sec_font['google']['weight_bold']))
					$sec_weight_bold=$sec_font['google']['weight_bold'];
			}
			
	
			
			if($sec_font_f) {
				echo '
					h1,h2,h3,h4,h5,h6,
					.primary-menu,
					.sidebar-widget-title,
					.footer-widget-title,
					blockquote,
					.blockquote,
					.ompf-portfolio-thumb .ompf-title,
					.vc_om-testimonials .om-item-text,
					.wpb_heading,
					.vc_om-ptc-title-title,
					.vc_om-table-style-1 table th,
					.vc_om-person .om-person-name,
					.vc_om-click-box,
					.vc_om-click-icon-box .om-cib-title,
					.vc_om-click-icon-box-2 .om-cib2-content-title
					{font-family:'.$sec_font_f;
				if($sec_weight_normal != 400) {
					echo ';font-weight:'.$sec_weight_normal;
				}
				echo '}';
				
				if($sec_weight_bold != 700) {
					echo '
						.footer-widget-title,
						.sidebar-widget-title,
						.ompf-portfolio-thumb .ompf-title,
						.vc_om-person .om-person-name,
						.vc_om-click-box,
						.vc_om-click-icon-box .om-cib-title,
						.vc_om-click-icon-box-2 .om-cib2-content-title
						{font-weight:'.$sec_weight_bold.'}';
				}
			}
		}

		// Menu font
		if(isset($menu_font['type'])) {
			$menu_font_f=@$menu_font[@$menu_font['type']]['family'];				
		
			$menu_weight_normal=400;
			$menu_weight_bold=700;
			if($menu_font['type'] == 'google') {
				if(isset($menu_font['google']['weight_normal']))
					$menu_weight_normal=$menu_font['google']['weight_normal'];
				if(isset($menu_font['google']['weight_bold']))
					$menu_weight_bold=$menu_font['google']['weight_bold'];
			}
			
			if($menu_font_f) {
				echo '
					.primary-menu
					{font-family:'.$menu_font_f;
				if($menu_weight_normal != 400) {
					echo ';font-weight:'.$menu_weight_normal;
				}
				echo '}';
				
				
				if($menu_weight_bold != 700) {
					echo '
						.primary-menu > li.megamenu-enable > ul > li > a,
						.primary-menu.menu-bold > li > a
						{font-weight:'.$menu_weight_bold.'}';
				}
				
			}
		}		
		
		
		/* Font scale */
		
		$font_scale=intval(get_option(OM_THEME_PREFIX . 'font_scale'));
		if(!$font_scale)
			$font_scale=100;
		if($font_scale != 100) {
			$font_scale/=100;
			
			echo 'body{font-size:'.round(12*$font_scale).'px}';
		}
		
		$line_height=floatval(get_option(OM_THEME_PREFIX . 'line_height'));
		if($line_height) {
			echo '
				body,
				.om_theme .vc_toggle_title h4 {line-height:'.$line_height.'}
			';

			echo '
				h1,h2,h3,h4,h5,h6,.wpb_heading {line-height:'.($line_height*0.85).'}
			';
			
			echo '
				a.more-link .more-link-inner:before,a.more-link .more-link-inner:after,
				.vc_om_a_button .vc_om-icon-w {width: '.$line_height.'em}
			';
			
			echo '
				a.more-link .more-link-inner
				{left: -'.$line_height.'em}
			';
			echo '
				.vc_om_a_button .vc_om-ab-inner
				{left: -'.($line_height+0.6).'em}
			';
			echo '
				.vc_om_a_button.vc_om-size-xs .vc_om-ab-inner
				{left: -'.($line_height+0.14).'em}
			';
			echo '
				.vc_om_a_button.vc_om-size-sm .vc_om-ab-inner
				{left: -'.($line_height+0.4).'em}
			';
			echo '
				.vc_om_a_button.vc_om-size-lg .vc_om-ab-inner
				{left: -'.($line_height+0.8).'em}
			';
			echo '
				.vc_om_a_button.vc_om-size-xlg .vc_om-ab-inner
				{left: -'.($line_height+1).'em}
			';
		}
			
		/**
		 * Overall Background
		 */ 
		 
		$bg_color=get_option(OM_THEME_PREFIX . 'background_color');
		$bg_img=get_option(OM_THEME_PREFIX . 'background_img');
		$bg_img_custom=get_option(OM_THEME_PREFIX . 'background_img_custom');
		$bg_pos=get_option(OM_THEME_PREFIX . 'background_pos');
		$attach=get_option(OM_THEME_PREFIX . 'background_attach');
	
		$style=array();
	
		if($bg_color)
			$style[]='background-color:'.$bg_color;
	
		if($bg_img_custom)
			$style[]='background-image:url('.$bg_img_custom.')';
		elseif($bg_img!='none' && $bg_img!='')
			$style[]='background-image:url('.TEMPLATE_DIR_URI.'/img/bg/'.$bg_img.')';
		
			
			
		if($bg_img_custom || $bg_img) {
			$style=array_merge($style,om_bg_img_pos_style($bg_pos));
			
			if($attach == 'fixed')
				$style[]='background-attachment:fixed';
			elseif($attach == 'scroll')
				$style[]='background-attachment:scroll';
		}
	
		if(!empty($style))
			$style=implode(';',$style);
		else
			$style='';
		
		echo 'body{'.$style.'}';


		if(get_option(OM_THEME_PREFIX . 'background_dots_overlay') == 'true')
			echo '.bg-overlay{background-image:url('.TEMPLATE_DIR_URI.'/img/bg-overlay.png);}';
			
		$dimming=intval(trim(get_option(OM_THEME_PREFIX . 'background_dimming')));
		if($dimming) {
			if($dimming > 100)
				$dimming=100;
			$dimming/=100;
			$dimming_color=get_option(OM_THEME_PREFIX . 'background_dimming_color');
			if($dimming_color == 'white')
				echo '.bg-overlay{background-color:rgba(255,255,255,'.$dimming.');} ';
			elseif($dimming_color == 'black')
				echo '.bg-overlay{background-color:rgba(0,0,0,'.$dimming.');} ';
		}
		
		/**
		 * Common
		 */
		 
		$hightlight_color=get_option(OM_THEME_PREFIX . 'hightlight_color');
		echo '
			.om_theme .om-hl-border-color,
			.header .search-popup,
			.header .header-mobile-menu #s,
			.om_theme input[type=text]:focus,
			.om_theme input[type=email]:focus,
			.om_theme input[type=tel]:focus,
			.om_theme input[type=password]:focus,
			.om_theme textarea:focus,
			#wp-calendar th,
			.vc_separator.vc_sep_color_om-theme-color .vc_sep_line,
			.content .post-link-box a:hover,
			.om_theme .ompf-portfolio-categories li a:hover,
			.om_theme .wpb_teaser_grid .categories_filter li a:hover,
			.ompf-loadmore-link:hover,
			.navigation-pages a:hover,
			.om_theme .vc_toggle.vc_toggle_active .vc_toggle_title,
			.om_theme .vc_toggle_title:hover,
			.om_theme .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header.ui-accordion-header-active,
			.om_theme .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header:hover,
			.om_theme .wpb_content_element .wpb_tabs_nav,
			.om_theme .vc_tta-tabs-list,
			.vc_om-box.vc_om-border-om-theme-color,
			.vc_om-box.vc_om-border-om-theme-color .vc_om-box-icon,
			.vc_om-ptc.vc_om-ptc-featured .vc_om-ptc-inner,
			.vc_om_a_button:hover .vc_om-brd,
			a.more-link:hover .more-link-brd,
			.om_theme .vc_om-person .om-person-social a:hover,
			.vc_om-teaser .om-t-bg,
			.vc_message_box.vc_message_box-solid-icon.vc_color-om-theme-color,
			.vc_message_box.vc_message_box-outline.vc_color-om-theme-color,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-om-theme-color.vc_icon_element-outline,
			.vc_btn3.vc_btn3-style-outline.vc_btn3-color-om-theme-color,
			.om_theme .vc_tta.vc_tta-style-classic .vc_tta-panel.vc_active .vc_tta-panel-heading,
			.om_theme .vc_tta.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-heading:hover
			{border-color:'.$hightlight_color.'}';

		echo '
			.vc_om-table-style-1 table,
			.vc_om-table-style-1 table th
			{border-bottom-color:'.$hightlight_color.'}';			

		echo '
			.vc_om-table-style-1 table
			{border-top-color:'.$hightlight_color.'}';		

		echo '
			::selection{color:#fff;background:'.$hightlight_color.'}';

		echo '
			::-moz-selection{color:#fff;background:'.$hightlight_color.'}';
									
		echo '
			.om_theme .om-hl-bg-color,
			.primary-menu > li > a > .primary-menu-line,
			.page-title-wrapper.tpl-color,
			.page-title-wrapper.tpl-image,
			.page-title-wrapper.tpl-parallax,
			#wp-calendar th,
			input[type=button],
			input[type=submit],
			input[type=reset],
			#wp-calendar caption,
			.navigation-prev a:before,
			.navigation-next a:after,
			.navigation-prev a:hover,
			.navigation-next a:hover,
			.navigation-pages-inner > span.current,
			a.more-link .more-link-inner:before,
			a.more-link .more-link-inner:after,
			.mejs-container .mejs-controls,
			.om_theme .ompf-preview-layout-full .ompf-portfolio-thumb a:hover,
			.sidebar-widget.widget_nav_menu .menu li a:hover,
			.sidebar-widget.widget_nav_menu .menu li.current-menu-item a,
			.vc_box_border.vc_box_border_om-theme-color, .vc_box_border_circle.vc_box_border_om-theme-color,
			.om_theme .ompf-portfolio-categories li a.ompf-active,
			.om_theme .ompf-portfolio-categories li a.ompf-active:hover,
			.om_theme .wpb_teaser_grid .categories_filter li.active a,
			.om_theme .wpb_teaser_grid .categories_filter li.active a:hover,
			.om_theme div.pp_default .pp_nav .pp_play:hover,
			.om_theme div.pp_default .pp_nav .pp_pause:hover,
			.om_theme div.pp_default a.pp_arrow_previous:hover,
			.om_theme div.pp_default a.pp_arrow_next:hover,
			.om_theme div.pp_default .pp_close:hover,
			.om_theme .vc_images_carousel .vc_carousel-indicators li.vc_active,
			.om_theme .vc_carousel .vc_carousel-indicators li.vc_active,
			.om_theme .wpb_content_element .wpb_tabs_nav li.ui-tabs-active,
			.om_theme .wpb_content_element.wpb_tour .wpb_tour_tabs_wrapper .wpb_tab:before,
			.om_theme .vc_images_carousel .vc_carousel-control > span,
			.om_theme .vc_carousel .vc_carousel-control > span,
			.vc_btn3.vc_btn3-style-flat.vc_btn3-color-om-theme-color,
			.vc_btn3.vc_btn3-style-3d.vc_btn3-color_om-theme-color,
			.vc_progress_bar .vc_single_bar.om-theme-color .vc_bar,
			.vc_om-box.vc_om-bg-om-theme-color,
			.vc_om-box.vc_om-icon-style-bg .vc_om-box-icon,
			.vc_om-box.vc_om-icon-style-border.vc_om-bg-om-theme-color .vc_om-box-icon,
			.vc_om_a_button.vc_om-style-colored_icon .vc_om-icon-w,
			.vc_om_a_button.vc_om-style-colored_text .vc_om-title,
			.vc_om_a_button.vc_om-style-colored_all .vc_om-icon-w,
			.vc_om_a_button.vc_om-style-colored_all .vc_om-title,
			.vc_om-person.om-person-style-centered .om-person-name-job:after,
			.vc_om-person.om-person-style-colored .om-person-name-job-social,
			.vc_om-person.om-person-style-colored .om-person-name-job,
			.vc_om-click-icon-box .om-cib-icon-inner.om-cib-back,
			.vc_om-click-icon-box:after,
			.vc_message_box.vc_message_box-standard.vc_color-om-theme-color,
			.vc_message_box.vc_message_box-solid.vc_color-om-theme-color,
			.vc_message_box.vc_message_box-solid-icon.vc_color-om-theme-color .vc_message_box-icon,
			.vc_message_box.vc_message_box-3d.vc_color-om-theme-color,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-background-color-om-theme-color.vc_icon_element-background,
			.om_theme .vc_tta.vc_general .vc_tta-tab.vc_active > a
			{background-color:'.$hightlight_color.'}';
			
		echo '
			.om_theme .mejs-controls .mejs-time-rail .mejs-time-loaded,
			.om_theme .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current
			{background:'.$hightlight_color.'}';

		echo '
			.om_theme .om-hl-color,
			.hightlight-color,
			.hightlight-color.page-title-wrapper,
			.mobile-header-menu-control.active,
			.search-popup-link:hover,
			.search-popup-link.active,
			.footer a:hover,
			.content a,
			.post-title h2 a:hover,
			blockquote,
			.blockquote,
			.post-link-box a:before,
			.blogroll .blogroll-item.sticky .post-title h2:before,
			.footer-widget ul.menu a:hover,
			.primary-menu-highlight-active .primary-menu li.current-menu-item > a,
			.vc_separator.vc_sep_color_om-theme-color h4,
			.vc_btn3.vc_btn3-style-outline.vc_btn3-color-om-theme-color,
			.vc_om-box.vc_om-icon-style-border:not(.vc_om-with-bg-color) .vc_om-box-icon,
			.vc_om-counter.vc_om-om-theme-color .vc_om-counter-number,
			.vc_om-ptc-price-prefix,
			.vc_om-ptc-price-price,
			.vc_om-ptc-price-cents,
			.vc_om-person .om-person-social a:hover,
			.custom-header-bg-merge-title .header-search .search-popup-link.active,
			.vc_om-click-icon-box .om-cib-icon-inner,
			.vc_icon_element.vc_icon_element-outer .vc_icon_element-inner.vc_icon_element-color-om-theme-color .vc_icon_element-icon
			{color:'.$hightlight_color.'}';
			
		echo '
			blockquote:after,
			.blockquote:after,
			.vc_om-testimonials:after
			{background-image: url(\'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="35" height="30"><polygon fill="'.$hightlight_color.'" points="0,0 15,0, 15,30 0,15"/><polygon fill="'.$hightlight_color.'" points="20,0 35,0, 35,30 20,15"/></svg>').'\');}';
		
		echo '
			.ompf-ajaxloading,
			.ompf-loadmoreloading
			{background-image: url(\'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="40" height="40" fill="'.$hightlight_color.'">
  <path opacity=".25" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"/>
  <path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z">
    <animateTransform attributeName="transform" type="rotate" from="0 16 16" to="360 16 16" dur="0.8s" repeatCount="indefinite" />
  </path>
</svg>
').'\');}';

		// alpha
		$rgb=om_parse2rgba($hightlight_color);

		echo '
			.om_theme .vc_progress_bar .vc_single_bar.om-theme-color,
			.content .vc_om-testimonials-controls .om-prev:hover:before,
			.content .vc_om-testimonials-controls .om-next:hover:before
			{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.07)}';

		// lighter highlight color
		$hsl=om_rgb2hsl(om_hex2rgb($hightlight_color));
		$hsl[2]+=0.1;
		if($hsl[2] > 1) {
			$hsl[2]=1;
		}
		$rgb=om_hsl2rgb($hsl);
		
		echo '
			input[type=button]:hover,
			input[type=submit]:hover,
			input[type=reset]:hover
			{background-color:rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')}';
		
		// darker highlight color (8%)
		$hsl=om_rgb2hsl(om_hex2rgb($hightlight_color));
		$hsl[2]-=0.08;
		if($hsl[2] < 0) {
			$hsl[2]=0;
		}
		$rgb=om_hsl2rgb($hsl);

		echo '
			.vc_btn3.vc_btn3-style-flat.vc_btn3-color-om-theme-color.vc_btn3-hover-color-auto:hover,
			.vc_btn3.vc_btn3-style-3d.vc_btn3-color-om-theme-color.vc_btn3-hover-color-auto:hover,
			.vc_om-click-box.om-hl-bg-color:hover
			{background-color:rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')}';

		echo '	
			.vc_btn3.vc_btn3-style-outline.vc_btn3-color-om-theme-color:hover
			{color:rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')}';
			
		echo '	
			.vc_btn3.vc_btn3-style-outline.vc_btn3-color-om-theme-color:hover
			{border-color:rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')}';

		// darker highlight color (15%)
		$hsl=om_rgb2hsl(om_hex2rgb($hightlight_color));
		$hsl[2]-=0.15;
		if($hsl[2] < 0) {
			$hsl[2]=0;
		}
		$rgb=om_hsl2rgb($hsl);
										
		echo '
			.vc_btn3.vc_btn3-style-3d.vc_btn3-color-om-theme-color
			{box-shadow:0 5px 0 rgb('.$rgb[0].','.$rgb[1].','.$rgb[2].')}';
		
		// lighter highlight color
		$rgb=om_hex2rgb($hightlight_color);
		
		echo '
			.custom-gallery .control-prev .prev,
			.custom-gallery .control-next .next,
			.custom-gallery .control-progress
			{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.55)}';
			
		echo '
			.ompf-preview-layout-full-hover .ompf-portfolio-thumb a:hover .ompf-desc-wrapper,
			.ompf-preview-layout-full-hover-2 .ompf-portfolio-thumb .ompf-desc-wrapper
			{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.85)}';

		echo '
			.hover-image-extra .over,
			.om_theme .ompf-portfolio-thumb a .ompf-pic-inner:after
			{background: rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.65);
				background: -moz-radial-gradient(center, ellipse cover,  rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.65) 0%, rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.05) 100%);
				background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.65)), color-stop(100%,rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.05)));
				background: -webkit-radial-gradient(center, ellipse cover,  rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.65) 0%,rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.05) 100%);
				background: -o-radial-gradient(center, ellipse cover,  rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.65) 0%,rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.05) 100%);
				background: -ms-radial-gradient(center, ellipse cover,  rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.65) 0%,rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.05) 100%);
				background: radial-gradient(ellipse at center,  rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.65) 0%,rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.05) 100%);}';

		echo '
			.ompf-ajaxloading,
			.ompf-loadmoreloading
			{border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',.25)}';
			
						
		/**
		 * Header
		 */
		
		$tagline_color=get_option(OM_THEME_PREFIX . 'tagline_color');
		echo '
			.header-top,
			.header-wpml-selector #lang_sel_list a,
			.header-wpml-selector #lang_sel_list a:hover,
			.header-wpml-selector #lang_sel a,
			.header-wpml-selector #lang_sel a:hover,
			.header-wpml-selector #lang_sel ul ul a,
			.header-wpml-selector #lang_sel ul ul a:hover
			{color:'.$tagline_color.'}';

		$pre_header_bg_color=get_option(OM_THEME_PREFIX . 'pre_header_background_color');
		echo '
			.header-top,
			.header-wpml-selector #lang_sel a,
			.header-wpml-selector #lang_sel ul ul a
			{background-color:'.$pre_header_bg_color.'}';
			
		$rgb=om_hex2rgb($tagline_color);

		echo '
		.header-top,
		.header-top *,
		.header-wpml-selector #lang_sel a,
		.header-wpml-selector #lang_sel ul ul a
		{border-color:'.$tagline_color.';border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.1)}';
			
		$header_bg_color=get_option(OM_THEME_PREFIX . 'header_background_color');
		echo '
			.header-mid,
			.header-mobile-menu,
			.primary-menu ul,
			.search-popup,
			.menu-stuck .header-menu,
			.menu-stuck .header-logo-menu
			{background-color:'.$header_bg_color.'}';

		if(get_option(OM_THEME_PREFIX . 'responsive') == 'true') {
			echo '
				@media only screen and (max-width: 767px) {
					.custom-header-bg-transparent .header
					{background-color:'.$header_bg_color.'}
				}';
		}
			
		echo '
			.search-popup:after
			{border-bottom-color:'.$header_bg_color.'}';	

		$menu_color=get_option(OM_THEME_PREFIX . 'menu_items_color');
		$menu_color_hover=get_option(OM_THEME_PREFIX . 'menu_items_color_hover');
		$submenu_color=get_option(OM_THEME_PREFIX . 'menu_sub_items_color');
		$submenu_color_hover=get_option(OM_THEME_PREFIX . 'menu_sub_items_color_hover');

		echo '
		.header,
		.header a,
		.search-popup input,
		.primary-menu > li.megamenu-enable > ul > li > a
		{color:'.$menu_color.'}';

		echo '
		.primary-menu a:hover
		{color:'.$menu_color_hover.'}';
		
		echo '
		.primary-menu ul a
		{color:'.$submenu_color.'}';

		echo '
		.primary-menu ul a:hover,
		.primary-menu ul li.sfHover > a
		{color:'.$submenu_color_hover.'}';

		$rgb=om_hex2rgb($menu_color);

		echo '
		.header-mid,
		.header-mid *,
		.header-mobile-menu,
		.header-mobile-menu *
		{border-color:'.$menu_color.';border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.1)}';

		/**
		 * Content
		 */
		 
		$bg_color=get_option(OM_THEME_PREFIX . 'background_main_content_color');
		echo '
		.content,
		.header-slider,
		.page-title-wrapper,
		.content .image-hover-links-inner,
		.content .ompf-portfolio-thumb,
		.om_theme .ompf-preview-layout-full .ompf-portfolio-thumb .ompf-desc-wrapper,
		.vc_om-ptc,
		.vc_om-ptc.vc_om-ptc-featured .vc_om-ptc-inner
		{background-color:'.$bg_color.'}';

		echo '
		.om-closing-inner
		{border-color:'.$bg_color.'}';

		$color=get_option(OM_THEME_PREFIX . 'main_text_color');
		
		echo '
		.content,
		.header-slider,
		.page-title-wrapper,
		.post-title h2,
		.om_theme .ompf-portfolio-thumb a
		{color:'.$color.'}';

		$rgb=om_hex2rgb($color);
		
		echo '
		.sidebar-widget,
		.content select,
		.content input,
		.content textarea,
		#wp-calendar tbody td,
		.comments-section,
		.comment-inner,
		.navigation-prev,
		.navigation-next,
		.navigation-pages a,
		.navigation-pages-inner > span.dots,
		.blogroll .blogroll-item,
		.search-results li,
		.sidebar-widget .menu li a,
		.content hr,
		.content .post-link-box a,
		blockquote,
		.blockquote,
		.vc_om-testimonials,
		.om_theme .ompf-preview-layout-full .ompf-portfolio-thumb .ompf-desc-wrapper,
		.om_theme .ompf-portfolio-thumb a,
		.om_theme .ompf-portfolio-thumb a:hover,
		.om_theme .ompf-portfolio-categories li a,
		.om_theme .wpb_teaser_grid .categories_filter li a,
		.content .ompf-loadmore-link,
		.content .vc_toggle_title,
		.content .vc_toggle_content,
		.content .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_header,
		.content .wpb_accordion .wpb_accordion_wrapper .wpb_accordion_content,
		.content .wpb_content_element.wpb_tabs .wpb_tour_tabs_wrapper .wpb_tab,
		.content .wpb_content_element .wpb_tabs_nav li a,
		.om_theme .vc_tta.vc_tta-style-classic .vc_tta-tab > a,
		.content .wpb_thumbnails-fluid[data-layout-mode=masonry] .isotope-inner,
		.vc_om-pricing-table.vc_om-style-1 .vc_om-ptc,
		.vc_om-pricing-table.vc_om-style-1 .vc_om-ptc-inner li,
		.vc_om_a_button .vc_om-brd,
		a.more-link .more-link-brd,
		.vc_om-person .om-person-social a,
		.vc_om-click-icon-box .om-cib-icon-inner,
		.om_theme .vc_tta.vc_tta-style-classic.vc_tta-tabs .vc_tta-panels,
		.om_theme .vc_tta.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-heading,
		.om_theme .vc_tta.vc_tta-style-classic .vc_tta-panel .vc_tta-panel-body
		{border-color:'.$color.';border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15)}';

		echo '
		.vc_om-table-style-1 table td,
		.vc_om-table-style-1 table th,
		.vc_om-testimonials.vc_om-mode-list .om-item,
		{border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.075)}';
		
		echo '
		.om_theme .ompf-portfolio-categories li:not(:last-child) a:not(:hover),
		.om_theme .wpb_teaser_grid .categories_filter li:not(:last-child) a:not(:hover),
		.vc_om-pricing-table.vc_om-style-1 .vc_om-ptc:not(:last-child),
		.vc_om-person .om-person-social a:not(:last-child)
		{border-right-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.075)}';

		echo '
		.om_theme .ompf-portfolio-categories li:not(:first-child) a:not(:hover),
		.om_theme .wpb_teaser_grid .categories_filter li:not(:first-child) a:not(:hover),
		.vc_om-pricing-table.vc_om-style-1 .vc_om-ptc:not(:first-child),
		.vc_om-person .om-person-social a:not(:first-child)
		{border-left-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.075)}';
		
		echo '
		.vc_om_a_button.vc_om-style-not_colored .vc_om-title
		{box-shadow:-1px 0 0 0 rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15), 1px 0 0 0 rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15)}';		
		
		echo '
		.custom-gallery,
		.gallery-sliced .img-box
		{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.1)}';

		echo '
		.wpb_column.vc_column_delimiter-vline:after,
		.wpb_column.vc_column_delimiter-hline:after,
		.wpb_column.vc_column_delimiter-dot:after
		{background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15)}';		
		
		echo '
		.wpb_column.vc_column_delimiter-rarr:after
		{color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15)}';

		echo '
		.content blockquote,
		.content .blockquote,
		.content .vc_om-testimonials,
		.content .post-link-box a
		{
			background: rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.04);
		}';
		
		$side_color=get_option(OM_THEME_PREFIX . 'side_text_color');

		echo '
		.comment-meta,
		.comment-notes,
		.navigation-prev a,
		.navigation-next a,
		.post-meta,
		.content .post-link-box a,
		.blockquote-author,
		.ompf-portfolio-single-categories,
		.ompf-portfolio-single-categories a,
		.navigation-pages-inner > span.dots,
		.sidebar-widget .tweet-time a,
		.content .wp-caption-text,
		.comments-section .nocomments,
		.vc_om-testimonials .om-item-author,
		.vc_om-ptc-title-comment,
		.vc_om-ptc-price-suffix,
		.content .vc-om_chart-legend,
		.vc_om-person .om-person-job,
		.vc_om-person .om-person-social a,
		.sidebar-widget.widget_recent_entries .post-date
		{color:'.$side_color.'}';		

		echo '
			select
			{background-image: url(\'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="17" height="4"><polygon fill="'.$side_color.'" points="0,0 9,0, 5,4"/></svg>').'\');}';

		/**
		 * Footer
		 */

		$bg_color=get_option(OM_THEME_PREFIX . 'background_footer_color');
		
		echo '
		.footer
		{background-color:'.$bg_color.'}';
		
		$color=get_option(OM_THEME_PREFIX . 'footer_main_text_color');
		
		echo '
		.footer,
		.footer a
		{color:'.$color.'}';
		
		$rgb=om_hex2rgb($color);
		
		echo '
		.footer *,
		.footer input[type=text],
		.footer input[type=email],
		.footer input[type=tel],
		.footer input[type=password],
		.footer input[type=file],
		.footer textarea
		{border-color:'.$color.';border-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15)}';

		echo '
		.footer .testimonials-controls .prev,
		.footer .testimonials-controls .next
		{background-color:'.$color.';background-color:rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15)}';		
		
		echo '
		.footer .vc_om_a_button
		{box-shadow:inset 0 0 0 1px rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15)}';

		echo '
		.footer .vc_om_a_button.vc_om-style-not_colored .vc_om-title
		{box-shadow:-1px 0 0 0 rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15), 1px 0 0 0 rgba('.$rgb[0].','.$rgb[1].','.$rgb[2].',0.15)}';			

		$side_color=get_option(OM_THEME_PREFIX . 'footer_side_text_color');
		echo '
		.footer-widget .tweet-time a,
		.footer .blockquote-author,
		.footer .testimonial-author
		{color:'.$side_color.'}';

		echo '
			.footer select
			{background-image: url(\'data:image/svg+xml;base64,'.base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="17" height="4"><polygon fill="'.$side_color.'" points="0,0 9,0, 5,4"/></svg>').'\');}';


		$color=get_option(OM_THEME_PREFIX . 'footer_titles_color');

		echo '
		.footer-widget-title
		{color:'.$color.'}';
						
		/***/
		
		$out = ob_get_contents();
    ob_end_clean();

		$out=preg_replace('/\s*([\{\},;])\s*/','$1',$out);
		$out=str_replace(',{','{',$out);
		$out=trim($out);
		    
    return $out;
	}
	
}

if( !function_exists( 'om_custom_style_file_name' ) ) {
	
	function om_custom_style_file_path() {
		
		if ( is_multisite() ) {
			return '/style-custom-' . get_current_blog_id() . '.css';
		} else {
			return '/style-custom.css';
		}
		
	}
}

if( !function_exists( 'om_theme_custom_styling' ) ) {
	
	function om_theme_custom_styling() {

		add_action('wp_head','om_theme_custom_styling_fonts');
		// echo custom styling
		if( get_option( OM_THEME_PREFIX . 'use_inline_css' ) == 'true' || !file_exists(TEMPLATE_DIR . om_custom_style_file_path() ) ) {
			add_action('wp_head','om_theme_custom_styling_inline_css');
		} else {
			add_action('wp_enqueue_scripts', 'om_theme_custom_styling_css_file');
		}

	}
	//om_theme_custom_styling();
}
add_action('init', 'om_theme_custom_styling');

if( !function_exists( 'om_theme_custom_styling_fonts' ) ) {
	function om_theme_custom_styling_fonts() {
		// embed fonts
		$base_font=get_option(OM_THEME_PREFIX . 'base_font');
		$sec_font=get_option(OM_THEME_PREFIX . 'sec_font');
		$menu_font=get_option(OM_THEME_PREFIX . 'menu_font');
		if(isset($base_font['type']) && $base_font['type'] == 'external' && isset($base_font['external']['embed']))
			echo om_esc_ext_fonts($base_font['external']['embed']);
		if(isset($sec_font['type']) && $sec_font['type'] == 'external' && isset($sec_font['external']['embed']))
			echo om_esc_ext_fonts($sec_font['external']['embed']);
		if(isset($menu_font['type']) && $menu_font['type'] == 'external' && isset($menu_font['external']['embed']))
			echo om_esc_ext_fonts($menu_font['external']['embed']);

	}
}

if( !function_exists( 'om_theme_custom_styling_inline_css' ) ) {
	function om_theme_custom_styling_inline_css() {
		$css=om_theme_get_styling();
		echo '<style>' . om_esc_css($css) . '</style>';
	}
}
		
if( !function_exists( 'om_theme_custom_styling_css_file' ) ) {
	function om_theme_custom_styling_css_file() {
		$salt=get_option( OM_THEME_PREFIX . 'style-custom-salt' );
		if($salt != '')
			$salt='?rev='.$salt;
		wp_enqueue_style('style-custom', TEMPLATE_DIR_URI . om_custom_style_file_path() . $salt);
	}
}

if( !function_exists( 'om_theme_update_custom_style_file' ) ) {
	
	function om_theme_update_custom_style_file() {
		
		$f=@fopen(TEMPLATE_DIR . om_custom_style_file_path(), 'w+');
		if($f) {
			$css=om_theme_get_styling();
			fwrite($f,$css);
			fclose($f);
		}
		
		update_option( OM_THEME_PREFIX . 'style-custom-salt', rand(10000, 99999) ); 
		
	}
	add_action('om_options_updated','om_theme_update_custom_style_file');
}


if( !function_exists( 'om_body_styling_classes' ) ) {
	
	function om_body_styling_classes($classes) {
	
		if( ( $layout = get_option(OM_THEME_PREFIX . 'overall_layout') ) ) {
			om_body_add_class('layout-'.$layout);
		} else {
			om_body_add_class('layout-wide');
		}
		
		if(get_option(OM_THEME_PREFIX.'sidebar_position')=='left') {
			om_body_add_class('flip-sidebar');
		}
		
		om_body_add_class('om-animation-enabled');
		
		if(get_option(OM_THEME_PREFIX.'no_animation_on_touch')=='true') {
			om_body_add_class('om-no-animation-on-touch');
		}

		if(get_option(OM_THEME_PREFIX . 'menu_highlight_active') == 'true') {
			om_body_add_class('primary-menu-highlight-active');
		}	
		
		om_body_add_class('menu-position-'.get_option(OM_THEME_PREFIX . 'menu_position'));

		if(get_option(OM_THEME_PREFIX . 'uncovering_footer') == 'true') {
			om_body_add_class('uncovering-footer');
		}	
			
	}
	add_action('get_header','om_body_styling_classes');
	
}