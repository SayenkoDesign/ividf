<?php get_template_part( 'includes/post-single-header' ) ?>

	<?php	if($link=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'link_url', true)) { ?>
		<div class="post-link-box"><a href="<?php echo esc_url($link) ?>" target="_blank"><?php echo esc_html($link) ?></a></div>
	<?php } ?>

	<?php if(has_post_thumbnail() && get_option(OM_THEME_PREFIX.'post_single_show_thumb') == 'true') { ?>
		<div class="post-media">
			<a href="<?php the_permalink(); ?>"><?php om_post_thumbnail('post-media-full'); ?></a>
		</div>
	<?php } ?>

<?php get_template_part( 'includes/post-single-footer' ) ?>