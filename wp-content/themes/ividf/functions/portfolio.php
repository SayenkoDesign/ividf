<?php

/**
 * Config
 */

function om_ompf_plugin_config($config) {
	
	$config['include_isotope_js']=false;
	$config['theme_supplies_page_template']=true;
	$config['theme_supplies_portfolio_single_template']=true;
	$config['theme_supplies_portfolio_archive_template']=true;
	if(get_option(OM_THEME_PREFIX."lazyload") == 'true') {
		$config['enable_lazyload_markup']=true;
		$config['lazyload_placeholder']=TEMPLATE_DIR_URI . '/img/e.png';
	}
	if(get_option(OM_THEME_PREFIX . 'responsive') != 'true') {
		$config['responsive_mode']=false;
	}
	$config['theme_support_portfolio_width100']=true;
	
	return $config;
	
}
add_filter('ompf_config','om_ompf_plugin_config');


/**
 * Portfolio template <-> display portfolio options
 */
 
function om_ompf_after_switch_theme($theme) {

	// apply Portfolio template for pages with "display portfolio" option enabled	
	if(isset($GLOBALS['omPortfolioPlugin'])) {
		$q = new WP_Query(array(
			'post_type' => 'page',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'ompf_portfolio_display',
					'value' => '1',
				)
			)
		));
		if($q->post_count) {
			foreach($q->posts as $post) {
				update_post_meta($post->ID, '_wp_page_template', 'template-portfolio.php');
			}
		}
	}
	
}
add_action('after_switch_theme', 'om_ompf_after_switch_theme'); 


function om_ompf_save_post($post_id) {

	// if portfolio template chosen, "display portfolio" page meta should be also updated
	if(isset($_POST['post_type']) && $_POST['post_type'] == 'page') {
		if(isset($_POST['page_template']) && $_POST['page_template'] == 'template-portfolio.php')
			update_post_meta($post_id, 'ompf_portfolio_display', '1');
		else
			update_post_meta($post_id, 'ompf_portfolio_display', '0');
	}
}
add_action('save_post', 'om_ompf_save_post');

/**
 * Pagination, navigation
 */
 
function om_ompf_portfolio_paginate_links_template($template) {

	$template=array_merge($template,array(
		'before' => '<div class="navigation-pages wp-link-pages ompf-portfolio-pagination"><div class="navigation-pages-inner">',
		'after' => '</div><div class="clear"></div></div>',
		'before_item' => '',
		'after_item' => '',
	));
							
	return $template;
}
add_filter('ompf_portfolio_paginate_links_template','om_ompf_portfolio_paginate_links_template');

function om_ompf_portfolio_pagination($links_html, $links) {
	
	if(!empty($links)) {
		foreach($links as $v) {
			if(strpos($v,'<a') !== false) {
				$v_=str_replace("'>","'><span>",$v);
				$v_=str_replace('</a','</span></a',$v_);
				$links_html=str_replace($v,$v_,$links_html);
			}
		}
	}
	
	return $links_html;
	
}
add_filter('ompf_portfolio_pagination', 'om_ompf_portfolio_pagination', 10, 2);

function om_ompf_portfolio_paginate_links_arg($args) {
	
	$args['prev_text']='<span></span>';
	$args['next_text']='<span></span>';
	
	return $args;
	
}
add_filter('ompf_portfolio_paginate_links_arg', 'om_ompf_portfolio_paginate_links_arg');

function om_ompf_prev_next_single_navigation($template) { 
	
	$template=array_merge($template,array(
		'before' => '<div class="navigation-prev-next"><div class="container">',
		'after' => '<div class="clear"></div></div></div>',
		'before_prev' => '<div class="navigation-prev">',
		'after_prev' => '</div>',
		'before_next' => '<div class="navigation-next">',
		'after_next' => '</div>',
		'title_tpl_prev' => '%title',
		'title_tpl_next' => '%title',
	));
	
	return $template;
}
add_filter('ompf_prev_next_single_navigation', 'om_ompf_prev_next_single_navigation');

/*
//[foobar]
function foobar_func( $template ){ echo "erer"; exit;
	$template=array_merge($template,array(
		'before' => '<div class="navigation-prev-next">',
		'after' => '<div class="clear"></div></div>',
		'before_prev' => '<div class="navigation-prev">',
		'after_prev' => '</div>',
		'before_next' => '<div class="navigation-next">',
		'after_next' => '</div>',
		'title_tpl_prev' => '%title',
		'title_tpl_next' => '%title',
	));
	
	return $template;
}
add_shortcode( 'foobar', 'foobar_func' );*/


/**
 * Helper
 */ 
 
function om_ompf_insert_before ($array, $key, $new) {
	$keys = array_keys($array);
	$pos = (int) array_search($key, $keys);
	return array_merge(
		array_slice($array, 0, $pos),
		$new,
		array_slice($array, $pos)
	);
}

/**
 * Gallery options
 */

