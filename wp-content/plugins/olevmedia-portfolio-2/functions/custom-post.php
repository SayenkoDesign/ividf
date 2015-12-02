<?php

/**
 *	Add Portfolio Post Type
 */
 
function ompf_create_portfolio() {
	
	$labels = array(
		'name' => __( 'Portfolio','om_portfolio'),
		'singular_name' => __( 'Portfolio','om_portfolio' ),
		'add_new' => __('Add New','om_portfolio'),
		'add_new_item' => __('Add New Portfolio','om_portfolio'),
		'edit_item' => __('Edit Portfolio','om_portfolio'),
		'new_item' => __('New Portfolio','om_portfolio'),
		'view_item' => __('View Portfolio','om_portfolio'),
		'search_items' => __('Search Portfolio','om_portfolio'),
		'not_found' =>  __('No portfolio found','om_portfolio'),
		'not_found_in_trash' => __('No portfolio found in Trash','om_portfolio'), 
		'parent_item_colon' => ''
	);
	
	$args=array(
		'labels' => $labels,
		'public' => true,
		'query_var' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array('title','editor','thumbnail','custom-fields','page-attributes','comments'),
		'rewrite' => array('slug'=>'portfolio-item'),
		'has_archive' => true,
	);

	$portfolio_slug=get_option('ompf_portfolio_slug');
	$portfolio_slug=sanitize_title_with_dashes($portfolio_slug);
	if( $portfolio_slug ) {
		$args['rewrite']=array('slug'=>$portfolio_slug);
	}
	
	$args=apply_filters('ompf_post_type_args', $args);

	register_post_type( 'portfolio', $args );
	
	// flush_rewrite_rules(false);
}
add_action( 'init', 'ompf_create_portfolio' );

/**
 *	Add Portfolio Types
 */
 
function ompf_add_portfolio_taxonomies(){
	$labels = array(
		'name' => __( 'Portfolio Categories', 'om_portfolio' ),
		'singular_name' => __( 'Portfolio Category', 'om_portfolio' ),
		'search_items' =>  __( 'Search Portfolio Categories', 'om_portfolio' ),
		'popular_items' => __( 'Popular Portfolio Categories', 'om_portfolio' ),
		'all_items' => __( 'All Portfolio Categories', 'om_portfolio' ),
		'parent_item' => __( 'Parent Portfolio Category', 'om_portfolio' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:', 'om_portfolio' ),
		'edit_item' => __( 'Edit Portfolio Category', 'om_portfolio' ), 
		'update_item' => __( 'Update Portfolio Category', 'om_portfolio' ),
		'add_new_item' => __( 'Add New Portfolio Category', 'om_portfolio' ),
		'new_item_name' => __( 'New Portfolio Category Name', 'om_portfolio' ),
		'separate_items_with_commas' => __( 'Separate portfolio categories with commas', 'om_portfolio' ),
		'add_or_remove_items' => __( 'Add or remove portfolio categories', 'om_portfolio' ),
		'choose_from_most_used' => __( 'Choose from the most used portfolio categories', 'om_portfolio' ),
		'menu_name' => __( 'Portfolio Categories', 'om_portfolio' )
	);
	
	$args=array (
		'hierarchical' => true, 
		'labels' => $labels,
		'query_var' => true,
		'show_admin_column' => true,
		'rewrite' => array('slug' => 'portfolio-type', 'hierarchical' => true)
	);
	
	$portfolio_cat_slug=get_option('ompf_portfolio_cat_slug');
	$portfolio_cat_slug=sanitize_title_with_dashes($portfolio_cat_slug);
	if( $portfolio_cat_slug ) {
		$args['rewrite']['slug']=$portfolio_cat_slug;
	}
	
	$args=apply_filters('ompf_taxonomy_args', $args);
    
	register_taxonomy(
		'portfolio-type', 
		'portfolio', 
		$args
	);
	
	//flush_rewrite_rules(false);
	
}
add_action( 'init', 'ompf_add_portfolio_taxonomies' );

/***/

function ompf_check_flush_rewrite_rules() {
	if(get_option( 'ompf_do_flush_rewrite_rules' )) {
		flush_rewrite_rules(false);
		delete_option('ompf_do_flush_rewrite_rules');
	}
}
add_action( 'init', 'ompf_check_flush_rewrite_rules' );

/**
 *	Portfolio Sort Page
 */

function ompf_print_styles_portfolio_sort() {
	wp_enqueue_style('nav-menu');
}

function ompf_print_scripts_portfolio_sort() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-sortable');
	
	wp_register_script('ompf-portfolio-sort', $GLOBALS['omPortfolioPlugin']['path_url'] .'assets/js/items-sort.js', array('jquery','jquery-ui-sortable'));
	wp_enqueue_script('ompf-portfolio-sort');
}

