	<?php 
	
	$meta=array();
	
	global $wpb_shortcode_om_posts_hide_meta;
	global $wpb_shortcode_om_posts_hide_excerpt;
	
	if(!isset($wpb_shortcode_om_posts_hide_meta) || !$wpb_shortcode_om_posts_hide_meta) { // this file included from shortcode with 'hide meta' option

		// date
		if(get_option(OM_THEME_PREFIX . 'post_hide_date') != 'true') {
			$meta[]='<span class="post-date">'.get_the_time(get_option('date_format')) .'</span>';	
		}
		
		// categories
		if(get_option(OM_THEME_PREFIX . 'post_hide_categories') != 'true') {
			if($post->post_type == 'portfolio') {
				$categories = get_the_term_list($post->ID, 'portfolio-type', '<span class="post-categories">', ', ', '</span>');
			} else {
				$categories = get_the_category_list(', ');
			}
			if($categories) {
				$categories='<span class="post-categories">'.$categories.'</span>';
				$meta[]=$categories;
			}
		}
			
		//tags
		if(get_option(OM_THEME_PREFIX . 'post_hide_tags') != 'true') {
			$tags=get_the_tag_list('<span class="post-tags">', ', ', '</span>' );
			if($tags) {
				$meta[]=$tags;
			}
		}
		
		// comments
		if(empty($post->post_password) && get_option(OM_THEME_PREFIX . 'hide_comments_post') != 'true' && get_option(OM_THEME_PREFIX . 'post_hide_comments') != 'true') {
			ob_start();
			comments_popup_link( '', '<span class="comments-count">1</span>', '<span class="comments-count">%</span>', '', '');
			$comments=ob_get_clean();
			if($comments && $comments != '<span></span>') {
				$comments='<span class="post-comments">'.$comments.'</span>';
				$meta[]=$comments;
			}
		}
		
		// author
		if(get_option(OM_THEME_PREFIX . 'post_hide_author') != 'true') {
			ob_start();the_author_posts_link();$the_author_posts_link=ob_get_clean();
			$meta[]='<span class="post-author"><span>'. __('by','om_theme') .' </span>'. $the_author_posts_link .'</span>';
		}
		
	}
	
	
	?>
	<?php if(!empty($meta)) { ?>
		<div class="post-meta">
			<?php echo implode(' <span class="post-meta-divider"></span> ',$meta) ?>
		</div>
	<?php } ?>
	
	<?php if(!isset($wpb_shortcode_om_posts_hide_excerpt) || !$wpb_shortcode_om_posts_hide_excerpt) { /* this file included from shortcode with 'hide excerpt' option*/ ?>
		<?php //$readmore=false; ?>
		<?php if ( is_singular() ) { ?>
			<div class="post-content post-content-full">
				<?php the_content(); ?>
				<div class="clear"></div>
			</div>
		<?php } else { ?>
			<div class="post-content post-content-excerpt">
			<?php
				if( has_excerpt() ) {
					om_custom_excerpt_more( get_the_excerpt() );
					//$readmore=true;
				} else {
					if( get_option(OM_THEME_PREFIX . 'blog_excerpt_mode') == 'auto' ) {
						remove_filter('excerpt_length', 'om_excerpt_length');
						add_filter('excerpt_length', 'om_blog_excerpt_length');
						remove_filter('excerpt_more', 'om_excerpt_more');
						add_filter('excerpt_more', 'om_blog_excerpt_more');
						echo get_the_excerpt();
						remove_filter('excerpt_length', 'om_blog_excerpt_length');
						add_filter('excerpt_length', 'om_excerpt_length');
						remove_filter('excerpt_more', 'om_blog_excerpt_more');
						add_filter('excerpt_more', 'om_excerpt_more');
					} else {
						the_content( __('Read more', 'om_theme') );
						//if(strpos($post->post_content, '<!--more-->') !== false)
						//	$readmore=true;
					}
				}
			?>
			</div>
		<?php } ?>
	<?php } ?>
	<div class="clear"></div>
</div>