<?php

if(!function_exists('ompf_portfolio_archive_page')) {
	get_template_part( 'archive' );
} else {

$settings_page=get_option('ompf_archive_category_page_settings');
if($settings_page && function_exists('icl_object_id'))
	$settings_page=icl_object_id($settings_page, 'page', true);

$page_slider=om_get_page_slider($settings_page);
om_custom_header_setup($settings_page);
//om_custom_sidebar_setup($settings_page);
om_custom_sidebar_setup(false);

$full_width=get_post_meta($settings_page, 'ompf_portfolio_full_width', true);
if($full_width)
	om_body_add_class('ompf-portfolio-full-width');
	
get_header();
?>
	<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'before_header') om_tpl_header_slider($page_slider) ?>
	<?php om_tpl_page_title($wp_query->queried_object->term_id, single_term_title('',false)) ?>
	
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">
					<?php
						
						echo term_description();
						
						echo ompf_portfolio_archive_page( $settings_page );

					?>

				</div>
				
				<?php
					/*
					if($settings_page)
						$post=get_post($settings_page);
					else
						$post=false;
					get_sidebar();
					*/
				?>
				
				<div class="clear"></div>
				
			</div>
		</div>
	</div>		
<?php get_footer();

}