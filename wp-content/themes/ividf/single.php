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
					
					<?php //e do_shortcode( get_option(OM_THEME_PREFIX . 'code_after_post_h1') ); ?>
					<?php while (have_posts()) : the_post(); ?>

						<article>
				    <?php 
	
							$format = get_post_format(); 
							if( false === $format )
								$format = 'standard';
							get_template_part( 'includes/post-single-type-' . $format );
							
				    ?>
				    </article>
						
					<?php endwhile; ?>
					<div class="om-c-container">
						<div class="om-c-container-inner">
							
							<?php //e do_shortcode( get_option(OM_THEME_PREFIX . 'code_after_post_content') ); ?>
		
							<?php om_wp_link_pages();	?>
							
							<?php
								$prev=get_previous_post_link('%link');
								$next=get_next_post_link('%link');
								if( get_option(OM_THEME_PREFIX . 'show_prev_next_post') == 'true' && ( $prev || $next ) ) 
									echo om_prev_next_nav($prev,$next);
							?>
												
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