<?php get_template_part( 'includes/post-single-header' ) ?>

	<?php if(has_post_thumbnail() && get_option(OM_THEME_PREFIX.'post_single_show_thumb') == 'true') { ?>
		<div class="post-media">
			<a href="<?php the_permalink(); ?>"><?php om_post_thumbnail('post-media-full'); ?></a>
		</div>
	<?php } ?>

<?php get_template_part( 'includes/post-single-footer' ) ?>