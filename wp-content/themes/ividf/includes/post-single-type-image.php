<?php get_template_part( 'includes/post-single-header' ) ?>

	<?php if(has_post_thumbnail()) { ?>
		<div class="post-media">
			<?php om_post_thumbnail('post-media-full'); ?>
		</div>
	<?php } ?>

<?php get_template_part( 'includes/post-single-footer' ) ?>