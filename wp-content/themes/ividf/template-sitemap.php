<?php
/*
Template Name: Sitemap
*/

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
					
					<div class="om-c-container">
						<div class="om-c-container-inner">

			        <div class="sitemap">
			
								<div class="one-third">
			
								<h3><?php _e('Site Feeds','om_theme'); ?></h3>
								<ul>
									<li><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Main RSS Feed','om_theme'); ?></a></li>
									<li><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments RSS Feed','om_theme'); ?></a></li>
								</ul>
								
								<?php $list=wp_list_pages('title_li=&echo=0'); ?>
								<?php if($list) : ?>
									<h3><?php _e('Pages','om_theme'); ?></h3>
									<ul>
										<?php echo om_esc_wpcf($list) ?>
									</ul>
								<?php endif; ?>
								
								</div>
								
								<div class="one-third">
			
									<?php $list=get_posts('numberposts=-1&orderby=title&order=ASC'); ?>
									<?php if(!empty($list)) : ?>
										<h3><?php _e('Posts','om_theme'); ?></h3>
										<ul>
											<?php
												foreach($list as $item) {
													echo '<li><a href="'. get_permalink($item->ID) .'">'.esc_html($item->post_title).'</a></li>';
												}
											?>
										</ul>
									<?php endif; ?>			
			
									<?php $list=wp_list_categories('title_li=&echo=0'); ?>
									<?php $list2=wp_list_categories('title_li=&taxonomy=portfolio-type&echo=0'); ?>
									<?php if($list || $list2) : ?>
										<h3><?php _e('Categories','om_theme'); ?></h3>
										<ul>
											<?php if($list) : ?>
												<li>
													<?php _e('Blog','om_theme'); ?>
													<ul>
														<?php echo om_esc_wpcf($list); ?>
													</ul>
												</li>
											<?php endif; ?>
											<?php if($list2) : ?>
												<li>
													<?php _e('Portfolio','om_theme'); ?>
													<ul>
														<?php echo om_esc_wpcf($list2); ?>
													</ul>
												</li>
											<?php endif; ?>
										</ul>
									<?php endif; ?>
				
									<?php
										$tags = get_terms( 'post_tag' );
										if( !empty($tags) ) {
											?>
											<h3><?php _e('Tags','om_theme'); ?></h3>
											<ul>
											<?php
											foreach( $tags as $tag ) {
												echo '<li><a href="' . esc_attr( get_tag_link( $tag->term_id ) ) . '">' . esc_html($tag->name) . '</a></li>';
											}
											?>
											</ul>
											<?php
										}
									?>		
									
									<?php $list=wp_get_archives('type=monthly&echo=0'); ?>
									<?php if($list) : ?>
										<h3><?php _e('Monthly Archives','om_theme'); ?></h3>
										<ul>
											<?php echo om_esc_wpcf($list) ?>
										</ul>
									<?php endif; ?>
									
																		
								</div>
								
								<div class="one-third last">
									
									<?php $list=get_posts('numberposts=-1&orderby=title&order=ASC&post_type=portfolio'); ?>
									<?php if(!empty($list)) : ?>
										<h3><?php _e('Portfolio','om_theme'); ?></h3>
										<ul>
											<?php
												foreach($list as $item) {
													echo '<li><a href="'. get_permalink($item->ID) .'">'.esc_html($item->post_title).'</a></li>';
												}
											?>
										</ul>
									<?php endif; ?>		
									
									<?php $list=get_posts('numberposts=-1&orderby=title&order=ASC&post_type=testimonials'); ?>
									<?php if(!empty($list)) : ?>
										<h3><?php _e('Testimonials','om_theme'); ?></h3>
										<ul>
											<?php
												foreach($list as $item) {
													echo '<li><a href="'. get_permalink($item->ID) .'">'.esc_html($item->post_title).'</a></li>';
												}
											?>
										</ul>
									<?php endif; ?>
									
								</div>		
								
								<div class="clear"></div>
								
							</div>					
					
						</div>
					</div>
					
					</article>
					
					<div class="om-c-container">
						<div class="om-c-container-inner">
							<?php //e do_shortcode( get_option(OM_THEME_PREFIX . 'code_after_page_content') ); ?>
			
							<?php om_wp_link_pages();	?>
							
							<?php get_template_part( 'includes/comments' ); ?>
						</div>
					</div>		
								
				</div>
								
				<div class="clear"></div>
				
			</div>
		</div>
	</div>
<?php get_footer();