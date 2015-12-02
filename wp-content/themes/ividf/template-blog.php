<?php
/*
Template Name: Blog
*/
$page_slider=om_get_page_slider($post->ID);
om_custom_header_setup($post->ID);
om_custom_sidebar_setup($post->ID);
om_wpb_detect($post);
get_header();

$blog_layout=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'blog_layout', true);
if(!$blog_layout)
	$blog_layout='small';
?>
	<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'before_header') om_tpl_header_slider($page_slider) ?>
	<?php om_tpl_page_title($post->ID, the_title('','',false)) ?>
	
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">
					<?php
						if ( get_query_var('paged') ) {
							$paged = get_query_var('paged');
						} elseif ( is_front_page() && get_query_var('page') ) {
							$paged = get_query_var('page');
						} else {
							$paged = 1;
						}
						$args=array(
							'posts_per_page' => get_option('posts_per_page'),
							'paged' => $paged,
						);
						
						$categories=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'blog_categories', true);
						if($categories) {
							$categories_=array();
							$categories=explode(',',$categories);
							foreach($categories as $v) {
								$v=intval($v);
								if($v)
									$categories_[]=$v;
							}
							if(!empty($categories_))
								$args['cat']=implode(',',$categories_);
						}
					
						$original_query = $wp_query;
						$wp_query = null;
						$wp_query = new WP_Query($args);
						global $more;
						$original_more = $more;
						$more = 0;
					?>
					<?php if (have_posts()) : ?>
				
						<div class="blogroll<?php echo ( (strpos($blog_layout, 'grid-') !== false) ? ' layout-grid layout-grid-masonry':'' )?> layout-<?php echo esc_attr($blog_layout) ?>">
						<section>
	
							<?php while (have_posts()) : the_post(); ?>
							
						    <?php 
			
									$format = get_post_format(); 
									if( false === $format )
										$format = 'standard';
									get_template_part( 'includes/post-' . $blog_layout. '-type-' . $format );
									
						    ?>
							
							<?php endwhile; ?>		
							
							<div class="clear"></div>				
							
						</section>
						</div>
						
						<?php
							if(get_option(OM_THEME_PREFIX . 'blog_pagination') == 'pages') {
		
								echo om_wrap_paginate_links ( paginate_links( om_paginate_links_args() ) );
		
							} else {
							
								$nav_newer=get_previous_posts_link(__('Newer Entries', 'om_theme'));
								$nav_older=get_next_posts_link(__('Older Entries', 'om_theme'));
								if( $nav_newer || $nav_older ) {
									echo om_prev_next_nav ($nav_older, $nav_newer);
								}		
								
							}
						?>
					
					<?php else : ?>
		
						<br/>	
						<h2><?php _e('Error 404 - Not Found', 'om_theme') ?></h2>
					
						<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'om_theme') ?></p>
		
					<?php endif; //if (have_posts()) ?>	
					
					<?php
						$wp_query = null;
						$wp_query = $original_query;
						wp_reset_postdata();
						$more = $original_more;
					?>

				</div>
								
				<?php get_sidebar(); ?>
				
				<div class="clear"></div>
				
			</div>
		</div>
	</div>		
<?php get_footer();