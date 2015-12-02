<?php

/*************************************************************************************
 *	Audio Player
 *************************************************************************************/

if ( !function_exists( 'om_audio_player' ) ) {
	function om_audio_player($post_id, $args=array()) {
		echo om_get_audio_player($post_id, $args);
  }
}

if ( !function_exists( 'om_get_audio_player' ) ) {
	function om_get_audio_player($post_id, $args=array()) {
		
		$out='';
		
		$embed_code=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'audio_embed', true);
		if(trim($embed_code)) {
	
			$out.= '<div class="audio-block audio-block-embed">';
			
			if(stripos($embed_code, 'http://') === 0 || stripos($embed_code, 'https://') === 0) {
				global $wp_embed;
				$out.= '<div class="w-responsive-embed">'.$wp_embed->run_shortcode('[embed]'.esc_url($embed_code).'[/embed]').'</div>';
			} else {
				$out.= '<div class="w-responsive-embed">'.om_esc_embed($embed_code).'</div>';
			}
			
			$out.= '</div>';
			
		} else {
			
			$attr=array();
					
			$src_fields=array(
				'src' => OM_THEME_SHORT_PREFIX.'audio_src',
				'mp3' => OM_THEME_SHORT_PREFIX.'audio_mp3',
				'm4a' => OM_THEME_SHORT_PREFIX.'audio_m4a',
				'ogg' => OM_THEME_SHORT_PREFIX.'audio_ogg',
				'wav' => OM_THEME_SHORT_PREFIX.'audio_wav',
				'wma' => OM_THEME_SHORT_PREFIX.'audio_wma',
			);
			foreach($src_fields as $k=>$v) {
				$meta=get_post_meta($post_id, $v, true);
				if($meta) {
					$attr[$k]=$meta;
				}
			}
			
			if(!empty($attr)) {

				$out.= '<div class="audio-block audio-block-selfhosted">';
	
				$shortcode='[audio';
				foreach($attr as $k=>$v) {
					$shortcode.=' '.$k.'="'.esc_attr($v).'"';
				}
				$shortcode.=']';
				
				$out.= do_shortcode($shortcode);
				
				$out.= '</div>';
			}
			
		}
		
		return $out;
	}
}

/*************************************************************************************
 *	Video Player
 *************************************************************************************/

if ( !function_exists( 'om_video_player' ) ) {
	function om_video_player($post_id, $args=array()) {

		echo om_get_video_player($post_id, $args);

  }
}

if ( !function_exists( 'om_get_video_player' ) ) {
	function om_get_video_player($post_id, $args=array()) {

		$out='';

		$embed_code=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'video_embed', true);
		if(trim($embed_code)) {
	
			$out.= '<div class="video-block video-block-embed">';
			
			if(stripos($embed_code, 'http://') === 0 || stripos($embed_code, 'https://') === 0) {
				global $wp_embed;
				$out.= '<div class="responsive-embed">'.$wp_embed->run_shortcode('[embed]'.esc_url($embed_code).'[/embed]').'</div>';
			} else {
				$out.= '<div class="responsive-embed">'.om_esc_embed($embed_code).'</div>';
			}
			
			$out.= '</div>';
			
		} else {
			
			$attr=array();
					
			$src_fields=array(
				'src' => OM_THEME_SHORT_PREFIX.'video_src',
				'mp4' => OM_THEME_SHORT_PREFIX.'video_mp4',
				'm4v' => OM_THEME_SHORT_PREFIX.'video_m4v',
				'webm' => OM_THEME_SHORT_PREFIX.'video_webm',
				'ogv' => OM_THEME_SHORT_PREFIX.'video_ogv',
				'wmv' => OM_THEME_SHORT_PREFIX.'video_wmv',
				'flv' => OM_THEME_SHORT_PREFIX.'video_flv',
			);
			foreach($src_fields as $k=>$v) {
				$meta=get_post_meta($post_id, $v, true);
				if($meta) {
					$attr[$k]=$meta;
				}
			}
			
			if(!empty($attr)) {
				
				$out.= '<div class="video-block video-block-selfhosted">';
				
				$poster=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'video_poster', true);
				if($poster) {
					$attr['poster']=$poster;
				}
				
				//$attr['width']=100;
				//$attr['height']=100;
				
				$shortcode='[video';
				foreach($attr as $k=>$v) {
					$shortcode.=' '.$k.'="'.esc_attr($v).'"';
				}
				$shortcode.=']';
				
				add_filter('wp_video_shortcode', 'om_set_mediaelementplayer_video_100p');
				$out.= do_shortcode($shortcode);
				remove_filter('wp_video_shortcode', 'om_set_mediaelementplayer_video_100p');

				$out.= '</div>';
			}

		}
		
		return $out;
	
  }
}


/**
 * Making navie video player responsive
 */

