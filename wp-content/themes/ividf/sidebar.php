<?php

	if($post)
		$sidebar_type=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'sidebar_show', true);
	else
		$sidebar_type='';

	if($sidebar_type == 'hide') {
		// no sidebar
	} else {
		?>
			<div class="content-column-sidebar"<?php $delay=get_option(OM_THEME_PREFIX.'sidebar_sliding_delay'); if( $delay || $delay == '0' ) echo ' data-move-delay="'.esc_attr($delay).'"' ?>>
				<aside>
				<?php
					// alternative sidebar
					if($post)
						$alt_sidebar=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'sidebar', true);
					else
						$alt_sidebar=false;

					if($alt_sidebar)
						$sidebars=get_option(OM_THEME_PREFIX."extra_sidebars");
						
					if( $alt_sidebar && isset($sidebars[$alt_sidebar]) ) {
						dynamic_sidebar( 'extra-'.$alt_sidebar ); 
					} else {
						dynamic_sidebar();
					}
				?>
				</aside>
			</div>
		<?php
	}