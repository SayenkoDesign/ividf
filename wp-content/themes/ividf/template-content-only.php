<?php
/*
Template Name: Without Header/Footer
*/

om_custom_sidebar_setup($post->ID);
$slider=om_get_page_slider(get_the_ID());
get_header('empty');

?>
	<?php om_tpl_header_slider($slider) ?>
	<?php om_tpl_page_title($post->ID, the_title('','',false)) ?>
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">
					
					<?php //e do_shortcode( get_option(OM_THEME_PREFIX . 'code_after_page_h1') ); ?>
					<article>
					<?php while (have_posts()) : the_post(); ?>
		
						<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
							<?php the_content(); ?>
							<div class="clear"></div>
						</div>
						
					<?php endwhile; ?>

					</article>
					<?php //e do_shortcode( get_option(OM_THEME_PREFIX . 'code_after_page_content') ); ?>
	
					<?php om_wp_link_pages();	?>
					
					<?php get_template_part( 'includes/comments' ); ?>
					
				</div>
								
				<?php get_sidebar(); ?>
				
				<div class="clear"></div>
				
			</div>
		</div>
	</div>
<?php get_footer('empty');