if(!function_exists('om_set_mediaelementplayer_video_100p')) {
	function om_set_mediaelementplayer_video_100p($html) {
		
		if(preg_match('/width="([0-9]+)".*height="([0-9]+)"/',$html,$m) && $m[1]) {
			$html='<div class="om-wp-video-wrapper" style="padding-bottom:'.($m[2]/$m[1]*100).'%;" >'.$html.'</div>';
		}

		return $html;
	}
}

/*************************************************************************************
 * Archive Page Title
 *************************************************************************************/

if ( !function_exists( 'om_get_archive_page_title' ) ) { 
	function om_get_archive_page_title() {
		
		$out='';
		
		if (is_category()) { 
			$out = single_cat_title('',false);
		} elseif( is_tag() ) {
			$out = single_tag_title('',false);
		} elseif (is_day()) { 
			$out = __('Archive for', 'om_theme'); $out .= ' '.get_the_time('F jS, Y'); 
		} elseif (is_month()) { 
			$out = __('Archive for', 'om_theme'); $out .= ' '.get_the_time('F, Y'); 
		} elseif (is_year()) { 
			$out = __('Archive for', 'om_theme'); $out .= ' '.get_the_time('Y');
		} elseif (is_author()) { 
			if(get_query_var('author_name')) {
				$curauth = get_user_by('slug', get_query_var('author_name'));
			} else {
				$curauth = get_userdata(get_query_var('author'));
			}
			$out = __('All posts by', 'om_theme'); $out .= ' '.$curauth->nickname;
		} elseif( is_tax() ) {
			$out = single_term_title('',false);
		} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			$out = __('Blog Archives', 'om_theme');
		} else { 
			$blog = get_post(get_option('page_for_posts'));
			$out = $blog->post_title;
		}
	 	
	 	return $out;
	}
}

/*************************************************************************************
 * Wrap paginate_links
 *************************************************************************************/

if ( !function_exists( 'om_wrap_paginate_links' ) ) {  
	function om_wrap_paginate_links($links) {
	
		if(!is_array($links))
			return '';
	
		$out='';
		$out.= '<div class="navigation-pages"><div class="navigation-pages-inner">';
		$out.= preg_replace('#(<a[^>]*>)(.*?)(</a>)#','$1<span>$2</span>$3',implode('',$links));
		$out.= '</div><div class="clear"></div></div>';
	
		return $out;
	}
}

if ( !function_exists( 'om_paginate_links_args' ) ) {  
	function om_paginate_links_args($query=false) {

		if(!$query) {
			global $wp_query;
			$query=$wp_query;
		}

		return
			array(
				'base' => str_replace( '999999999', '%#%', esc_url( get_pagenum_link( '999999999' ) ) ),
				'format' => '?paged=%#%',
				'current' => $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1,
				'total' => $wp_query->max_num_pages,
				'type' => 'array',
				'prev_text' => '',
				'next_text' => '',
			);

	}
}

if ( !function_exists( 'om_wp_link_pages' ) ) {  
	function om_wp_link_pages() {
		
		global $page;
		
		$links=wp_link_pages(array(
			'before' => '<div class="navigation-pages wp-link-pages"><div class="navigation-pages-inner">',
			'after' => '</div><div class="clear"></div></div>',
			'link_before' => '<span>', 
			'link_after' => '</span>', 
			'next_or_number' => 'number',
			'echo' => 0,
			'separator' => '',
		));
		
		if($page) {
			$links=str_replace('<span>'.$page.'</span>','<span class="current">'.$page.'</span>',$links);
		}
		
		echo om_esc_wpcf($links);
	}
}


/*************************************************************************************
 * Prev/next pagination links
 *************************************************************************************/

function om_prev_next_nav ($nav_prev=false, $nav_next=false) {
	
	return '
		<div class="navigation-prev-next">
			'. ($nav_prev ? '<div class="navigation-prev">'. $nav_prev .'</div>' : '') .'
			'. ($nav_next ? '<div class="navigation-next">'. $nav_next .'</div>' : '') .'
			<div class="clear"></div>
		</div>
	';
	
}

/*************************************************************************************
 * Body classes managment
 *************************************************************************************/

$_OM_BODY_CLASSES=array();

if( !function_exists( 'om_body_classes' ) ) {
	
	function om_body_classes($classes) {
		
		global $_OM_BODY_CLASSES;
		
		$classes_new=array();
	
		foreach($classes as $v) {
			if( ! ( isset($_OM_BODY_CLASSES[$v]) && $_OM_BODY_CLASSES[$v]===false ) )
				$classes_new[]=$v; //add class
				
			if(isset($_OM_BODY_CLASSES[$v]) && $_OM_BODY_CLASSES[$v])
				unset($_OM_BODY_CLASSES[$v]); //remove from additional list
		}
		
		foreach($_OM_BODY_CLASSES as $k => $v) {
			if($v)
				$classes_new[]=$k;
		}
	
		return $classes_new;
	}
	add_filter('body_class','om_body_classes');
	
}

