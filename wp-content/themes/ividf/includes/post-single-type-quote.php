<?php get_template_part( 'includes/post-single-header' ) ?>

	<?php
		$quote=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'quote', true);
		$author=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'quote_author', true);
		if($quote) {
			echo '<div class="blockquote"><div class="blockquote-inner">'.wp_kses_post($quote).'</div>'.($author?'<div class="blockquote-author">'.esc_html($author).'</div>':'').'</div>';
		}
	?>

	<?php if(has_post_thumbnail() && get_option(OM_THEME_PREFIX.'post_single_show_thumb') == 'true') { ?>
		<div class="post-media">
			<a href="<?php the_permalink(); ?>"><?php om_post_thumbnail('post-media-full'); ?></a>
		</div>
	<?php } ?>

<?php get_template_part( 'includes/post-single-footer' ) ?>