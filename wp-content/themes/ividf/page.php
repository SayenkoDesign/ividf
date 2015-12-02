<?php
$page_slider=om_get_page_slider($post->ID);
om_custom_header_setup($post->ID);
om_custom_sidebar_setup($post->ID);
om_wpb_detect($post);
get_header();
?>
	<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'before_header') om_tpl_header_slider($page_slider) ?>
	<?php om_tpl_page_title($post->ID, the_title('','',false)) ?>
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">
					
					<?php //e do_shortcode( get_option(OM_THEME_PREFIX . 'code_after_page_h1') ); ?>
					<article>
					<?php while (have_posts()) : the_post(); ?>
		
						<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
							<div class="om-c-container">
								<div class="om-c-container-inner"><?php ob_start(); the_content(); echo trim(ob_get_clean()); ?></div>
							</div>
						</div>
						<div class="clear"></div>
						
					<?php endwhile; ?>
					</article>
					
					<div class="om-c-container">
						<div class="om-c-container-inner">
						<?php //e do_shortcode( get_option(OM_THEME_PREFIX . 'code_after_page_content') ); ?>
		
						<?php om_wp_link_pages();	?>
						
						<?php get_template_part( 'includes/comments' ); ?>
						</div>
					</div>
					
				</div>
								
				<?php get_sidebar(); ?>
				
				<div class="clear"></div>
				
			</div>
		</div>
	</div>
<?php get_footer(); ?>