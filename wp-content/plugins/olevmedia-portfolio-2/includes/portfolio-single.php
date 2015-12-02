<?php



	$format=get_post_meta($post->ID, 'ompf_portfolio_type', true);

	if(!$format)

		$format='custom';

		

	$ratio = get_post_meta($post->ID, 'ompf_portfolio_column_ratio', true);

	if(!$ratio)

		$ratio='2v1';

		

	$position = get_post_meta($post->ID, 'ompf_portfolio_media_position', true);

	if(!$position)

		$position='left';

		

	if($GLOBALS['omPortfolioPlugin']['config']['theme_support_width100'])

		$width100 = get_post_meta($post->ID, 'ompf_portfolio_column_ratio_width100', true);

	else

		$width100=false;



	do_action('ompf_portfolio_single_before');

	

	$portfolio_header='<div class="ompf-portfolio-single ompf-format-'.$format.' ompf-ratio-'.$ratio.' ompf-media-position-'.$position.( $width100 ? ' ompf-media-width100' : '' ).'">';

	$portfolio_footer='<div class="ompf-clear"></div></div>';

	$portfolio_html='';



	if($format == 'custom') {

		

		$portfolio_html = $portfolio_header.$content.$portfolio_footer;

		$media='';

		$terms='';



	} else {

		

		// buffer media block

		ob_start();



			if(has_action('ompf_portfolio_single_'.$format.'_media')) {

				

				do_action('ompf_portfolio_single_'.$format.'_media');

				

			} else {

				

				$file=$GLOBALS['omPortfolioPlugin']['path']. 'includes/portfolio-single-media-' . $format . '.php';

				if(!file_exists($file) && strpos($format, '-') !== false)

					$file=$GLOBALS['omPortfolioPlugin']['path']. 'includes/portfolio-single-media-' . substr($format, 0, strpos($format, '-') ) . '.php';

				

				if(file_exists($file)) {

					include $file;

				}

				

			}

			

    $media = ob_get_clean();



    $terms=get_the_term_list($post->ID, 'portfolio-type', '<div class="ompf-portfolio-single-categories">', '<span class="ompf-portfolio-single-categories-divider"></span>', '</div>');

    

    

    $portfolio_html.=$portfolio_header;

		if($position == 'left') {

			$portfolio_html.= '<div class="ompf-portfolio-single-media">'.$media.'</div>';

			$portfolio_html.= '<div class="ompf-portfolio-single-description"><div class="ompf-portfolio-single-description-inner">'.$content.$terms.'</div></div>';

		} else {

			$portfolio_html.= '<div class="ompf-portfolio-single-description"><div class="ompf-portfolio-single-description-inner">'.$content.$terms.'</div></div>';

			$portfolio_html.= '<div class="ompf-portfolio-single-media">'.$media.'</div>';

		}

		$portfolio_html.=$portfolio_footer;

    

	}



	echo apply_filters('ompf_portfolio_single_inner', $portfolio_html, array(

		'format' => $format,

		'ratio' => $ratio,

		'position' => $position,

		'content' => $content,

		'media' => $media,

		'terms' => $terms,

		'width100' => $width100,

		'header_html' => $portfolio_header,

		'footer_html' => $portfolio_footer,

	));

	unset($portfolio_html);



	do_action('ompf_portfolio_single_after');

	

		// Prev/Next Navigation

	

		$prev_next=get_option('ompf_portfolio_prev_next');

		if($prev_next != 'none') {

			$in_same_cat=($prev_next == 'category');

			

			$portfolio_root_page=ompf_get_portfolio_root_page($post->ID);

			if($portfolio_root_page) {

				$sort = get_post_meta($portfolio_root_page->ID, 'ompf_portfolio_sort', true);

				if(!$sort)

					$sort = 'date_desc';

			} else {

			 	$sort = 'date_desc';

			}

			

			if($sort == 'date_asc' || $sort == 'date_desc')

				$orderby='post_date';

			else

				$orderby='menu_order';

				

			$template=array(

				'before' => '<div class="ompf-navigation-prev-next">',

				'after' => '<div class="ompf-clear"></div></div>',

				'before_prev' => '<div class="ompf-navigation-prev">',

				'after_prev' => '</div>',

				'before_next' => '<div class="ompf-navigation-next">',

				'after_next' => '</div>',

				'link_tpl' => '%link',

				'title_tpl_prev' => '&larr; %title',

				'title_tpl_next' => '%title &rarr;',

			);

			$template=apply_filters('ompf_prev_next_single_navigation', $template);

	

			if($sort == 'date_desc') {

				$is_prev = ompf_get_previous_post($in_same_cat, '', 'portfolio-type', $orderby);

				$is_next = ompf_get_next_post($in_same_cat, '', 'portfolio-type', $orderby);

				if( $is_prev || $is_next ) {

					echo $template['before'];

						if ($is_next) { echo $template['before_prev']; ompf_next_post_link($template['link_tpl'], $template['title_tpl_prev'], $in_same_cat, '', 'portfolio-type', $orderby); echo $template['after_prev']; }

						if ($is_prev) { echo $template['before_next']; ompf_previous_post_link($template['link_tpl'], $template['title_tpl_next'], $in_same_cat, '', 'portfolio-type', $orderby); echo $template['after_next']; }

					echo $template['after'];

				}

			} else {

				$is_prev = ompf_get_previous_post($in_same_cat, '', 'portfolio-type', $orderby);

				$is_next = ompf_get_next_post($in_same_cat, '', 'portfolio-type', $orderby);

				if( $is_prev || $is_next ) {

					echo $template['before'];

						if ($is_prev) { echo $template['before_prev']; ompf_previous_post_link($template['link_tpl'], $template['title_tpl_prev'], $in_same_cat, '', 'portfolio-type', $orderby); echo $template['after_prev']; }

						if ($is_next) { echo $template['before_next']; ompf_next_post_link($template['link_tpl'], $template['title_tpl_next'], $in_same_cat, '', 'portfolio-type', $orderby); echo $template['after_next']; }

					echo $template['after'];

				}

			}

		}

	?>

	

	<?php

	

		// Random items

	

		$random_items=get_option('ompf_portfolio_single_show_random');

		if($random_items)

			$size=$random_items;

		$title=get_option('ompf_portfolio_random_title');

		if($title===false)

			$title=__('Random Items','om_theme');

	?>



	<?php if($random_items && $title) { ?>

		<h2 class="ompf-portfolio-random-items-title"><?php echo $title ?></h2>

	<?php } ?>

			

	<?php	if($random_items) { ?>

		

		<?php

		

		if(isset($GLOBALS['omPortfolioPlugin']['config']['preview_items_per_row'][$random_items]))

			$count=$GLOBALS['omPortfolioPlugin']['config']['preview_items_per_row'][$random_items];

		else

			$count=5;



		$args=array(

			'portfolio_post_id' => false,

			'layout' => 'fixed',

			'size' => $size,

			'ratio' => get_option('ompf_portfolio_single_random_ratio'),

			'preview_layout' => 'full',

		);



		$args['query_args']=array(

			'posts_per_page' => $count,

			'orderby' => 'rand',

			'order' => 'ASC',

		);		

			

		$portfolio=ompf_get_portfolio_thumbnails($args);

			

		$uberwrapper_classes=array('ompf-portfolio-wrapper');

		$uberwrapper_classes=apply_filters('ompf_portfolio_random_wrapper_classes', $uberwrapper_classes);

	

		$wrapper_classes=array('ompf-portfolio');

		$wrapper_classes[]='ompf-layout-fixed';

		$wrapper_classes[]='ompf-size-'.$size;

		$wrapper_classes[]='ompf-preview-layout-full';

		$wrapper_classes=apply_filters('ompf_portfolio_random_classes', $wrapper_classes);	

		

		$tmp = '

		<div class="'. implode(' ',$uberwrapper_classes) .'">

			<div class="'. implode(' ',$wrapper_classes) .'"'.($GLOBALS['omPortfolioPlugin']['config']['fit_thumbnails_height']?' data-fit-height="true"':'').'>

		';

		$tmp=apply_filters('ompf_portfolio_random_header', $tmp);

		echo $tmp;

				

		echo $portfolio['html'];

		

		$tmp = '

				<div class="ompf-clear"></div>

			</div>	

		</div>

		';

		$tmp=apply_filters('ompf_portfolio_random_footer', $tmp);

		echo $tmp;



	}