if( !function_exists( 'om_body_add_class' ) ) {
	function om_body_add_class($class) {
		
		global $_OM_BODY_CLASSES;
		$_OM_BODY_CLASSES[$class]=true;
		
	}
}

if( !function_exists( 'om_body_remove_class' ) ) {
	function om_body_remove_class($class) {
		
		global $_OM_BODY_CLASSES;
		$_OM_BODY_CLASSES[$class]=false;
		
	}
}

/*************************************************************************************
 * Page CSS managment
 *************************************************************************************/

$_OM_PAGE_CSS='';

if( !function_exists( 'om_page_css' ) ) {
	
	function om_page_css($classes) {
		global $_OM_PAGE_CSS;

		if($_OM_PAGE_CSS != '') {
			echo '<style>'.om_esc_css($_OM_PAGE_CSS).'</style>';
		}		
	}
	add_action('wp_head','om_page_css');
	
}

if( !function_exists( 'om_page_add_css' ) ) {
	function om_page_add_css($css) {
		
		global $_OM_PAGE_CSS;
		$_OM_PAGE_CSS.=$css;
		
	}
}

/*************************************************************************************
 * Header setup
 *************************************************************************************/
 
if( !function_exists( 'om_custom_header_setup' ) ) {
	function om_custom_header_setup($post_id) {

		if($post_id) {

			$text_color=false;
			
			$header_bg=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_bg', true);
			
			switch($header_bg) {
				
				case 'color':
				
					$color=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_bg_color', true);
					if($color) {
						om_body_add_class('custom-header-bg-'.$header_bg);

						$css='background:'.$color;

						om_page_add_css('.header-mid{'.$css.'}');
					}
					
					if( get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_menu_color', true) ) {
						$text_color = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_menu_color_color', true);
					}
					
					if( get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_logo_image', true) ) {
						add_filter('om_set_custom_header_logo', '__return_true');
					}
					
				break;
				
				case 'image':
				
					$img=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_bg_image', true);
					if($img) {
						om_body_add_class('custom-header-bg-'.$header_bg);

						$css='background-image:url('.$img.');';

						$pos=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_bg_image_pos', true);
						if($pos == 'repeat')
							$css.='background-repeat:repeat;';
						elseif($pos == 'cover')
							$css.='background-size:cover;';
										
						om_page_add_css('.header-mid{'.$css.'}');
					}
					
					if( get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_menu_color', true) ) {
						$text_color = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_menu_color_color', true);
					}
					
					if( get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_logo_image', true) ) {
						add_filter('om_set_custom_header_logo', '__return_true');
					}
					
				break;
				
				case 'transparent':
				
					global $page_slider;
					if($page_slider && isset($page_slider['layout']) && $page_slider['layout'] != 'before_header') {
						if($page_slider['layout'] == 'full') {
							om_body_add_class('custom-header-bg-'.$header_bg);
							om_body_add_class('custom-header-bg-merge-slider');
							
							if( get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_menu_color', true) && $text_color = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_menu_color_color', true)) {
								// $text_color is set
							}
							if( get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_logo_image', true) ) {
								add_filter('om_set_custom_header_logo', '__return_true');
							}
						}
					} else {
						$custom_settings=true;	
						$post_title_layout=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'page_title', true);
						if(!$post_title_layout) {
							$post_title_layout=get_option(OM_THEME_PREFIX . 'default_page_title');
							$custom_settings=false;
						}
						if($post_title_layout != 'standard' && $post_title_layout != 'hide') {
							om_body_add_class('custom-header-bg-'.$header_bg);
							om_body_add_class('custom-header-bg-merge-title');
							
							
							if( get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_menu_color', true) && $text_color = get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_menu_color_color', true)) {
								// $text_color is set
							} else {
								if($custom_settings) {
									$text_color=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_text_color', true);
								} else {
									$text_color=get_option(OM_THEME_PREFIX . 'default_title_text_color');
								}
							}

							if( get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_logo_image', true) ) {
								add_filter('om_set_custom_header_logo', '__return_true');
							}
						}
					}
				
				break;
				
			}
			
			if($text_color) {
				if(strcasecmp($text_color, 'theme') == 0  ) {
					$text_color=get_option(OM_THEME_PREFIX . 'hightlight_color');
				}
				om_page_add_css('
					.header-logo .logo-text a,
					.header-logo-menu-wrapper:not(.menu-stuck) .logo-text a,
					.menu-sticky-node:not(.menu-stuck) .header-search .search-popup-link:not(.active),
					.menu-sticky-node:not(.menu-stuck) .primary-menu>li>a
					{color:'.$text_color.'}');
			}

		}
				
	}
}


/*************************************************************************************
 * Sidebar setup
 *************************************************************************************/

