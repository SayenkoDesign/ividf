<?php
	
	$arg = array (
		'type' => 'portfolio',
		'taxonomy' => 'portfolio-type',
	);
	if($portfolio_category) {
		$arg['child_of']=$portfolio_category;
	}
				
	$arg['orderby']=get_post_meta($portfolio_post_id, 'ompf_portfolio_categories_sort', true);
	if(!$arg['orderby'])
		$arg['orderby']='name';
	elseif($arg['orderby'] == 'count')
		$arg['order']='desc';

	$arg=apply_filters('ompf_portfolio_categories_query', $arg);
	
	$categories=get_categories( $arg );

	/** categories **/
	$tmp = '';
	if(!empty($categories)) {
		$wrapper_classes=array('ompf-portfolio-categories-wrapper');
		$wrapper_classes=apply_filters('ompf_portfolio_categories_wrapper_classes', $wrapper_classes);
		
		$menu_classes=array('ompf-portfolio-categories','ompf-clearfix');
		$menu_classes=apply_filters('ompf_portfolio_categories_menu_classes', $menu_classes);
		
		$tmp .= '
			<div class="'. implode(' ',$wrapper_classes) .'">
				<ul class="'. implode(' ',$menu_classes) .'">
					<li><a href="#" data-filter="" data-category-id="" class="ompf-active">'. __('All', 'om_portfolio') .'</a></li>
		';
		foreach($categories as $category) {
			if(!$category->count)
				continue;
			$selector=ompf_get_term_selector($category);
			$tmp .= '<li><a href="'.get_term_link($category, 'portfolio-type').'" data-filter="'.$selector.'" data-category-id="'.$category->term_id.'">'.$category->name.'</a></li>';
		}
		$tmp .= '
				</ul>
				<div class="ompf-clear"></div>
			</div>
		';
	} 
	
	$tmp=apply_filters('ompf_portfolio_categories_html', $tmp);
	echo $tmp;
	/** /categories **/
