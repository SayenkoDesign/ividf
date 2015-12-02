<?php get_template_part( 'includes/post-standard-header' ) ?>

	<?php if( $media=om_get_audio_player(get_the_ID()) ) { ?>
		<div class="post-media">
			<?php echo om_esc_sg($media) ?>
		</div>
	<?php } ?>
	
<?php get_template_part( 'includes/post-standard-footer' ) ?>