if( !function_exists( 'om_custom_sidebar_setup' ) ) {
	function om_custom_sidebar_setup($post_id) {

		if($post_id) {

			if(
				( get_post_type($post_id) == 'portfolio' && is_single($post_id) ) ||
				in_array(get_post_meta( $post_id, '_wp_page_template', true ), array('template-portfolio.php','template-100width.php','template-content-only-100width.php','template-sitemap.php'))
				//is_tax('portfolio-type')
			) {
				$sidebar_type='hide';
			} else {
				$sidebar_type=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'sidebar_show', true);
			}
			
			$sidebar_pos=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'sidebar_custom_pos', true);

		} else {

			if( is_404() || is_search() || is_tax('portfolio-type') )
				$sidebar_type='hide';
			else
				$sidebar_type='';
			$sidebar_pos='';
			
		}

		if($sidebar_type=='hide')
			om_body_add_class('sidebar-hidden');
		else
			om_body_add_class('sidebar-display');

		if($sidebar_pos == 'left')
			om_body_add_class('flip-sidebar');
		elseif($sidebar_pos == 'right')
			om_body_remove_class('flip-sidebar');			
				
	}
}

/*************************************************************************************
 * Adjacent Custom Post
 *************************************************************************************/

function om_get_previous_post($in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category')  && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		return get_previous_post($in_same_cat, $excluded_categories);
	else
		return om_get_adjacent_post($in_same_cat, $excluded_categories, true, $taxonomy, $orderby);
}

function om_get_next_post($in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		return get_next_post($in_same_cat, $excluded_categories);
	else
		return om_get_adjacent_post($in_same_cat, $excluded_categories, false, $taxonomy, $orderby);
}

function om_get_adjacent_post( $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy='category', $orderby='post_date' ) {
	global $wpdb;

	if ( ! $post = get_post() )
		return null;

	$current_post_order_val = $post->$orderby;
	if($orderby == 'menu_order' && $current_post_order_val == 0) {
		$orderby = 'post_date';
		$current_post_order_val = $post->$orderby;
	}

	$join = '';
	$posts_in_ex_cats_sql = '';
	if ( $in_same_cat || ! empty( $excluded_categories ) ) {
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

		if ( $in_same_cat ) {
			if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) )
				return '';
			$cat_array = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
			if ( ! $cat_array || is_wp_error( $cat_array ) )
				return '';
			$join .= " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
		}

		$posts_in_ex_cats_sql = "AND tt.taxonomy = '".$taxonomy."'";
		if ( ! empty( $excluded_categories ) ) {
			if ( ! is_array( $excluded_categories ) ) {
				// back-compat, $excluded_categories used to be IDs separated by " and "
				if ( strpos( $excluded_categories, ' and ' ) !== false ) {
					$excluded_categories = explode( ' and ', $excluded_categories );
				} else {
					$excluded_categories = explode( ',', $excluded_categories );
				}
			}

			$excluded_categories = array_map( 'intval', $excluded_categories );

			if ( ! empty( $cat_array ) ) {
				$excluded_categories = array_diff($excluded_categories, $cat_array);
				$posts_in_ex_cats_sql = '';
			}

			if ( !empty($excluded_categories) ) {
				$posts_in_ex_cats_sql = " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.".$orderby." $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_post_order_val, $post->post_type), $in_same_cat, $excluded_categories );
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.".$orderby." $order LIMIT 1" );

	$query = "SELECT p.id FROM $wpdb->posts AS p $join $where $sort";
	$query_key = 'adjacent_post_' . md5($query);
	$result = wp_cache_get($query_key, 'counts');
	if ( false !== $result ) {
		if ( $result )
			$result = get_post( $result );
		return $result;
	}

	$result = $wpdb->get_var( $query );
	if ( null === $result )
		$result = '';

	wp_cache_set($query_key, $result, 'counts');

	if ( $result )
		$result = get_post( $result );

	return $result;
}

/*************************************************************************************
 * Adjacent Custom Post Link
 *************************************************************************************/

function om_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		previous_post_link($format, $link, $in_same_cat, $excluded_categories);
	else
		om_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true, $taxonomy, $orderby);
}

function om_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		next_post_link($format, $link, $in_same_cat, $excluded_categories);
	else
		om_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false, $taxonomy, $orderby);
}

