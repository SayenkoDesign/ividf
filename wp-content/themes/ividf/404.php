<?php
om_custom_sidebar_setup(false);
get_header();
?>
	<?php om_tpl_page_title(false, __( 'Oops, something went wrong&hellip;', 'om_theme' )) ?>
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">
					
					<div class="one-third">
						<p><img src="<?php echo esc_url(TEMPLATE_DIR_URI . '/img/404.png'); ?>" style="padding-top:0.6em" /></p>
						<p>&nbsp;</p>
					</div>
					<div class="one-third">
						<h4 style="border-bottom:1px solid rgba(122,122,122,0.3);padding-bottom:0.3em;"><?php _e('Here are some useful links', 'om_theme') ?></h4>
						<div class="sitemap small">
							<?php wp_nav_menu( array(
								'theme_location' => 'menu-404',
							) ) ?>
						</div>
					</div>
					<div class="one-third last">
						<h4 style="border-bottom:1px solid rgba(122,122,122,0.3);padding-bottom:0.3em;"><?php _e('Try to search', 'om_theme') ?></h4>
						<?php get_search_form(); ?>
					</div>
					<div class="clear"></div>
						
				</div>
								
				<div class="clear"></div>
				
			</div>
		</div>
	</div>
<?php get_footer();