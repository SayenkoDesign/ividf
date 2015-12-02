<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	
	<div class="om-c-container">
		<div class="om-c-container-inner">
			
	<?php 
	$tags='';
	if(get_option(OM_THEME_PREFIX . 'post_hide_tags') != 'true')
		$tags=get_the_tag_list('<span class="post-tags">', ', ', '</span>' );
		
	$categories='';
	if(get_option(OM_THEME_PREFIX . 'post_hide_categories') != 'true') {
		$categories = get_the_category_list(', ');
		if($categories)
			$categories='<span class="post-categories">'.$categories.'</span>';
	}
	
	$comments='';
	if(empty($post->post_password) && get_option(OM_THEME_PREFIX . 'hide_comments_post') != 'true') {
		ob_start();
		comments_popup_link( '<span class="comments-count">0</span>', '<span class="comments-count">1</span>', '<span class="comments-count">%</span>', '', '');
		$comments=ob_get_clean();
		if($comments)
			$comments='<span class="post-comments">'.$comments.'</span>';
	}
	
	$time='';
	if(get_option(OM_THEME_PREFIX . 'post_hide_date') != 'true') {
		$time='<span class="post-date">' . get_the_time(get_option('date_format')) .'</span>';
	}
	
	$author='';
	if(get_option(OM_THEME_PREFIX . 'post_hide_author') != 'true') {
		ob_start();
		the_author_posts_link();
		$author=ob_get_clean();
		if($author)
			$author='<span class="post-author"><span>'. __('by','om_theme').' </span> '. $author .'</span>';
	}
	
	$meta=array();
	if($time)
		$meta[]=$time;
	if($author)
		$meta[]=$author;
	if($categories)
		$meta[]=$categories;
	if($tags)
		$meta[]=$tags;
	if($comments)
		$meta[]=$comments;
	
	?>
	<?php if(!empty($meta)) { ?>
		<div class="post-meta">
			<?php echo implode(' <span class="post-meta-divider"></span> ',$meta) ?>
		</div>
	<?php } ?>
	
		</div>
	</div>