function ompf_portfolio_sort_page_add() {
	$page = add_submenu_page('edit.php?post_type=portfolio', __('Sort Portfolio','om_portfolio'), __('Sort Portfolio','om_portfolio'), 'edit_posts', 'portfolio_sort', 'ompf_portfolio_sort_page');
	
	add_action('admin_print_styles-' . $page, 'ompf_print_styles_portfolio_sort');
	add_action('admin_print_scripts-' . $page, 'ompf_print_scripts_portfolio_sort');
}
add_action('admin_menu', 'ompf_portfolio_sort_page_add');

function ompf_portfolio_sort_page() {
	$query = new WP_Query('post_type=portfolio&posts_per_page=-1&orderby=menu_order&order=ASC');
	?>
	<div class="wrap">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br /></div>
		<h2><?php _e('Sort Portfolio', 'om_portfolio'); ?></h2>
		<p><?php _e('Sort portfolio by drag-n-drop. Items at the top will appear first.', 'om_portfolio'); ?></p>
	
		<ul id="portfolio_items">
			<?php while( $query->have_posts() ) : $query->the_post(); ?>
				<?php if( get_post_status() == 'publish' ) { ?>
					<li id="<?php the_id(); ?>" class="menu-item">
						<dl class="menu-item-bar">
							<dt class="menu-item-handle">
								<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
								<?php echo $thumb ? '<span class="menu-item-thumbnail"><img src="'.$thumb[0].'" alt="" style="max-width:45px;vertical-align:middle;margin-right:10px" /></span>' : '' ?><span class="menu-item-title"><?php the_title(); ?></span>
							</dt>
						</dl>
						<ul class="menu-item-transport"></ul>
					</li>
				<?php } ?>
			<?php endwhile; ?>
		</ul>
	</div>
	<script>
		jQuery(document).ready(function($) {
			ompf_items_sort('#portfolio_items','ompf_portfolio_apply_sort');
		});
	</script>
	<?php wp_reset_postdata(); ?>
	<?php
}

function ompf_portfolio_apply_sort() {
	global $wpdb;
	
	$order = explode(',', $_POST['order']);
	$counter = 0;
	
	foreach($order as $portfolio_id) {
		$wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $portfolio_id));
		$counter++;
	}
	exit();
}
add_action('wp_ajax_ompf_portfolio_apply_sort', 'ompf_portfolio_apply_sort');

/**
 * Add column to portfolio posts list
 */
 
add_filter('manage_portfolio_posts_columns', 'ompf_portfolio_columns', 10);
add_action('manage_portfolio_posts_custom_column', 'ompf_portfolio_columns_values', 10, 2);

function ompf_portfolio_columns($defaults) {
	$defaults_=array();
	foreach($defaults as $k=>$v) {
		if($k == 'title')
			$defaults_['portfolio_type']=' ';
		$defaults_[$k]=$v;
	}
	return $defaults_;
}

function ompf_portfolio_columns_values($column_name, $post_ID) {
	if ($column_name == 'portfolio_type') {
		$format=get_post_meta($post_ID, 'ompf_portfolio_type', true);
		if($format == 'custom')
			$format='standard';
		echo '<span class="post-format-icon post-format-'.$format.'"></span>';
	}
}
