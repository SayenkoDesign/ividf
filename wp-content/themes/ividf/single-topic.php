<?php
/* Template for bbPress topic page. Pulls the sidebar and title options from the parent forum post */

om_custom_sidebar_setup($post->post_parent);
get_header();

?>
	<?php om_tpl_page_title($post->post_parent, the_title('','',false)) ?>
	<div class="content">
		<div class="container">
			<div class="container-inner">
				
				<div class="content-column-content">

					<?php do_action( 'bbp_before_main_content' ); ?>
				
					<?php do_action( 'bbp_template_notices' ); ?>
				
					<?php if ( bbp_user_can_view_forum( array( 'forum_id' => bbp_get_topic_forum_id() ) ) ) : ?>
				
						<?php while ( have_posts() ) : the_post(); ?>
				
							<div id="bbp-topic-wrapper-<?php bbp_topic_id(); ?>" class="bbp-topic-wrapper">
								<div class="entry-content">
				
									<?php bbp_get_template_part( 'content', 'single-topic' ); ?>
				
								</div>
							</div><!-- #bbp-topic-wrapper-<?php bbp_topic_id(); ?> -->
				
						<?php endwhile; ?>
				
					<?php elseif ( bbp_is_forum_private( bbp_get_topic_forum_id(), false ) ) : ?>
				
						<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>
				
					<?php endif; ?>
				
					<?php do_action( 'bbp_after_main_content' ); ?>					
					
				</div>
								
				<?php $post_=$post; $post=get_post($post->post_parent); get_sidebar(); $post=$post_; ?>
				
				<div class="clear"></div>
				
			</div>
		</div>
	</div>
<?php get_footer(); ?>