function om_adjacent_post_link( $format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy='category', $orderby='post_date' ) {
	if ( $previous && is_attachment() )
		$post = get_post( get_post()->post_parent );
	else
		$post = om_get_adjacent_post( $in_same_cat, $excluded_categories, $previous, $taxonomy, $orderby );

	if ( ! $post ) {
		$output = '';
	} else {
		$title = $post->post_title;

		if ( empty( $post->post_title ) )
			$title = $previous ? __( 'Previous Post', 'om_theme') : __( 'Next Post', 'om_theme' );

		$title = apply_filters( 'the_title', $title, $post->ID );
		$date = mysql2date( get_option( 'date_format' ), $post->post_date );
		$rel = $previous ? 'prev' : 'next';

		$string = '<a href="' . get_permalink( $post ) . '" rel="'.$rel.'">';
		$inlink = str_replace( '%title', $title, $link );
		$inlink = str_replace( '%date', $date, $inlink );
		$inlink = $string . $inlink . '</a>';

		$output = str_replace( '%link', $inlink, $format );
	}

	$adjacent = $previous ? 'previous' : 'next';

	echo apply_filters( "{$adjacent}_post_link", $output, $format, $link, $post );
}

/*************************************************************************************
 * Slider
 *************************************************************************************/

if( !function_exists( 'om_get_page_slider' ) ) {  
	function om_get_page_slider($post_id) {
		
		if(!$post_id)
			return false;
		
		$ret=array(
			'type'=>'',
			'id'=>'',
			'layout'=>'',
		);
		
		$slider_id=get_post_meta( $post_id, OM_THEME_SHORT_PREFIX.'slider_id', true );
		if($slider_id == '')
			return false;
		
		$ret['layout']=get_post_meta( $post_id, OM_THEME_SHORT_PREFIX.'slider_layout', true );
		if(!$ret['layout']) {
			$ret['layout']='boxed';
		}
		
		// revslider
		if(substr($slider_id,0,strlen('revslider_')) == 'revslider_') {
			if(!class_exists('RevSlider'))
				return false;
			
			$ret['type']='revslider';
			$ret['id']=substr($slider_id,strlen('revslider_'));
			return $ret;
		}
		
		// layer slider
		if(substr($slider_id,0,strlen('lslider_')) == 'lslider_') {
			if(!isset($GLOBALS['lsPluginVersion']) && !defined('LS_PLUGIN_VERSION'))
				return false;
			
			$ret['type']='lslider';
			$ret['id']=substr($slider_id,strlen('lslider_'));
			return $ret;
		}
		
		
		return false;
		
	}
}

if( !function_exists( 'om_display_page_slider' ) ) {  
	function om_display_page_slider($slider, $echo = true) {
		
		if($slider && is_array($slider) && isset($slider['type']) && isset($slider['id'])) {
			
			if(!$echo)
				ob_start();
			
			switch($slider['type']) {
				
				case 'lslider':
					om_layerslider($slider['id']);
				break;

				case 'revslider':
					om_putRevSlider($slider['id']);
				break;
								
			}
			
			if(!$echo) {
				$buffer=ob_get_clean();
				return $buffer;
			}
			
		}
		
	}
}

/*************************************************************************************
 * Admin Browse Button
 *************************************************************************************/

if( !function_exists( 'om_enqueue_admin_browse_button' ) ) {  
	function om_enqueue_admin_browse_button() {

		wp_register_script('om-admin-browse-button', TEMPLATE_DIR_URI . '/admin/js/browse-button.js', array('jquery'));
		wp_enqueue_script('om-admin-browse-button');
		if(function_exists( 'wp_enqueue_media' ))
			wp_enqueue_media();
			
	}
}

/*************************************************************************************
 * Background Position Style
 *************************************************************************************/

if( !function_exists( 'om_get_bg_img_pos_options()' ) ) {  
	function om_get_bg_img_pos_options() {
		return array(
    	'repeat' => 'Repeat image',
    	'repeat_x_top' => 'Repeat-x image top',
    	'repeat_x_center' => 'Repeat-x image center',
    	'repeat_x_bottom' => 'Repeat-x image bottom',
    	'repeat_y_left' => 'Repeat-y image left',
    	'repeat_y_center' => 'Repeat-y image center',
    	'repeat_y_right' => 'Repeat-y image right',
    	'cover' => 'Cover',
    	'no_repeat_center' => 'No-Repeat Center',
    	'no_repeat_left_top' => 'No-Repeat Left Top',
    	'no_repeat_top' => 'No-Repeat Top',
    	'no_repeat_right_top' => 'No-Repeat Right Top',
    	'no_repeat_right' => 'No-Repeat Right',
    	'no_repeat_right_bottom' => 'No-Repeat Right Bottom',
    	'no_repeat_bottom' => 'No-Repeat Bottom',
    	'no_repeat_left_bottom' => 'No-Repeat Left Bottom',
    	'no_repeat_left' => 'No-Repeat Left',
    );
 }
}

