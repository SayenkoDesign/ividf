<?php

function ompf_get_options_arr($key) {
	
	$out=array();
	
	switch($key) {
		case 'layout':
			$out = array(
				'fixed' => __('Table view (fixed cells)', 'om_portfolio'),
				'masonry' => __('Masonry (usefull for images with different width/height ratio)', 'om_portfolio'),
			);
		break;
			
		case 'size':
			$out = array(
				'xsmall' => __('X-Small','om_portfolio'),
				'small' => __('Small','om_portfolio'),
				'medium' => __('Medium','om_portfolio'),
				'large' => __('Large','om_portfolio'),
			);
		break;
			
		case 'ratio':
			$out = array(
				'2' => '2:1',
				'1.77777777' => '16:9',
				'1.5' => '3:2',
				'1.33333333' => '4:3',
				'1' => '1:1',
				'0.75' => '3:4',
				'0.66666666' => '2:3',
				'0.5625' => '9:16',
				'0.5' => '1:2',
			);
		break;
			
		case 'preview_layout':
			$out = array(
				'full' => __('Display thumbnail/ title/ description','om_portfolio'),
				'full-hover' => __('Display thumbnail; title/ description on hover, style 1','om_portfolio'),
				'full-hover-2' => __('Display thumbnail; title/ description on hover, style 2','om_portfolio'),
				'thumbnail' => __('Display only thumbnail','om_portfolio'),
			);
		break;
		
		case 'sort':
			$out = array(
				'date_desc' => __('by Date, newer on the top','om_portfolio'),
				'date_asc' => __('by Date, older on the top','om_portfolio'),
				'custom' => __('Custom','om_portfolio'),
			);
		break;

	}
	
	$out=apply_filters('ompf_get_options_arr', $out, $key);
	
	return $out;
}

function ompf_get_term_selector($term) {
	
	$selector=preg_replace('/[^a-zA-Z0-9_-]/','',$term->slug);
	if(!$selector)
		$selector=md5($term->name);
	
	return $selector;
}

function ompf_item_term_classes($post_id) {

	$terms =  get_the_terms( $post_id, 'portfolio-type' ); 
	$terms_list = array();
	if( is_array($terms) ) {
		foreach( $terms as $term ) {
			$selector=ompf_get_term_selector($term);
			$terms_list[]='ompf-'.$selector;
		}
	}
	$terms_list=implode(' ',$terms_list);

	return $terms_list;
}

/**
 * Post gallery images
 */
 
function ompf_get_post_gallery_images($post_id, $params=array()) {

	$attachments=array();
				
	$custom_gallery=get_post_meta($post_id, 'ompf_gallery', true);
	if(is_array($custom_gallery) && $custom_gallery['type'] == 'custom') {
		
		$ids=explode(',',$custom_gallery['images']);
		if(!empty($ids)) {
			
			if(isset($params['only_first']) && $params['only_first'])
				$ids=array_slice($ids,0,1);

			$attachments = get_posts(array(
				'post_type' => 'attachment',
				'orderby' => 'post__in',
				'post__in' => $ids,
				'post_mime_type' => 'image',
				'post_status' => null,
				'numberposts' => -1
			));				
			
		}
		
	} else {
	
		$args=array(
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_type' => 'attachment',
			'post_parent' => $post_id,
			'post_mime_type' => 'image',
			'post_status' => null,
			'numberposts' => -1,
		);
		if(isset($params['only_first']) && $params['only_first'])
			$args['numberposts']=1;

		/*
		if(get_option('ompf_exclude_featured_image') == 'true') {
			if( has_post_thumbnail($post_id) ) {
				$thumbid = get_post_thumbnail_id($post_id);
	
				$args['post__not_in']=array($thumbid);
			}
		}
		*/

		$attachments = get_posts($args);
		
	}

	return $attachments;
	
}

/**
 * Get Post Image
 */

function ompf_get_post_image($post_id) { 

	$attachments = ompf_get_post_gallery_images($post_id, array(
		'only_first' => true
	));

	if( !empty($attachments) ) {
		foreach( $attachments as $attachment ) {
			
	    $src = wp_get_attachment_image_src( $attachment->ID, 'full' );
	    $src['alt'] = ( empty($attachment->post_content) ) ? $attachment->post_title : $attachment->post_content;
	    return $src;
		}
	}
	
	return false;
}

/**
 * Get Post Image
 */

function ompf_get_post_images($post_id) { 

	$attachments = ompf_get_post_gallery_images($post_id);

	$images=array();

	if( !empty($attachments) ) {
		foreach( $attachments as $attachment ) {
			
	    $src = wp_get_attachment_image_src( $attachment->ID, 'full' );
	    $src['alt'] = ( empty($attachment->post_content) ) ? $attachment->post_title : $attachment->post_content;
	    $images[]=$src;
		}
	}
	
	return $images;
}

