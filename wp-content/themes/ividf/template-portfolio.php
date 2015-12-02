<?php
/*
Template Name: Portfolio
*/

$page_slider=om_get_page_slider($post->ID);
om_custom_header_setup($post->ID);
om_custom_sidebar_setup($post->ID);
om_wpb_detect($post);

$full_width=get_post_meta($post->ID, 'ompf_portfolio_full_width', true);
if($full_width)
	om_body_add_class('ompf-portfolio-full-width');
get_header();
?>
	<?php if(isset($page_slider) && $page_slider && $page_slider['layout'] != 'before_header') om_tpl_header_slider($page_slider) ?>
	<?php om_tpl_page_title($post->ID, the_title('','',false)) ?>
	
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">
                	<?php

						the_post(); the_content();
						
						if(function_exists('ompf_the_content')) {
							echo ompf_the_content();
						} else {
							echo '<p><i><b style="color:red">'.__('Please install and activate Olevmedia Portfolio plugin to display the portfolio content.','om_theme').'</b></i></p>';
						}

					?>

				</div>
				
				<?php //get_sidebar(); ?>
				
				<div class="clear"></div>
				
			</div>
		</div>
	</div>		
<?php get_footer();