if( !function_exists( 'om_bg_img_pos_style' ) ) {  
	function om_bg_img_pos_style($bg_pos) {

		$style=array();

		switch($bg_pos) {
			case 'cover':
				$style[]='background-position:center center';
				$style[]='background-size: cover';
			break;
			case 'repeat':
				$style[]='background-repeat:repeat';
			break;
			case 'repeat_x_top':
				$style[]='background-repeat:repeat-x';
				$style[]='background-position:left top';
			break;			
			case 'repeat_x_center':
				$style[]='background-repeat:repeat-x';
				$style[]='background-position:left center';
			break;			
			case 'repeat_x_bottom':
				$style[]='background-repeat:repeat-x';
				$style[]='background-position:left bottom';
			break;
			case 'repeat_y_left':
				$style[]='background-repeat:repeat-y';
				$style[]='background-position:left top';
			break;			
			case 'repeat_y_center':
				$style[]='background-repeat:repeat-y';
				$style[]='background-position:center top';
			break;			
			case 'repeat_y_right':
				$style[]='background-repeat:repeat-y';
				$style[]='background-position:right top';
			break;
			case 'no_repeat_center':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:center center';
			break;
			case 'no_repeat_left_top':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:left top';
			break;
			case 'no_repeat_top':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:center top';
			break;
			case 'no_repeat_right_top':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:right top';
			break;
			case 'no_repeat_right':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:right center';
			break;
			case 'no_repeat_right_bottom':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:right bottom';
			break;
			case 'no_repeat_bottom':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:center bottom';
			break;
			case 'no_repeat_left_bottom':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:left bottom';
			break;			
			case 'no_repeat_left':
				$style[]='background-repeat:no-repeat';
				$style[]='background-position:left center';
			break;
		}
		
		return $style;
			
	}
}

/*************************************************************************************
 * Add helper classes to WP Menu
 *************************************************************************************/

function om_nav_menu_has_children_class ($items) {
	
	foreach($items as $item) {
		if (om_nav_menu_has_sub($item->ID, $items)) {
			$item->classes[] = 'menu-item-has-children';
		}
	}
	return $items;    
}

function om_nav_menu_has_sub ($menu_item_id, &$items) {
  foreach ($items as $item) {
    if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {
      return true;
    }
  }
  return false;
}
if( version_compare($wp_version, '3.7.0', '<') ) {
	add_filter('wp_nav_menu_objects', 'om_nav_menu_has_children_class');	
}

/*************************************************************************************
 * HTTP to local address // check if given URL could be converted to local address
 *************************************************************************************/

function om_http2local ($url) {

	if($_SERVER['DOCUMENT_ROOT']) {
		if(stripos($url, 'http://'.$_SERVER['HTTP_HOST']) === 0) {
			$url_=$_SERVER['DOCUMENT_ROOT'].substr($url,strlen('http://'.$_SERVER['HTTP_HOST']));
			if(file_exists($url_))
				$url=$url_;
		} elseif(stripos($url, 'https://'.$_SERVER['HTTP_HOST']) === 0) {
			$url_=$_SERVER['DOCUMENT_ROOT'].substr($url,strlen('https://'.$_SERVER['HTTP_HOST']));
			if(file_exists($url_))
				$url=$url_;
		} elseif(substr($url,0,1) == '/') {
			$url_=$_SERVER['DOCUMENT_ROOT'].$url;
			if(file_exists($url_))
				$url=$url_;
		}
	}
	
	return $url;

}

/*************************************************************************************
 * Logo
 *************************************************************************************/

