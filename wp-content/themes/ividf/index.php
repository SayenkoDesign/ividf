<?php

$queried_object=get_queried_object();

$layout_page_id=false;
$blog = false;

if(is_object($queried_object)) {
	
	$blog_page_id=get_option('page_for_posts');
	if($blog_page_id) {
		$blog = get_post($blog_page_id);
		$layout_page_id =	$blog_page_id;
	}
		
} else {
	$settings_page=get_option(OM_THEME_PREFIX . 'front_page_settings');
	if($settings_page && function_exists('icl_object_id'))
		$settings_page=icl_object_id($settings_page, 'page', true);
	
	if($settings_page)	
		$layout_page_id =	$settings_page;
}

om_custom_sidebar_setup($layout_page_id);
$slider=om_get_page_slider($layout_page_id);
get_header();

$blog_layout=false;
if($layout_page_id)
	$blog_layout=get_post_meta($layout_page_id, OM_THEME_SHORT_PREFIX.'blog_layout', true);
if(!$blog_layout)
	$blog_layout='small';
	
?>
	<?php om_tpl_header_slider($slider) ?>
    <?php if($blog) om_tpl_page_title($blog->ID, $blog->post_title) ?>

	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">

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
					
					<?php else : ?>
		
						<br/>	
						<h2><?php _e('Error 404 - Not Found', 'om_theme') ?></h2>
					
						<p><?php _e('Sorry, but you are looking for something that isn\'t here.', 'om_theme') ?></p>
		
					<?php endif; //if (have_posts()) ?>	
					
				</div>
								
				<?php
					if($blog)
						$post=$blog;
					elseif($layout_page_id)
						$post=get_post($layout_page_id);
					else
						$post=false;
					get_sidebar();
				?>
				
				<div class="clear"></div>
				
			</div>
		</div>
	</div>		
<?php get_footer();