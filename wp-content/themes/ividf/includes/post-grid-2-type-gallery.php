<?php get_template_part( 'includes/post-standard-header' ) ?>

	<?php
		$gallery = om_get_gallery_slider(
			get_the_ID(),
			array(
				'image_size' => 'post-media-medium',
				'url_link' => get_permalink(),
				'show_captions' => (get_post_meta(get_the_ID(), OM_THEME_SHORT_PREFIX.'gallery_captions', true) == 'true'),
			)
		);
		if($gallery) { ?>
		<div class="post-media">
			<?php echo om_esc_sg($gallery) ?>
		</div>
	<?php } ?>
	
<?php get_template_part( 'includes/post-standard-footer' ) ?>