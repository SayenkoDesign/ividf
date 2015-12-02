<?php

/**
 * Include Styles & Scripts
 */

function ompf_enqueue_scripts() {
	
	$min_postfix='';
	if($GLOBALS['omPortfolioPlugin']['config']['include_min_scripts']) {
		$min_postfix='.min';
	}
	
	if($GLOBALS['omPortfolioPlugin']['config']['include_front_css']){
		wp_enqueue_style('ompf-portfolio', $GLOBALS['omPortfolioPlugin']['path_url'].'assets/css/portfolio.css', array(), $GLOBALS['omPortfolioPlugin']['version']);
	}

	if($GLOBALS['omPortfolioPlugin']['config']['include_isotope_js']) {
		wp_enqueue_script('ompf-isotope', $GLOBALS['omPortfolioPlugin']['path_url'].'assets/js/isotope.pkgd.om'.$min_postfix.'.js', array('jquery'), $GLOBALS['omPortfolioPlugin']['version'], $GLOBALS['omPortfolioPlugin']['config']['scripts_in_footer']);
	}
	
	if($GLOBALS['omPortfolioPlugin']['config']['include_front_js']) {
		wp_enqueue_script('jquery');
		wp_enqueue_script('ompf-portfolio', $GLOBALS['omPortfolioPlugin']['path_url'].'assets/js/portfolio'.$min_postfix.'.js', array('jquery'), $GLOBALS['omPortfolioPlugin']['version'], $GLOBALS['omPortfolioPlugin']['config']['scripts_in_footer']);
		
		wp_localize_script( 'ompf-portfolio', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
	}
	
	if($GLOBALS['omPortfolioPlugin']['config']['responsive_mode']) {
		/*
		if(is_array($GLOBALS['omPortfolioPlugin']['config']['responsive_bounds'])) {
			foreach($GLOBALS['omPortfolioPlugin']['config']['responsive_bounds'] as $k=>$v) {
				if(!isset($v['from']))
					$v['from']=false;
				if(!isset($v['to']))
					$v['to']=false;
				if($v['from'] || $v['to'])
					wp_enqueue_style('omsc-portfolio-'.$k, $GLOBALS['omPortfolioPlugin']['path_url'].'assets/css/portfolio-'.$k.'.css', array(), $GLOBALS['omPortfolioPlugin']['version'], 'screen'.($v['from']?' and (min-width: '.$v['from'].'px)':'').($v['to']?' and (max-width: '.$v['to'].'px)':''));
			}
		}
		*/
		wp_enqueue_style('omsc-portfolio-mobile', $GLOBALS['omPortfolioPlugin']['path_url'].'assets/css/portfolio-mobile.css', array(), $GLOBALS['omPortfolioPlugin']['version']);
	}

}
add_action('wp_enqueue_scripts', 'ompf_enqueue_scripts');

/**
 * Append Portfolio block to the page
 */

function ompf_init_append_portfolio_content() {
	
	if( ! $GLOBALS['omPortfolioPlugin']['config']['theme_supplies_page_template'] ) {
		add_filter('the_content', 'ompf_append_portfolio_content');
	}
	
}
add_action('init', 'ompf_init_append_portfolio_content');

function ompf_append_portfolio_content($content) {
	if(isset($GLOBALS['post']) && $GLOBALS['post']->ID) {
		$portfolio_display=get_post_meta($GLOBALS['post']->ID, 'ompf_portfolio_display', true);
		if($portfolio_display) {
			$content .= ompf_the_content();
		}
	}
	
	return $content;
}

/**
 * Portfolio page content
 */

function ompf_the_content($portfolio_post_id = false) {
	
	global $wp_query, $post;
	
	if(!$portfolio_post_id)
		$portfolio_post_id=$GLOBALS['post']->ID;
	
	ob_start();
	
	include $GLOBALS['omPortfolioPlugin']['path'] . 'includes/portfolio.php';
	
	return ob_get_clean();

}

/**
 * Portfolio Thumbnails List
 */

function ompf_get_portfolio_thumbnails($args) {
	
	$out=array();
	
	/*-------------------------------------------------------*/
	
	if(!isset($args['query_args']))
		$args['query_args']=array();
	
	if(isset($args['wp_query']) && $args['wp_query']) {
		
		$query = $args['wp_query'];
		$out['pagination']=$query->query_vars['posts_per_page'];
		
	} else {
	
		$query_args=array(
			'post_type' => 'portfolio',
			'post_status' => 'publish',
		);
		
		// sort
		if(isset($args['query_args']['orderby']) && isset($args['query_args']['order'])) {
			$query_args['orderby']=$args['query_args']['orderby'];
			$query_args['order']=$args['query_args']['order'];
		} else {
			if($args['portfolio_post_id'])
				$sort=get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_sort', true);
			else
				$sort='custom';
			if($sort == 'date_asc') {
				$query_args['orderby'] = 'date';
				$query_args['order'] = 'ASC';
			} elseif($sort == 'date_desc') {
				$query_args['orderby'] = 'date';
				$query_args['order'] = 'DESC';
			} else {
				$query_args['orderby'] = 'menu_order';
				$query_args['order'] = 'ASC';
			}
		}
		
		//pagination
		if(isset($args['query_args']['posts_per_page'])) {
			$query_args['posts_per_page']=$args['query_args']['posts_per_page'];
		} else {
			if($args['portfolio_post_id'])
				$pagination=get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_pagination', true);
			else
				$pagination='no';
				
			if($pagination == 'pages') {
				$pagination_per_page=intval(get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_per_page', true));
				if($pagination_per_page) {
					$query_args['posts_per_page'] = $pagination_per_page;
					$out['pagination']=$pagination;
				} else {
					$query_args['posts_per_page'] = -1;
					$out['pagination']='no';
				}
			} elseif($pagination == 'scroll') {
				$pagination_per_page=intval(get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_per_page', true));
				if($pagination_per_page)
					$query_args['posts_per_page'] = $pagination_per_page;
				else
					$query_args['posts_per_page'] = $GLOBALS['omPortfolioPlugin']['config']['infinite_scroll_portion'];
				$out['pagination']=$pagination;
			} else {
				$query_args['posts_per_page'] = -1;
				$out['pagination']='no';
			}
		}
		if(isset($query_args['posts_per_page']) && $query_args['posts_per_page'] != -1) {
			if(isset($args['query_args']['paged'])) {
				$query_args['paged']=$args['query_args']['paged'];
			} else {
				$query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
			}
		}
	
		//category
		if(isset($args['query_args']['tax_query'])) {
			$query_args['tax_query']=$args['query_args']['tax_query'];
		} else {
			if(isset($args['category_id']) && $args['category_id']) {
				$query_args['tax_query']=array(
					array('taxonomy'=>'portfolio-type', 'terms' => $args['category_id']),
				);
			}
		}
	
		$query_args=apply_filters('ompf_portfolio_query', $query_args);
		$query = new WP_Query($query_args);
		
	}
	
	$out['max_num_pages']=$query->max_num_pages;
	$out['post_count']=$query->post_count;
	$out['found_posts']=$query->found_posts;
		
	/*-------------------------------------------------------*/
	
	if(!isset($args['portfolio_post_id'])) {
		$args['portfolio_post_id']=false;
	}

	if(!isset($args['layout'])) {
		if($args['portfolio_post_id'])
			$args['layout']=get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_layout', true);
		if(!isset($args['layout']) || !$args['layout'])
			$args['layout']='fixed';
	}
	
	if(!isset($args['size'])) {
		if($args['portfolio_post_id'])
			$args['size']=get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_thumbs_size', true);
		if(!isset($args['size']) || !$args['size'])
			$args['size']='medium';
	}
	
	if(!isset($args['image_size'])) {
		$args['image_size']=$args['size'];
		if($GLOBALS['omPortfolioPlugin']['config']['theme_support_portfolio_width100'] && $args['portfolio_post_id']) {
			if( get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_full_width', true) )
				$args['image_size'].='-full';
		}
	}
	
	if(!isset($args['margins'])) {
		if($args['portfolio_post_id'])
			$args['margins']=get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_item_margins', true);
		if(!isset($args['margins']) || !$args['margins'])
			$args['margins']='standard';
	}

	if(!isset($args['ratio']) && $args['layout'] != 'masonry') {
		if($args['portfolio_post_id'])
			$args['ratio']=floatval(get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_fixed_ratio', true));
		if(!isset($args['ratio']) || !$args['ratio'])
			$args['ratio']=1.5;
	}

	if(!isset($args['preview_layout'])) {
		if($args['portfolio_post_id'])
			$args['preview_layout']=get_post_meta($args['portfolio_post_id'], 'ompf_portfolio_preview_layout', true);
		if(!isset($args['preview_layout']) || !$args['preview_layout'])
			$args['preview_layout']='full';
	}
	
	if(isset($GLOBALS['omPortfolioPlugin']['config']['thumbnail_sizes'][$args['image_size']]['width']))
		$thumb_width=$GLOBALS['omPortfolioPlugin']['config']['thumbnail_sizes'][$args['image_size']]['width'];
	else
		$thumb_width=300;
	
	if(isset($args['ratio']) && $args['ratio'])
		$thumb_height=round($thumb_width/$args['ratio']);
	else
		$thumb_height=false;
	
	/*-------------------------------------------------------*/

	if(has_filter('ompf_portfolio_layout_'.$args['layout'])) {
		
		$out['html']=apply_filters('ompf_portfolio_layout_'.$args['layout'], '', $query, $args);
		
	} else {
		if($query->have_posts()) {
			ob_start();
			
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;

				$link=get_post_meta($post->ID, 'ompf_portfolio_custom_link', true);
				if(!$link)
					$link=get_permalink();
				elseif($link == 'none')
					$link=false;
					
				$img=false;
				if ( has_post_thumbnail() ) {
					$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
					if($img) {
						if($thumb_height)
							$img_=omaq_resize($img[0],$thumb_width,$thumb_height,true,false);
						else
							$img_=omaq_resize($img[0],$thumb_width, null, null, false);
						if($img_)
							$img=$img_;
					}
				}
				
				$item_classes=array(
					'ompf-portfolio-thumb',
					'ompf-size-'.$args['size'],
				);
				
				if($args['layout'] != 'random') {

					$term_classes=ompf_item_term_classes($post->ID);
					if($term_classes)
						$item_classes[]=$term_classes;
				}

				if($link) {
					$item_classes[]='ompf-with-link';
				} else {
					$item_classes[]='ompf-no-link';
				}

				if(has_filter('ompf_portfolio_layout_'.$args['layout'].'_item')) {
					
					echo apply_filters('ompf_portfolio_layout_'.$args['layout'].'_item', '', array(
						'post' => $post,
						'args' => $args,
						'item_classes' => $item_classes,
						'link' => $link,
						'img' => $img,
					));
					
				} else {
					?>
					<div class="<?php echo esc_attr(implode(' ',$item_classes)) ?>" id="post-<?php the_ID(); ?>">
						<a<?php if($link) echo ' href="'.esc_url($link).'"'; ?>>
							<?php if($img || $args['layout'] != 'masonry') { ?>
							<span class="ompf-pic-wrapper">
								<span class="ompf-pic" style="padding-top:<?php echo ( $args['layout'] == 'masonry' ? ($img[2]/$img[1] * 100) : (1/$args['ratio'] * 100) ) ?>%">
									<span class="ompf-pic-inner">
										<?php
										$company_name = get_post_meta ( $post->ID,'ompf_portfolio_company',true);
											if($img) {
												if($GLOBALS['omPortfolioPlugin']['config']['enable_lazyload_markup'])
													echo '<img src="'.$GLOBALS['omPortfolioPlugin']['config']['lazyload_placeholder'].'" data-original="'.$img[0].'" class="lazyload" alt="'.esc_attr($post->post_title).'" />';
												else
													echo '<img src="'.$img[0].'" alt="'.esc_attr($post->post_title).'" />';
											} 
										?>
									</span>
								</span>
							</span>
							<?php } ?>
							<?php if($args['preview_layout'] != 'thumbnail') { ?>
							<span class="ompf-desc-wrapper">
								<span class="ompf-desc">
									<span class="ompf-desc-inner">
                                   		<span class="ompf-title company_name"><?php echo $company_name; ?></span>
										<span class="ompf-title"><?php echo esc_html(get_the_title()); ?></span>
										<?php if ($args['layout'] != 'random' && $text=get_post_meta($post->ID, 'ompf_portfolio_short_desc', true)) { ?><span class="ompf-text"><?php echo esc_html($text) ?></span><?php } ?>
									</span>
								</span>
							</span>
							<?php } ?>
						</a>
					</div>
					<?php
				}				
								
			}
			
			$out['html']=ob_get_clean();
		}
	}

	wp_reset_postdata();
	
	/*----------------------------------------*/
	$out['paged']=$query->query_vars['paged'];
	if(!$out['paged'])
		$out['paged']=1;
	
	$out['args']=$args;
	
	return $out;
}