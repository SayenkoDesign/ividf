<?php

$settings_page=get_option(OM_THEME_PREFIX . 'archive_category_page_settings');
if($settings_page && function_exists('icl_object_id'))
	$settings_page=icl_object_id($settings_page, 'page', true);

$page_slider=om_get_page_slider($settings_page);
om_custom_header_setup($settings_page);
om_custom_sidebar_setup($settings_page);
get_header();
	
$blog_layout=false;
if($settings_page)
	$blog_layout=get_post_meta($settings_page, OM_THEME_SHORT_PREFIX.'blog_layout', true);
if(!$blog_layout)
	$blog_layout='small';
?>

	<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'before_header') om_tpl_header_slider($page_slider) ?>
	<?php om_tpl_page_title(false, om_get_archive_page_title()) ?>
	
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">
					<?php
		      	if(is_category())
		      		echo esc_html(category_description());
		      ?>
	      		
					<?php if (have_posts()) : ?>
				
						<div class="blogroll<?php echo ( (strpos($blog_layout, 'grid-') !== false) ? ' layout-grid':'' )?> layout-<?php echo esc_attr($blog_layout) ?>">
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
						
						<?php else : 
			
							echo '<h2>';
							if ( is_category() ) {
								printf(__('Sorry, but there aren\'t any posts in the %s category yet.', 'om_theme'), single_cat_title('',false));
							} elseif ( is_tag() ) { 
							    printf(__('Sorry, but there aren\'t any posts tagged %s yet.', 'om_theme'), single_tag_title('',false));
							} elseif ( is_date() ) { 
								_e('Sorry, but there aren\'t any posts with this date.', 'om_theme');
							} else {
								_e('No posts found.', 'om_theme');
							}
							echo '</h2>';
		
						 endif; ?>
								
					
				</div>
				<?php
					if($settings_page)
						$post=get_post($settings_page);
					else
						$post=false;
					get_sidebar();
				?>
				
				<div class="clear"></div>
				
			</div>
		</div>
	</div>		
<?php get_footer();