if( !function_exists( 'om_get_logo' ) ) {
	function om_get_logo() {

		$min_line_height=35;
					
		$ret=array('logo_type' => 'none');

		$logo_type=get_option(OM_THEME_PREFIX . 'site_logo_type');
		
		if($logo_type == 'image') {

			
			$logo_image=esc_url(get_option(OM_THEME_PREFIX . 'site_logo_image'));
			$logo_image_2x=esc_url(get_option(OM_THEME_PREFIX . 'site_logo_image_2x'));
			
			if(!$logo_image)
				return $ret;
				
			$ret['logo_type']=$logo_type;
			$ret['href']=home_url();

			$logo_image_atts=getimagesize(om_http2local($logo_image));
			if($logo_image_atts) {
				$ret['imagesize']=$logo_image_atts;
				$ret['line_height']=$logo_image_atts[1];
			} else {
				$logo_image_atts[3]='style="max-height:'.$min_line_height.'px"';
			}

			$logo_alt=esc_attr( get_bloginfo( 'name' ) );

			if($logo_image_2x) {
				$ret['image_block'] =
					'<img class="non-retina" src="'.esc_attr($logo_image).'" alt="'.$logo_alt.'" '.($logo_image_atts[3]).' />'.
					'<img class="only-retina" src="'.esc_attr($logo_image_2x).'" alt="'.$logo_alt.'" '.($logo_image_atts[3]).' />';
			} else {
				$ret['image_block'] = '<img src="'.esc_attr($logo_image).'" alt="'.$logo_alt.'" '.($logo_image_atts[3]).' />';
			}
			
			// if custom logo set on the page
			if( apply_filters('om_set_custom_header_logo', false) ) {
				$post_id=get_the_ID();
				if($post_id) {
					$custom_logo=esc_url(get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_logo_image_src', true));
					$custom_logo_2x=esc_url(get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'header_custom_logo_image_src_2x', true));
					if($custom_logo) {
						$custom_logo_block='';
						
						$logo_image_atts=getimagesize(om_http2local($custom_logo));
						if($logo_image_atts) {
							$ret['imagesize']=$logo_image_atts;
							$ret['line_height']=$logo_image_atts[1];
						} else {
							$logo_image_atts[3]='style="max-height:'.$min_line_height.'px"';
						}
						
						if($custom_logo_2x) {
							$custom_logo_block =
								'<img class="non-retina" src="'.esc_attr($custom_logo).'" alt="'.$logo_alt.'" '.($logo_image_atts[3]).' />'.
								'<img class="only-retina" src="'.esc_attr($custom_logo_2x).'" alt="'.$logo_alt.'" '.($logo_image_atts[3]).' />';
						} else {
							$custom_logo_block = '<img src="'.esc_attr($custom_logo).'" alt="'.$logo_alt.'" '.($logo_image_atts[3]).' />';
						}
						
						if( get_option(OM_THEME_PREFIX . 'menu_position') == 'top_fixed' ) {
							$ret['image_block']='<span class="logo-set-default">'.$custom_logo_block.'</span><span class="logo-set-fixed-menu">'.$ret['image_block'].'</span>';
						} else {
							$ret['image_block']=$custom_logo_block;
						}
					}
				}
			} 	
			
		} elseif($logo_type == 'text') {
			
			$text=get_option(OM_THEME_PREFIX . 'site_logo_text');
			
			if($text == '' || $text === false)
				return $ret;
			
			$ret['logo_type']=$logo_type;
			$ret['text_block'] = $text;
			$ret['href']=home_url();
			
		}

		if(!isset($ret['line_height']))
			$ret['line_height']=$min_line_height;
		elseif($ret['line_height'] < $min_line_height) {
			$ret['line_height']=$min_line_height;
		}

		return $ret;
	}
}

/*************************************************************************************
 *	Excerpt Length
 *************************************************************************************/

if( !function_exists( 'om_excerpt_length' ) ) {
	function om_excerpt_length($length) {
		return 25; 
	}
	add_filter('excerpt_length', 'om_excerpt_length');
}

if( !function_exists( 'om_more_link_tpl' ) ) {
	function om_more_link_tpl( $atts ) {
		$atts = shortcode_atts( array(
			'href' => '',
			'class' => '',
			'attr' => '',
		), $atts );
		
		return '<a href="'. $atts['href'] . '" class="more-link post-excerpt-readmore'.($atts['class'] ? ' '.$atts['class'] : '').'"'.($atts['attr'] ? ' '.$atts['attr'] : '').'><span class="more-link-inner">'.__('Read more','om_theme').'</span><span class="more-link-brd"></span></a>';
	}
}

if( !function_exists( 'om_blog_excerpt_length' ) ) {
	$_OM_BLOG_EXCERPT_LENGTH=intval(get_option(OM_THEME_PREFIX . 'blog_excerpt_length'));
	if(!$_OM_BLOG_EXCERPT_LENGTH)
		$_OM_BLOG_EXCERPT_LENGTH=30;
	function om_blog_excerpt_length($length) {
		global $_OM_BLOG_EXCERPT_LENGTH;
		return $_OM_BLOG_EXCERPT_LENGTH; 
	}
}

if( !function_exists( 'om_excerpt_more' ) ) {
	function om_excerpt_more( $more ) {
		global $post;
		return '&hellip;<p>'.om_more_link_tpl(array('href' => get_permalink($post->ID))).'</p>';
	}
	add_filter('excerpt_more', 'om_excerpt_more');
}

if( !function_exists( 'om_the_content_more_link' ) ) {
	function om_the_content_more_link( $more ) {
		global $post;
		return '<p>'.om_more_link_tpl(array('href' => get_permalink())).'</p>';
	}
	add_filter('the_content_more_link', 'om_the_content_more_link');
}

if( !function_exists( 'om_blog_excerpt_more' ) ) {
	function om_blog_excerpt_more( $more ) {
		global $post;
		return '&hellip;<p>'.om_more_link_tpl(array('href' => get_permalink($post->ID))).'</p>';
	}
}

function om_custom_excerpt_more($excerpt, $return=false) {
	global $post;
	
	$more='<p>'.om_more_link_tpl(array('href' => get_permalink($post->ID))).'</p>';
	
	$excerpt = $excerpt.$more;
	
	if($return)
		return $excerpt;
	else
		echo om_esc_wpcf($excerpt);
}

/*************************************************************************************
 * LayerSlider
 *************************************************************************************/
