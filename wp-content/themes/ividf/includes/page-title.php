<?php

	$custom_settings=false;	
	$post_title_layout=false;
	
	if($post_id) {
		$post_title_layout=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'page_title', true);
		if($post_title_layout)
			$custom_settings=true;
		else
			$post_title_layout=get_option(OM_THEME_PREFIX . 'default_page_title');
	} else {
		$post_title_layout=get_option(OM_THEME_PREFIX . 'default_page_title');
	}
	if(!$post_title_layout) {
		$post_title_layout='standard';
	}
	
	if($post_title_layout != 'hide') {

		if($custom_settings) {
			$post_title_align=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_align', true);
			$post_title_margins=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_margins', true);
			$post_title_size=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_size', true);
		} else {
			$post_title_align=get_option(OM_THEME_PREFIX . 'default_title_align');
			$post_title_margins=get_option(OM_THEME_PREFIX . 'default_title_margins');
			$post_title_size=get_option(OM_THEME_PREFIX . 'default_title_size');
		}

		$classes=array(
			'page-title-wrapper',
		);
		$classes[]='tpl-'.$post_title_layout;
			
		if($post_title_align)
			$classes[]='title-align-'.$post_title_align;
			
		if($post_title_margins && $post_title_layout != 'standard')
			$classes[]='title-margins-'.$post_title_margins;
			
		if($post_title_size && $post_title_layout != 'standard')
			$classes[]='title-size-'.$post_title_size;
		
		$styles=array();
		
		if( in_array($post_title_layout, array('color','image','parallax')) ) {
			if($custom_settings) {
				$bg_color=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_bg_color', true);
			} else {
				$bg_color=get_option(OM_THEME_PREFIX . 'default_title_bg_color');
			}
			if($bg_color && ( strcasecmp($bg_color, 'theme') != 0 || strcasecmp($bg_color, 'default') != 0 ) ){
				$styles[]='background-color:'.$bg_color;
			}
			
			if($custom_settings) {
				$text_color=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_text_color', true);
			} else {
				$text_color=get_option(OM_THEME_PREFIX . 'default_title_text_color');
			}
			if($text_color) {
				if(strcasecmp($text_color, 'theme') == 0  ) {
					$classes[]='hightlight-color';
				} else {
					$styles[]='color:'.$text_color;
				}
			}
		}
		
		if($post_title_layout == 'color') {

		} elseif($post_title_layout == 'image') {
			
			if($custom_settings) {
				$bg_img=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_bg_img', true);
				$bg_img_pos=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_bg_img_pos', true);
				$bg_img_att=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_bg_img_att', true);
			} else {
				$bg_img=get_option(OM_THEME_PREFIX . 'default_title_bg_img');
				$bg_img_pos=get_option(OM_THEME_PREFIX . 'default_title_bg_img_pos');
				$bg_img_att=get_option(OM_THEME_PREFIX . 'default_title_bg_img_att');
			}

			if($bg_img){
				$styles[]='background-image:url('.$bg_img.')';
			}
			if($bg_img_pos)
				$styles=array_merge($styles,om_bg_img_pos_style($bg_img_pos));
				
			if($bg_img_att == 'fixed')
				$styles[]='background-attachment:fixed';
				
		} elseif($post_title_layout == 'parallax') {
			
			if($custom_settings) {
				$effect=get_post_meta($post_id, OM_THEME_SHORT_PREFIX.'title_parallax', true);
			} else {
				$effect=get_option(OM_THEME_PREFIX . 'default_title_parallax');
			}
			if(!$effect)
				$effect='lines';
			
			$classes[]='parallax-effect-'.$effect;
		}
		
		?>
			<div class="<?php echo esc_attr(implode(' ',$classes)) ?>"<?php echo (!empty($styles) ? ' style="'.esc_attr(implode(';',$styles)).'"':'')?>>
				<div class="page-title-inner clearfix">
					<div class="container">
						<div class="container-inner">		
						
						<?php if(get_option(OM_THEME_PREFIX . 'show_breadcrumbs') == 'true') { ?>
							<?php om_breadcrumbs(get_option(OM_THEME_PREFIX . 'breadcrumbs_caption')) ?>
						<?php } ?>
						<h1 class="page-title"><?php echo esc_html($post_title) ?></h1>
						</div>
					</div>
				</div>
			</div>		
		<?php
		
	}
	
	