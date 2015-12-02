<?php get_template_part( 'includes/post-standard-header' ) ?>

	<?php	if($link=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'link_url', true)) { ?>
		<div class="post-link-box"><a href="<?php echo esc_url($link) ?>" target="_blank"><?php echo esc_html($link) ?></a></div>
	<?php } ?>
	
	<?php if(has_post_thumbnail()) { ?>
		<div class="post-media">
			<?php
				$img=om_get_post_thumbnail('post-media-small', false);
				echo om_hover_extras($img['html'], false, get_permalink());
			?>
		</div>
	<?php } ?>
	
<?php get_template_part( 'includes/post-standard-footer' ) ?>