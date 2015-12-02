<?php
extract( shortcode_atts( array(
	'title' => '',
	'mode' => '',
	'columns' => '',
	'count' => '',
	'category' => '',
	'ids' => '',
	'randomize' => '',
	'hide_thumbnail' => '',
	'hide_meta' => '',
	'hide_excerpt' => '',
	'el_class' => '',
), $atts ) );

if($el_class)
	$el_class=' '.$el_class;

$styles=array();
$classes=array(apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_om-posts wpb_content_element' . $el_class, $this->settings['base'], $atts ));

global $wp_query, $more;

$args=array('posts_per_page' => -1);

if($ids) {
	$args['post__in']=explode(',',str_replace(' ','',$ids));
	$args['orderby']='post__in';
} else {
	$count=intval($count);
	if(!$count)
		$count = -1;
	$args['posts_per_page']=$count;

	$category=explode(',',str_replace(' ','',$category));
	if(!in_array('0',$category)) {
		$category_=array();
		foreach($category as $c) {
			$c=intval($c);
			if($c)
				$category_[]=$c;
		}
		if(!empty($category_))
			$args['category__in']=$category_;
	}
}

if($randomize == 'yes') {
	$args['orderby']='rand';
}

$original_query = $wp_query;
$wp_query = new WP_Query($args);
$original_more = $more;
$more = 0;
						
if (have_posts()) {

	$columns = intval($columns);
	if(!in_array($columns, array(2,3))) {
		$columns=3;
	}

	$blog_layout = 'grid-'.$columns;

	if($hide_meta == 'yes') {
		global $wpb_shortcode_om_posts_hide_meta;
		$wpb_shortcode_om_posts_hide_meta=true;
	}
	if($hide_excerpt == 'yes') {
		global $wpb_shortcode_om_posts_hide_excerpt;
		$wpb_shortcode_om_posts_hide_excerpt=true;
	}

	?>
	<div class="<?php echo implode(' ',$classes) ?>">

		<div class="blogroll blog-mode-shortcode layout-grid layout-grid-<?php echo esc_attr($mode) ?> layout-<?php echo esc_attr($blog_layout) ?>">
		<section>
		
			<?php $i=1; while (have_posts()) : the_post(); ?>
			
		    <?php 

					if($hide_thumbnail == 'yes') {
						
						get_template_part( 'includes/post-standard-header' );
						get_template_part( 'includes/post-standard-footer' );
						
					} else {
						$format = get_post_format(); 
						if( false === $format )
							$format = 'standard';
						get_template_part( 'includes/post-'.$blog_layout.'-type-' . $format );
					}
					
					echo ($mode == 'fixed' && $i % $columns == 0 ? '<div class="clear"></div>' : '' );
		    ?>
			
			<?php $i++; endwhile; ?>		
				
			<div class="clear"></div>				
			
		</section>
		</div>

	</div>
	<?php
	
	if(isset($wpb_shortcode_om_posts_hide_meta))
		unset($wpb_shortcode_om_posts_hide_meta);
	if(isset($wpb_shortcode_om_posts_hide_excerpt))
		unset($wpb_shortcode_om_posts_hide_excerpt);
}

$wp_query = $original_query;
wp_reset_postdata();
$more = $original_more;
