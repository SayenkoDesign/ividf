<?php

/*************************************************************************************
 *	Add Testimonials Post Type
 *************************************************************************************/
 
function omtm_create_testimonials() {
	$labels = array(
		'name' => __( 'Testimonials','om_testimonials'),
		'singular_name' => __( 'Testimonial','om_testimonials' ),
		'add_new' => __('Add New','om_testimonials'),
		'add_new_item' => __('Add New Testimonial','om_testimonials'),
		'edit_item' => __('Edit Testimonial','om_testimonials'),
		'new_item' => __('New Testimonial','om_testimonials'),
		'view_item' => __('View Testimonial','om_testimonials'),
		'search_items' => __('Search Testimonials','om_testimonials'),
		'not_found' =>  __('No testimonials found','om_testimonials'),
		'not_found_in_trash' => __('No testimonials found in Trash','om_testimonials'), 
		'parent_item_colon' => ''
	);
	  
	register_post_type( 'testimonials', array(
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'supports' => array('title','editor','thumbnail','custom-fields','page-attributes')
	));
	
}
add_action( 'init', 'omtm_create_testimonials' );

/*************************************************************************************
 *	Add Testimonials Types
 *************************************************************************************/
 
function omtm_add_testimonials_taxonomies(){
	$labels = array(
		'name' => __( 'Testimonials Categories', 'om_testimonials' ),
		'singular_name' => __( 'Testimonials Category', 'om_testimonials' ),
		'search_items' =>  __( 'Search Testimonials Categories', 'om_testimonials' ),
		'popular_items' => __( 'Popular Testimonials Categories', 'om_testimonials' ),
		'all_items' => __( 'All Testimonials Categories', 'om_testimonials' ),
		'parent_item' => __( 'Parent Testimonials Category', 'om_testimonials' ),
		'parent_item_colon' => __( 'Parent Testimonials Category:', 'om_testimonials' ),
		'edit_item' => __( 'Edit Testimonials Category', 'om_testimonials' ), 
		'update_item' => __( 'Update Testimonials Category', 'om_testimonials' ),
		'add_new_item' => __( 'Add New Testimonials Category', 'om_testimonials' ),
		'new_item_name' => __( 'New Testimonials Category Name', 'om_testimonials' ),
		'separate_items_with_commas' => __( 'Separate testimonials categories with commas', 'om_testimonials' ),
		'add_or_remove_items' => __( 'Add or remove testimonials categories', 'om_testimonials' ),
		'choose_from_most_used' => __( 'Choose from the most used testimonials categories', 'om_testimonials' ),
		'menu_name' => __( 'Testimonials Categories', 'om_testimonials' )
	);
	
	$args=array (
		'hierarchical' => true,
		'labels' => $labels,
		'query_var' => true,
		'rewrite' => array('slug' => 'testimonials-type', 'hierarchical' => true)
	);
	
	register_taxonomy(
		'testimonials-type', 
		'testimonials', 
		$args
	);

}
add_action( 'init', 'omtm_add_testimonials_taxonomies' );

/*************************************************************************************
 *	Testimonials Sort Page
 *************************************************************************************/

function omtm_testimonials_sort_page_add() {
	add_submenu_page('edit.php?post_type=testimonials', __('Sort Testimonials','om_testimonials'), __('Sort Testimonials','om_testimonials'), 'edit_posts', 'testimonials_sort', 'omtm_testimonials_sort_page');
}
add_action('admin_menu', 'omtm_testimonials_sort_page_add');

function omtm_enqueue_scripts_testimonials_sort($hook) {
	if('testimonials_page_testimonials_sort' != $hook)
		return;

	wp_enqueue_style('nav-menu');

	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-sortable');
	
	wp_enqueue_script('omtm-testimonials-sort', $GLOBALS['omTestimonialsPlugin']['path'].'assets/js/items-sort.js', array('jquery','jquery-ui-sortable'));
}
add_action('admin_enqueue_scripts', 'omtm_enqueue_scripts_testimonials_sort');

function omtm_testimonials_sort_page() {
	$query = new WP_Query('post_type=testimonials&posts_per_page=-1&orderby=menu_order&order=ASC');
	?>
	<div class="wrap">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br /></div>
		<h2><?php _e('Sort Testimonials', 'om_testimonials'); ?></h2>
		<p><?php _e('Sort Testimonials by drag-n-drop. Items at the top will appear first.', 'om_testimonials'); ?></p>
	
		<ul id="omtm_testimonials_items">
			<?php while( $query->have_posts() ) : $query->the_post(); ?>
				<?php if( get_post_status() == 'publish' ) { ?>
					<li id="<?php the_id(); ?>" class="menu-item">
						<dl class="menu-item-bar">
							<dt class="menu-item-handle">
								<span class="menu-item-title"><?php the_title(); ?></span>
							</dt>
						</dl>
						<ul class="menu-item-transport"></ul>
					</li>
				<?php } ?>
			<?php endwhile; ?>
		</ul>
	</div>
	<script>
		jQuery(function($){
			omtm_items_sort('#omtm_testimonials_items','omtm_testimonials_apply_sort');
		});
	</script>
	<?php wp_reset_postdata(); ?>
	<?php
}

function omtm_testimonials_apply_sort() {
	global $wpdb;
	
	$order = explode(',', $_POST['order']);
	$counter = 0;
	
	foreach($order as $id) {
		$wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $id));
		$counter++;
	}
	exit();
}
add_action('wp_ajax_omtm_testimonials_apply_sort', 'omtm_testimonials_apply_sort');