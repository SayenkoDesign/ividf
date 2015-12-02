<div <?php post_class('blogroll-item'); ?> id="post-<?php the_ID(); ?>">

	<?php if ( is_singular() ) { ?>
	<?php } else { ?>
		<div class="post-title"><h2><a href="<?php the_permalink(); ?>"><?php ( get_the_title() != '' ? the_title() : the_permalink() ); ?></a></h2></div>
	<?php } ?>
