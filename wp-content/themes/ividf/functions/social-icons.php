<?php

/*************************************************************************************
 * Social Icons list
 *************************************************************************************/

if( !function_exists( 'om_social_icons_list' ) ) { 
	function om_social_icons_list() {
		return array(
			'aim'=>__('AIM','om_theme'),
			'amazon'=>__('Amazon','om_theme'),
			'apple'=>__('Apple','om_theme'),
			'appstore'=>__('AppStore','om_theme'),
			'basecamp'=>__('BaseCamp','om_theme'),
			'bebo'=>__('Bebo','om_theme'),
			'behance'=>__('Behance','om_theme'),
			'bing'=>__('Bing','om_theme'),
			'blogger'=>__('Blogger','om_theme'),
			'creativecommons'=>__('CreativeCommons','om_theme'),
			'delicious'=>__('Delicious','om_theme'),
			'devianart'=>__('Devianart','om_theme'),
			'digg'=>__('Digg','om_theme'),
			'dribble'=>__('Dribble','om_theme'),
			'dropbox'=>__('Dropbox','om_theme'),
			'drupal'=>__('Drupal','om_theme'),
			'ember'=>__('Ember','om_theme'),
			'evernote'=>__('Evernote','om_theme'),
			'facebook'=>__('Facebook','om_theme'),
			'feedburner'=>__('FeedBurner','om_theme'),
			'flickr'=>__('Flickr','om_theme'),
			'forrst'=>__('Forrst','om_theme'),
			'friendfeed'=>__('Friendfeed','om_theme'),
			'friendster'=>__('Friendster','om_theme'),
			'github'=>__('GitHub','om_theme'),
			'github2'=>__('GitHub2','om_theme'),
			'googleplus'=>__('Google+','om_theme'),
			'gowalla'=>__('Gowalla','om_theme'),
			'grooveshark'=>__('GrooveShark','om_theme'),
			'icq'=>__('ICQ','om_theme'),
			'instagram'=>__('Instagram','om_theme'),
			'lastfm'=>__('last.fm','om_theme'),
			'linkedin'=>__('LinkedIn','om_theme'),
			'livejournal'=>__('Livejournal','om_theme'),
			'lovedsgn'=>__('Lovedsgn','om_theme'),
			'msnmessenger'=>__('MSNmessenger','om_theme'),
			'myspace'=>__('MySpace','om_theme'),
			'newsvine'=>__('Newsvine','om_theme'),
			'openid'=>__('OpenID','om_theme'),
			'photobucket'=>__('PhotoBucket','om_theme'),
			'picasa'=>__('Picasa','om_theme'),
			'pinterest'=>__('Pinterest','om_theme'),
			'plixi'=>__('Plixi','om_theme'),
			'reddit'=>__('reddit','om_theme'),
			'rss'=>__('RSS','om_theme'),
			'sharethis'=>__('ShareThis','om_theme'),
			'simplenote'=>__('Simplenote','om_theme'),
			'skype'=>__('Skype','om_theme'),
			'slideshare'=>__('SlideShare','om_theme'),
			'smugmug'=>__('SmugMug','om_theme'),
			'soundcloud'=>__('SoundCloud','om_theme'),
			'squarespace'=>__('Squarespace','om_theme'),
			'squidoo'=>__('Squidoo','om_theme'),
			'stumbleupon'=>__('Stumbleupon','om_theme'),
			'technorati'=>__('Technorati','om_theme'),
			'tumblr'=>__('Tumblr','om_theme'),
			'twitter'=>__('Twitter','om_theme'),
			'vimeo'=>__('Vimeo','om_theme'),
			'wordpress'=>__('WordPress','om_theme'),
			'yahoo'=>__('Yahoo','om_theme'),
			'youtube'=>__('YouTube','om_theme'),
		);
	}
}

/*************************************************************************************
 * Social Icons HTML List
 *************************************************************************************/

if( !function_exists( 'om_get_social_icons_html' ) ) { 
	function om_get_social_icons_html($prefix='social-icon-', $classes='', $divider='') {
		
		$socials=wp_cache_get( 'social_icons', 'om_theme' );
		if($socials !== false)
			return $socials;
			
		if($classes)
			$classes=' '.trim($classes);
			
		$icons=om_social_icons_list();
		if(function_exists('om_social_icons_sort'))
			om_social_icons_sort($icons);
			
		$arr=array();
		foreach($icons as $k=>$v) {
			if($url=get_option(OM_THEME_PREFIX . 'social_'.$k))
				$arr[]='<a href="'.esc_attr($url).'" class="om-social-icon '.esc_attr($prefix.$k.$classes).'" title="'.esc_attr($v).'" target="_blank"></a>';
		}
		$socials=implode($divider, $arr);
		wp_cache_set( 'social_icons', $socials, 'om_theme' );
		
		return $socials;
		
	}
}

/*************************************************************************************
 *	Social Icons Sort Page
 *************************************************************************************/

function om_social_icons_sort_page_add() {
	add_submenu_page('options.php', __('Sort Social Icons','om_theme'), __('Sort Social Icons','om_theme'), 'edit_posts', 'social_icons_sort', 'om_social_icons_sort_page');
}
add_action('admin_menu', 'om_social_icons_sort_page_add');

function om_enqueue_scripts_social_icons_sort($hook) {
	if('admin_page_social_icons_sort' != $hook)
		return;
		
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('om-social-icons-sort', TEMPLATE_DIR_URI.'/admin/js/items-sort.js', array('jquery','jquery-ui-sortable'));
}
add_action('admin_enqueue_scripts', 'om_enqueue_scripts_social_icons_sort');

if( !function_exists( 'om_social_icons_sort' ) ) { 
	function om_social_icons_sort(&$list) {
		$order=get_option(OM_THEME_PREFIX . 'social_icons_order');
	
		if($order) {
			$order=explode(',',$order);
			$new_list=array();
			if(is_array($order)) {
				foreach($order as $k) {
					if(isset($list[$k])) {
						$new_list[$k]=$list[$k];
						unset($list[$k]);
					}
				}
			}
			$list=array_merge($new_list,$list);
		}
	}
}

function om_social_icons_sort_page() {
	$list=om_social_icons_list();
	om_social_icons_sort($list);

	?>
	<div class="wrap">
		<div id="icon-edit-pages" class="icon32 icon32-posts-page"><br /></div>
		<h2><?php _e('Sort Social Icons', 'om_theme'); ?></h2>
		<p><?php _e('Sort icons by drag-n-drop. Items at the top will appear first.', 'om_theme'); ?></p>
	
		<ul id="social_icons_items">
			<?php foreach($list as $k=>$v) { ?>
				<li id="<?php echo esc_attr($k); ?>" class="menu-item">
					<dl class="menu-item-bar">
						<dt class="menu-item-handle">
							<span class="menu-item-title"><?php echo esc_html($v) ?></span>
						</dt>
					</dl>
					<ul class="menu-item-transport"></ul>
				</li>
			<?php } ?>
		</ul>
	</div>
	<script>
		jQuery(document).ready(function($) {
			om_items_sort('#social_icons_items','social_icons_apply_sort');
		});
	</script>
	<?php wp_reset_postdata(); ?>
	<?php
}

function om_social_icons_apply_sort() {
	global $wpdb;
	
	update_option(OM_THEME_PREFIX . 'social_icons_order', $_POST['order']);

	exit();
	
}
add_action('wp_ajax_social_icons_apply_sort', 'om_social_icons_apply_sort');