/*
if(!function_exists('om_layerslider_dequeue')) {
	function om_layerslider_dequeue() {

		// deregister libraries and reregister with 'in_footer' attribute. Enqueue performs on demand
		$handles=array(
			'layerslider',
			'greensock',
			'layerslider-transitions',
		);
		
		foreach($handles as $handle) {
			if( isset($GLOBALS['wp_scripts']->registered[$handle]) ) {
				$atts=$GLOBALS['wp_scripts']->registered[$handle];
				wp_dequeue_script($handle);
				wp_register_script($handle, $atts->src, $atts->deps, $atts->ver, true );
			}
		}
	}
}
add_action('wp_enqueue_scripts', 'om_layerslider_dequeue');

if(!function_exists('om_layerslider_enqueue')) {
	function om_layerslider_enqueue() {
		$handles=array(
			'layerslider',
			'greensock',
			'layerslider-transitions',
		);
		
		foreach($handles as $handle) {
			if( isset($GLOBALS['wp_scripts']->registered[$handle]) ) {
				wp_enqueue_script($handle);
			}
		}
	}
}

remove_shortcode('layerslider');
if(!function_exists('om_sc_layerslider')) {
	function om_sc_layerslider($atts) {
		if(class_exists('LS_Shortcode')) {
			echo LS_Shortcode::handleShortcode($atts);
		} elseif(function_exists('layerslider_init')) {
			om_layerslider_enqueue();
			return layerslider_init($atts);
		} else {
			return false;
		}
	}
}
add_shortcode('layerslider' , 'om_sc_layerslider');
*/

if(!function_exists('om_layerslider')) {
	function om_layerslider($id = 0, $page = '') {
		
		global $wpdb;
		
		$exists = $wpdb->get_row("
			SELECT EXISTS(
				SELECT * FROM ".$wpdb->prefix."layerslider
				WHERE id = ".(int)$id." AND flag_hidden = '0'	AND flag_deleted = '0'
			)" , ARRAY_N);
		if($exists[0] && function_exists('layerslider')) {
			//om_layerslider_enqueue();
			layerslider($id, $page);
		}
	}
	
}

if(isset($GLOBALS['lsAutoUpdateBox'])) {
	add_action('layerslider_ready', 'om_layerslider_ready');
	function om_layerslider_ready() {
		// Disable auto-updates
		$GLOBALS['lsAutoUpdateBox'] = false;
	}
}

if(defined('LS_PLUGIN_BASE')) {
	remove_action('after_plugin_row_'.LS_PLUGIN_BASE, 'layerslider_plugins_purchase_notice');
}

/*************************************************************************************
 * Revolution Slider
 *************************************************************************************/

if(!function_exists('om_putRevSlider')) {
	function om_putRevSlider($data,$putIn = "") {
		if(function_exists('putRevSlider')) {
			putRevSlider($data,$putIn);
		}
	}
}

function om_rev_slider_remove_notice($theme) {

	update_option('revslider-valid-notice', 'false');
	
}
add_action('after_switch_theme', 'om_rev_slider_remove_notice'); 

if(function_exists( 'set_revslider_as_theme' )){
	add_action( 'init', 'om_set_revslider_as_theme' );
	function om_set_revslider_as_theme() {
		set_revslider_as_theme();
	}
}

/*************************************************************************************
 * Escaping
 *************************************************************************************/
 
if(!function_exists('om_esc_wpcf')) {
	function om_esc_wpcf($string, $force=false) {
		// escape strings, which are returned by WordPress core functions
		// by default, we don't need to escape it
		
		return ( $force ? wp_kses_post( $string ) : $string );
	}
}

if(!function_exists('om_esc_sg')) {
	function om_esc_sg($string, $force=false) {
		// escape code, which generated by theme itself
		// by default, we don't need to escape it
		
		return ( $force ? wp_kses_post( $string ) : $string );
	}
}

if(!function_exists('om_esc_embed')) {
	function om_esc_embed($string) {
		// remove all javascript
		
		$string=wp_kses(
			$string,
			array_merge(
				wp_kses_allowed_html( 'post' ),
				array(
					'iframe' => array(
						'width' => true,
						'height' => true,
						'src' => true,
						'scrolling' => true,
						'frameborder' => true,
						'style' => true,
						'allowfullscreen' => true,
					),
				)
			)
		);
		
		return $string;
		
	}
}

if(!function_exists('om_esc_ext_fonts')) {
	function om_esc_ext_fonts($string) {
		// remove all javascript
		
		$string=wp_kses(
			$string,
			array(
				'link' => array(
					'href' => true,
					'rel' => true,
					'type' => true,
				),
				'style' => array(
					'type' => true,
				),
			)
		);
		
		return $string;
		
	}
}

if(!function_exists('om_esc_css')) {
	function om_esc_css($string) {
		// escape CSS
		
		$string=str_replace('<','&lt;',$string);
		
		return $string;
		
	}
}