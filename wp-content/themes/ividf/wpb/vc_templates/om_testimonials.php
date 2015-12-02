<?php
global $post;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' ); // shortcode may be used out of content area, for instance in widgets area, but it needs this file

$classes=array('vc_om-testimonials','wpb_content_element');
if($el_class)
	$classes[]=$el_class;
$classes[]='vc_om-mode-'.$mode;

$timeout=intval($timeout);

$args=array (
	'post_type' => 'testimonials',
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'posts_per_page' => -1
);
if($ids) {
	$args['post__in']=explode(',',$ids);
	$args['orderby']='post__in';	
} else {
	$category=trim($category);
	if($category) {
		if(is_numeric($category)) {
			$args['tax_query']=array(
				array('taxonomy'=>'testimonials-type', 'terms' => $category),
			);
		} else {
			$args['tax_query']=array(
				array('taxonomy'=>'testimonials-type', 'field' => 'slug', 'terms' => $category),
			);
		}
	}
}
if($randomize) {
	$args['orderby']='rand';
}
$my_query = new WP_Query($args);

if($my_query->have_posts()) {
	
	?>
	<div class="<?php echo apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode(' ',$classes), $this->settings['base'], $atts ) ?>" <?php echo ($timeout?' data-timeout="'.$timeout.'"':'').($pause?' data-pause="1"':'') ?>>
		<?php echo wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_teaser_grid_heading' ) ) ?>
		<div class="vc_om-testimonials-items">
			<?php
			while ( $my_query->have_posts() ) {
				$my_query->the_post(); // Get post from query
				echo '<div class="om-item">';
				$author=get_post_meta($post->ID, OM_THEME_SHORT_PREFIX.'testimonial_author_desc', true);
	
				echo '<div class="om-item-inner'.( has_post_thumbnail() ?' with-pic':' no-pic'  ).'">';
				
				if ( has_post_thumbnail() ) {
					echo '<div class="om-item-pic">'. get_the_post_thumbnail() .'</div>';
				}
	
				echo '<div class="om-item-text">';
				the_content();
				echo '</div>';

				if($author)
					echo '<div class="om-item-author">'.esc_html($author).'</div>';
				
				echo '<div class="clear"></div></div>';					
				echo '</div>';
			}
			?>
		</div>
		<?php
		if($mode!='list')
			echo '<div class="vc_om-testimonials-controls"><a href="#" class="om-prev"></a><a href="#" class="om-next"></a></div>';
		?>
	</div>
	<?php
}

wp_reset_query();