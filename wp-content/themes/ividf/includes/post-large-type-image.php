<?php get_template_part( 'includes/post-standard-header' ) ?>

	<?php if(has_post_thumbnail()) { ?>
		<div class="post-media">
			<?php
				$img=om_get_post_thumbnail('post-media-large', false);
				echo om_hover_extras($img['html'], $img['full_image'][0], get_permalink());
			?>
		</div>
	<?php } ?>
	
<?php get_template_part( 'includes/post-standard-footer' ) ?>