/**
 * Making navie video player responsive
 */
 
function ompf_set_mediaelementplayer_video_100p($html) {

	if(preg_match('/width="([0-9]+)".*height="([0-9]+)"/',$html,$m) && $m[1]) {
		$html='<div class="ompf-wp-video-wrapper" style="padding-bottom:'.($m[2]/$m[1]*100).'%;" >'.$html.'</div>';
	}

	return $html;
}


/*************************************************************************************
 * Adjacent Custom Post
 *************************************************************************************/

function ompf_get_previous_post($in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category')  && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		return get_previous_post($in_same_cat, $excluded_categories);
	else
		return ompf_get_adjacent_post($in_same_cat, $excluded_categories, true, $taxonomy, $orderby);
}

function ompf_get_next_post($in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		return get_next_post($in_same_cat, $excluded_categories);
	else
		return ompf_get_adjacent_post($in_same_cat, $excluded_categories, false, $taxonomy, $orderby);
}

function ompf_get_adjacent_post( $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy='category', $orderby='post_date' ) {
	global $wpdb;

	if ( ! $post = get_post() )
		return null;

	$current_post_order_val = $post->$orderby;
	/*
	if($orderby == 'menu_order' && $current_post_order_val == 0) {
		$orderby = 'post_date';
		$current_post_order_val = $post->$orderby;
	}
	*/

	$join = '';
	$posts_in_ex_cats_sql = '';
	if ( $in_same_cat || ! empty( $excluded_categories ) ) {
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

		if ( $in_same_cat ) {
			if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) )
				return '';
			$cat_array = wp_get_object_terms($post->ID, $taxonomy, array('fields' => 'ids'));
			if ( ! $cat_array || is_wp_error( $cat_array ) )
				return '';
			$join .= " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
		}

		$posts_in_ex_cats_sql = "AND tt.taxonomy = '".$taxonomy."'";
		if ( ! empty( $excluded_categories ) ) {
			if ( ! is_array( $excluded_categories ) ) {
				// back-compat, $excluded_categories used to be IDs separated by " and "
				if ( strpos( $excluded_categories, ' and ' ) !== false ) {
					$excluded_categories = explode( ' and ', $excluded_categories );
				} else {
					$excluded_categories = explode( ',', $excluded_categories );
				}
			}

			$excluded_categories = array_map( 'intval', $excluded_categories );

			if ( ! empty( $cat_array ) ) {
				$excluded_categories = array_diff($excluded_categories, $cat_array);
				$posts_in_ex_cats_sql = '';
			}

			if ( !empty($excluded_categories) ) {
				$posts_in_ex_cats_sql = " AND tt.taxonomy = '".$taxonomy."' AND tt.term_id NOT IN (" . implode($excluded_categories, ',') . ')';
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare("WHERE p.".$orderby." $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_cats_sql", $current_post_order_val, $post->post_type), $in_same_cat, $excluded_categories );
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.".$orderby." $order LIMIT 1" );

	$query = "SELECT p.id FROM $wpdb->posts AS p $join $where $sort";
	$query_key = 'adjacent_post_' . md5($query);
	$result = wp_cache_get($query_key, 'counts');
	if ( false !== $result ) {
		if ( $result )
			$result = get_post( $result );
		return $result;
	}

	$result = $wpdb->get_var( $query );
	if ( null === $result )
		$result = '';

	wp_cache_set($query_key, $result, 'counts');

	if ( $result )
		$result = get_post( $result );

	return $result;
}

/*************************************************************************************
 * Adjacent Custom Post Link
 *************************************************************************************/

function ompf_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		previous_post_link($format, $link, $in_same_cat, $excluded_categories);
	else
		ompf_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true, $taxonomy, $orderby);
}

function ompf_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '', $taxonomy='category', $orderby='post_date') {
	if((!$in_same_cat || $taxonomy=='category') && $orderby == 'post_date')
		// use standard function for standard parameters - safer
		next_post_link($format, $link, $in_same_cat, $excluded_categories);
	else
		ompf_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false, $taxonomy, $orderby);
}

function ompf_adjacent_post_link( $format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true, $taxonomy='category', $orderby='post_date' ) {
	if ( $previous && is_attachment() )
		$post = get_post( get_post()->post_parent );
	else
		$post = ompf_get_adjacent_post( $in_same_cat, $excluded_categories, $previous, $taxonomy, $orderby );

	if ( ! $post ) {
		$output = '';
	} else {
		$title = $post->post_title;

		if ( empty( $post->post_title ) )
			$title = $previous ? __( 'Previous Post', 'om_portfolio') : __( 'Next Post', 'om_portfolio' );

		$title = apply_filters( 'the_title', $title, $post->ID );
		$date = mysql2date( get_option( 'date_format' ), $post->post_date );
		$rel = $previous ? 'prev' : 'next';

		$string = '<a href="' . get_permalink( $post ) . '" rel="'.$rel.'">';
		$inlink = str_replace( '%title', $title, $link );
		$inlink = str_replace( '%date', $date, $inlink );
		$inlink = $string . $inlink . '</a>';

		$output = str_replace( '%link', $inlink, $format );
	}

	$adjacent = $previous ? 'previous' : 'next';

	echo apply_filters( "{$adjacent}_post_link", $output, $format, $link, $post );
}

