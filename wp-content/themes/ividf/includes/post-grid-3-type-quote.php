<?php get_template_part( 'includes/post-standard-header' ) ?>

	<?php
		$quote=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'quote', true);
		$author=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'quote_author', true);
		if($quote) {
			echo '<div class="blockquote"><div class="blockquote-inner">'.wp_kses_post($quote).'</div>'.($author?'<div class="blockquote-author">'.esc_html($author).'</div>':'').'</div>';
		}
	?>
	
	<?php if(has_post_thumbnail()) { ?>
		<div class="post-media">
			<?php
				$img=om_get_post_thumbnail('post-media-small', false);
				echo om_hover_extras($img['html'], false, get_permalink());
			?>
		</div>
	<?php } ?>
	
<?php get_template_part( 'includes/post-standard-footer' ) ?>