function om_ompf_portfolio_meta_box($arr) {
	
	$arr['type']['fields']=om_ompf_insert_before($arr['type']['fields'], 'ompf_portfolio_gallery_columns', array(
		'ompf_portfolio_gallery_mode' => array (
			'name' => __('Gallery mode','om_theme'),
			'desc' => '',
			'id' => OM_THEME_SHORT_PREFIX.'gallery_mode',
			'type' => 'select',
			'std' => '',
			'options' => array(
				'' => __('Slider', 'om_theme'),
				'sliced' => __('Sliced', 'om_theme'),
				'grid' => __('Grid', 'om_theme'),
				'masonry' => __('Masonry', 'om_theme'),
			),
			'code' => '
				<script>
					jQuery(function($){
						$("#ompf_portfolio_type").change(function(){
							if($(this).val() == "gallery") {
								$("#'.OM_THEME_SHORT_PREFIX.'gallery_mode").parents("tr").show();
							} else {
								$("#'.OM_THEME_SHORT_PREFIX.'gallery_mode").parents("tr").hide();
							}
						}).change();
					});
				</script>
			',
		),
		
		'ompf_portfolio_gallery_ratio' => array (
			'name' => __('Gallery Images Width/Height Ratio','om_theme'),
			'desc' => '',
			'id' => OM_THEME_SHORT_PREFIX.'gallery_ratio',
			'type' => 'select',
			'std' => '3:2',
			'options' => array(
				'2:1' => '2:1',
				'16:9' => '16:9',
				'3:2' => '3:2',
				'4:3' => '4:3',
				'1:1' => '1:1',
				'3:4' => '3:4',
				'2:3' => '2:3',
				'9:16' => '9:16',
				'1:2' => '1:2',
			),
			'code' => '
				<script>
					jQuery(function($){
						function check() {
							if($("#ompf_portfolio_type").val() == "gallery" && $("#'.OM_THEME_SHORT_PREFIX.'gallery_mode").val() == "grid") {
								$("#'.OM_THEME_SHORT_PREFIX.'gallery_ratio").parents("tr").show();
							} else {
								$("#'.OM_THEME_SHORT_PREFIX.'gallery_ratio").parents("tr").hide();
							}							
						}
						$("#ompf_gallery_type").change(check);
						$("#'.OM_THEME_SHORT_PREFIX.'gallery_mode").change(check);
						check();
					});
				</script>
			', 
		),
		
		'ompf_portfolio_gallery_captions' => array (
			'name' => __('Gallery Image Captions','om_theme'),
			'desc' => '',
			'id' => OM_THEME_SHORT_PREFIX.'gallery_captions',
			'type' => 'select',
			'std' => '',
			'options' => array(
				'' => __('Hide', 'om_theme'),
				'true' => __('Display image captions', 'om_theme'),
			),
			'code' => '
				<script>
					jQuery(function($){
						$("#ompf_portfolio_type").change(function(){
							if($(this).val() == "gallery") {
								$("#'.OM_THEME_SHORT_PREFIX.'gallery_captions").parents("tr").show();
							} else {
								$("#'.OM_THEME_SHORT_PREFIX.'gallery_captions").parents("tr").hide();
							}
						}).change();
					});
				</script>
			', 
		),
		
	));
	
	$arr['type']['fields']['ompf_portfolio_gallery_columns']=array(
		'name' => __('Number of Columns in Gallery','om_theme'),
		'desc' => '',
		'id' => OM_THEME_SHORT_PREFIX.'gallery_columns',
		'type' => 'select',
		'std' => '3',
		'options' => array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
			'6' => '6',
			'7' => '7',
			'8' => '8',
			'9' => '9',
		),
		'code' => '
			<script>
				jQuery(function($){
					function check() {
						if($("#ompf_portfolio_type").val() == "gallery" && ($("#'.OM_THEME_SHORT_PREFIX.'gallery_mode").val() == "grid" || $("#'.OM_THEME_SHORT_PREFIX.'gallery_mode").val() == "masonry")) {
							$("#'.OM_THEME_SHORT_PREFIX.'gallery_columns").parents("tr").show();
						} else {
							$("#'.OM_THEME_SHORT_PREFIX.'gallery_columns").parents("tr").hide();
						}							
					}
					$("#ompf_gallery_type").change(check);
					$("#'.OM_THEME_SHORT_PREFIX.'gallery_mode").change(check);
					check();
				});
			</script>
		', 
	);
	
	om_add_common_meta_boxes($arr, array('pagetitle', 'slider', 'header'), 'ompf-portfolio-meta-box-');	
	
	return $arr;
} 
add_filter('ompf_portfolio_meta_box', 'om_ompf_portfolio_meta_box');

function om_ompf_single_media_gallery($args) {

	$size='post-media-large';
		
	$gallery = om_get_custom_gallery(
		get_the_ID(),
		array(
			'image_size' => $size,
			'show_captions' => (get_post_meta(get_the_ID(), OM_THEME_SHORT_PREFIX.'gallery_captions', true) == 'true'),
			'mode' => get_post_meta(get_the_ID(), OM_THEME_SHORT_PREFIX.'gallery_mode', true),
			'ratio' => get_post_meta(get_the_ID(), OM_THEME_SHORT_PREFIX.'gallery_ratio', true),
			'columns' => get_post_meta(get_the_ID(), OM_THEME_SHORT_PREFIX.'gallery_columns', true),
			'custom_gallery_field_name' => 'ompf_gallery',
		)
	);
	if($gallery) {
		echo '<div class="ompf-portfolio-gallery-block">'.$gallery.'</div>';
	}
	
}
add_filter('ompf_single_media_gallery','om_ompf_single_media_gallery');

function om_ompf_single_media_image_block($html, $arr) {
	
	return om_hover_extras('<img src="'.$arr['img_src'].'" alt="'.esc_attr($arr['img_alt']).'" />', $arr['full_link'], false, 'rel="prettyPhoto[portfoliogal]"');

}
add_filter('ompf_single_media_image_block','om_ompf_single_media_image_block', 10, 2);

/**
 * Options page
 */

function om_ompf_portfolio_options($options) {
	
	$options=array_merge($options, array(
		
		'archive_category_page_settings' => array(
			'name' => __('Pull portfolio layout settings for Archive/Category pages from page:', 'om_portfolio'),
			'desc' => '',
			'id' =>  'ompf_archive_category_page_settings',
			'std' => '',
			'type' => 'select_page',
		),
	) );
	
	return $options;
}
add_filter('ompf_portfolio_options','om_ompf_portfolio_options');