/*************************************************************************************
 * Pagination links
 *************************************************************************************/
 
function ompf_pagination_links($paged = false, $max_num_pages = false, $params = array()) {

	if($paged === false) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}
	if($max_num_pages === false) {
		global $wp_query;
		$max_num_pages=$wp_query->max_num_pages;
	}
	$arg=array(
		'base' => str_replace( '999999999', '%#%', esc_url( get_pagenum_link( '999999999' ) ) ),
		'format' => '?paged=%#%',
		'current' => $paged,
		'total' => $max_num_pages,
		'type' => 'array',
		'prev_text' => '',
		'next_text' => '',
	);
	$arg=apply_filters('ompf_portfolio_paginate_links_arg', $arg);
	$links=paginate_links( $arg );
	
	if(!empty($links)) {
		$template=array(
			'before' => '<div class="ompf-portfolio-pagination">',
			'after' => '</div>',
			'before_item' => ' ',
			'after_item' => ' ',
		);
		$template=apply_filters('ompf_portfolio_paginate_links_template', $template);
		$links_html='';
		$links_html .= $template['before'];
		for($i=0;$i<count($links);$i++) {
			if(preg_match('#/page/([0-9]+)/#', $links[$i], $m ) || preg_match('#paged=([0-9]+)#', $links[$i], $m )) {
				$links[$i]=str_replace('<a','<a data-page-number="'.$m[1].'"',$links[$i]);
			}
			if(isset($params['empty_href']) && $params['empty_href']) {
				$links[$i]=preg_replace('#href=(["\'])[^"\']+?(["\'])#','href=$1#$2',$links[$i]);
			}
		}
		foreach($links as $v) {
			$links_html .= $template['before_item'] . $v . $template['after_item'];
		}
		$links_html .= $template['after'];
	}
	else
		$links_html='';
		
	$links_html=apply_filters('ompf_portfolio_pagination', $links_html, $links);
	
	return $links_html;	
	
}

/*************************************************************************************
 * Loadmore link
 *************************************************************************************/
 
function ompf_loadmore_link($paged = false, $max_num_pages = false, $params = array()) {

	$links_html='';

	if($max_num_pages > 1 && $paged < $max_num_pages) {
		if(isset($params['empty_href']) && $params['empty_href']) {
			$href='#';
		} else {
		 	$href=get_pagenum_link( (intval($paged)+1) );
		}
		$links_html = '<a href="'.$href.'" class="ompf-loadmore-link" id="ompf-loadmore-link">'.__('Load more', 'om_theme').'</a>';
	}
	
	return $links_html;	
	
}

/*************************************************************************************
 * Portfolio Root Page ID
 *************************************************************************************/
 
function ompf_get_portfolio_root_page($portfolio_post_id) {

	$args = array(
		'post_type' => 'page',
		'posts_per_page' => 1,
		'meta_query' => array(
			array(
				'key' => 'ompf_portfolio_display',
				'value' => '1',
			)
		)
	);
	
	$terms=get_the_terms($portfolio_post_id, 'portfolio-type');
	if(!empty($terms)) {
		$term=reset($terms);
		if($term->parent) {
			$term=get_term($term->parent,'portfolio-type');
			while($term->parent)
				$term=get_term($term->parent,'portfolio-type');
		}

		$args['meta_query'][]=array(
			'key' => 'ompf_portfolio_categories',
			'value' => array('0','',$term->term_id),
			'compare' => 'IN',
		);
	}
	$tmp_q = new WP_Query($args);
	if($tmp_q->post_count) {
		$portfolio_page=$tmp_q->posts[0];
	} else {
		unset($args['meta_query'][1]);
		$tmp_q = new WP_Query($args);
		if($tmp_q->post_count)
			$portfolio_page=$tmp_q->posts[0];
		else
			$portfolio_page=false;
	}
	wp_reset_postdata();
	
	return $portfolio_page;
}

/*************************************************************************************
 * Escaping
 *************************************************************************************/
 
function ompf_esc_embed($string) {

	$string=wp_kses(
		$string,
		array_merge(
			wp_kses_allowed_html( 'post' ),
			array(
				'iframe' => array(
					'width' => true,
					'height' => true,
					'src' => true,
					'scrolling' => true,
					'frameborder' => true,
					'style' => true,
					'allowfullscreen' => true,
				),
			)
		)
	);
	
	return $string;
	
}
