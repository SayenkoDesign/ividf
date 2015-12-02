<?php

add_action( 'vc_before_init', 'om_wpb_add_shortcodes' );

function om_wpb_add_shortcodes() {
	
	/**
	 * Separator with icon
	 */

	vc_map(array(
		'name' => __('Separator with Icon', 'om_theme'),
		'base' => 'om_icon_separator',
		'description' => __('Horisontal separator line with icon', 'om_theme'),
		'icon' => 'icon-wpb-ui-separator-label',
		'category' => __('Content', 'js_composer'),
		'params' => array(), // PARAMS will be added via options.php file and vc_map_update due to using 'getVcShared' function, which is available only after map.php file load of WPB plugin
	));

	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_icon_separator extends WPBakeryShortCode {
		}
	}	
	
	/**
	 * Box
	 */

	vc_map(array(
		'name' => __('Box', 'om_theme'),
		'base' => 'om_box',
		'description' => __('Set border, icon, background', 'om_theme'),
		'icon' => 'om-wpb-icon-box',
		'category' => __('Content', 'js_composer'),
		'params' => array_merge(
		array(
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => __( 'Content', 'om_theme' ),
				'param_name' => 'content',
				'value' => __( '<p>I am text block. Click edit button to change this text.</p>', 'om_theme' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Border Width', 'om_theme' ),
				'description' => __('Border width in pixels', 'om_theme'),
				'param_name' => 'border_width',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Border Style', 'om_theme' ),
				'param_name' => 'border_style',
				'value' => array(
					__('Solid','om_theme') => 'solid',
					__('Dotted','om_theme') => 'dotted',
				),
				'dependency' => array(
					'element' => 'border_width',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Border Color', 'om_theme' ),
				'param_name' => 'border_color',
				'value' => array_merge(array(__('Theme Hightlight Color', 'om_theme') => 'om-theme-color'), om_wpb_get_std_colors(), array(__('Custom','om_theme') => 'custom')),
				'param_holder_class' => 'vc_colored-dropdown',
				'dependency' => array(
					'element' => 'border_width',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Border Custom Color', 'om_theme' ),
				'param_name' => 'border_custom_color',
				'value' => '',
				'dependency' => array(
					'element' => 'border_color',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Background Color', 'om_theme' ),
				'param_name' => 'bg_color',
				'value' => array_merge(array(__('None', 'om_theme') => '', __('Theme Hightlight Color', 'om_theme') => 'om-theme-color'), om_wpb_get_std_colors(), array(__('Custom','om_theme') => 'custom')),
				'param_holder_class' => 'vc_colored-dropdown',
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background Custom Color', 'om_theme' ),
				'param_name' => 'bg_custom_color',
				'value' => '',
				'dependency' => array(
					'element' => 'bg_color',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Background Image', 'om_theme' ),
				'param_name' => 'bg_image',
				'value' => '',
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Background Image Position', 'om_theme' ),
				'param_name' => 'bg_image_pos',
				'value' => array_flip(om_get_bg_img_pos_options()),
				'dependency' => array(
					'element' => 'bg_image',
					'not_empty' => true,
				),
			),
		),
		om_wpb_icon_params(true),
		array(
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon Style', 'om_theme' ),
				'param_name' => 'icon_style',
				'value' => array(
					__('Border', 'om_theme') => 'border',
					__('Background', 'om_shortcodes') => 'bg',
				),
				'dependency' => array(
					'element' => 'icon_type',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Icon Shape', 'om_theme' ),
				'param_name' => 'icon_shape',
				'value' => array(
					__('Circle', 'om_theme') => 'circle',
					__('Square', 'om_shortcodes') => 'square',
				),
				'dependency' => array(
					'element' => 'icon_type',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Text Custom Color', 'om_theme' ),
				'param_name' => 'text_color',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Certain Box Height', 'om_theme' ),
				'description' => __('Specify box height in pixels if you need certain height, otherwise the height will be set automatically','om_theme'),
				'param_name' => 'height',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			)
		)
		)
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_box extends WPBakeryShortCode {
		}
	}	
	
	/**
	 * Counter
	 */
	 
	vc_map(array(
		'name' => __('Counter', 'om_theme'),
		'base' => 'om_counter',
		'description' => __('Animated counter', 'om_theme'),
		'icon' => 'om-wpb-icon-counter',
		'category' => __('Content', 'js_composer'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Number', 'om_theme' ),
				'description' => __( 'Value will be animated', 'om_theme' ),
				'param_name' => 'number',
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Number Prefix', 'om_theme' ),
				'description' => __( 'e.g. "$" or "up to "', 'om_theme' ),
				'param_name' => 'prefix',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Number Suffix', 'om_theme' ),
				'description' => __( 'e.g. "%"', 'om_theme' ),
				'param_name' => 'suffix',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'om_theme' ),
				'param_name' => 'title',
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Size', 'om_theme' ),
				'param_name' => 'size',
				'value' => array(
					'Small' => 'small',
					'Medium' => 'medium',
					'Large' => 'large',
					'XLarge' => 'xlarge',
        ),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Color', 'om_theme' ),
				'param_name' => 'color',
				'value' => array_merge(array(__('Theme Hightlight Color', 'om_theme') => 'om-theme-color'), om_wpb_get_std_colors(), array(__('Custom','om_theme') => 'custom')),
				'param_holder_class' => 'vc_colored-dropdown',
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Custom Color', 'om_theme' ),
				'param_name' => 'custom_color',
				'value' => '',
				'dependency' => array(
					'element' => 'color',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Animation duration', 'om_theme' ),
				'description' => __('value in milliseconds or 0 - to disable animation','om_theme'),
				'param_name' => 'duration',
				'value' => 2000,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			),

		),
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_counter extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Animated button
	 */
	 
	vc_map( array(
		'name' => __( 'Animated Button', 'om_theme' ),
		'base' => 'om_a_button',
		'icon' => 'om-wpb-icon-a-button',
		'category' => array(__( 'Content', 'js_composer' )),
		'description' => __( 'Animated eye catching button', 'om_theme' ),
		'params' => array_merge(
		array(
			array(
				'type' => 'vc_link',
				'heading' => __( 'URL (Link)', 'js_composer' ),
				'param_name' => 'link',
				'description' => __( 'Button link.', 'js_composer' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Text on the button', 'js_composer' ),
				'holder' => 'button',
				'class' => 'vc_btn',
				'param_name' => 'title',
				'value' => __( 'Text on the button', 'js_composer' ),
				'description' => __( 'Text on the button.', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Style', 'js_composer' ),
				'param_name' => 'style',
				'value' => array(
					__('Colored icon', 'om_theme') => 'colored_icon',
					__('Colored title', 'om_theme') => 'colored_text',
					__('Colored icon & title', 'om_theme') => 'colored_all',
					__('Not colored', 'om_theme') => 'not_colored',
				),
				'description' => __( 'Button color style.', 'om_theme' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Color', 'js_composer' ),
				'param_name' => 'color',
				'value' => array_merge( array(__('Theme Hightlight Color', 'om_theme') => 'om-theme-color'), om_wpb_get_std_colors(), array( __( 'Custom color', 'js_composer' ) => 'custom' ) ) ,
				'description' => __( 'Button color.', 'js_composer' ),
				'param_holder_class' => 'vc_colored-dropdown'
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Custom color', 'js_composer' ),
				'param_name' => 'custom_color',
				'description' => __( 'Select custom color for button.', 'om_theme' ),
				'dependency'  => array(
					'element' => 'color',
					'value'   => array( 'custom' )
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Size', 'js_composer' ),
				'param_name' => 'size',
				'value' => array(
					'Mini' => 'xs',
					'Small' => 'sm',
					'Normal' => 'md',
					'Large' => 'lg',
					'XLarge' => 'xlg'
				),
				'std' => 'md',
				'description' => __( 'Button size.', 'js_composer' )
			),
		),
		om_wpb_icon_params(true),
		array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			),
			array(
				'type' => 'om_get_code',
				'heading' => __( 'Get code', 'om_theme' ),
				'param_name' => 'code',
				'description' => __( 'If you wish to use button shortcode somewhere out of Visual Composer or insert it into text inline, you can generate the code which you can use separately.', 'js_composer' )
			),
		)
		),
		'js_view' => 'VcButton2View'
	) );
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Om_A_Button extends WPBakeryShortCode {
			protected function outputTitle( $title ) {
				$icon = $this->settings('icon');
				return  '<h4 class="wpb_element_title"><span class="vc_element-icon'.( !empty($icon) ? ' '.$icon : '' ).'"></span></h4>';
			}
		}
	}
	
	/**
	 * Pricing tables
	 */
	
	vc_map( array(
		'name' => __('Pricing Table', 'om_theme'),
		'base' => 'om_pricing_table',
		'icon' => 'om-wpb-icon-pricing-table',
		'as_parent' => array('only' => 'om_pricing_table_column'),
		'category' => array(__( 'Content', 'js_composer' )),
		'content_element' => true,
		'show_settings_on_create' => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		),
		'js_view' => 'VcColumnView'
	));
	
	vc_map( array(
		'name' => __('Pricing table column', 'om_theme'),
		'base' => 'om_pricing_table_column',
		'icon' => 'om-wpb-icon-pricing-table',
		'content_element' => true,
		'as_child' => array('only' => 'om_pricing_table'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'om_theme' ),
				'param_name' => 'title',
				'admin_label' => true,
				'description' => __( 'Enter pricing column title.', 'om_theme' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Subtitle', 'om_theme' ),
				'param_name' => 'subtitle',
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Featured', 'om_theme' ),
				'param_name' => 'featured',
				'admin_label' => true,
				'description' => __( 'If selected, column will stand out.', 'om_theme' ),
				'value' => array( __( 'Yes', 'js_composer' ) => 'yes' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Price', 'om_theme' ),
				'param_name' => 'price',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Price prefix', 'om_theme' ),
				'param_name' => 'price_prefix',
				'description' => __( 'e.g. "$"', 'om_theme' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Price Suffix', 'om_theme' ),
				'param_name' => 'price_suffix',
				'description' => __( 'e.g. "daily", "monthly"', 'om_theme' ),
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Options', 'om_theme' ),
				'param_name' => 'options',
				'description' => __( 'Enter tariff options. Divide options with linebreaks (Enter).', 'om_theme' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Button title', 'om_theme' ),
				'param_name' => 'button_title',
				'description' => __( 'e.g. "Sing up"', 'om_theme' ),
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'Button URL (Link)', 'js_composer' ),
				'param_name' => 'link',
				'dependency' => array( 'element' => 'button_title', 'not_empty' => true ),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		),
	));

	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Om_Pricing_Table extends WPBakeryShortCodesContainer {
		}
	}
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Om_Pricing_Table_Column extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Table
	 */
	
	vc_map( array(
		'name' => __( 'Data HTML Table', 'js_composer' ),
		'base' => 'om_html_table',
		'icon' => 'om-wpb-icon-html-table',
		'category' => __( 'Content', 'js_composer' ),
		'wrapper_class' => 'clearfix',
		'description' => __( 'Apply styling to data table', 'om_theme' ),
		'params' => array(
			array(
				'type' => 'textarea_raw_html',
				'holder' => 'div',
				'heading' => __( 'Table HTML', 'js_composer' ),
				'param_name' => 'content',
				'value' => base64_encode( '<table>
  <tr>
    <th>Column 1 name</th>
    <th>Column 2 name</th>
    <th>Column 3 name</th>
  </tr>
  <tr>
    <td>Row 1, column 1 value</td>
    <td>Row 1, column 2 value</td>
    <td>Row 1, column 3 value</td>
  </tr>
  <tr>
    <td>Row 2, column 1 value</td>
    <td>Row 2, column 2 value</td>
    <td>Row 2, column 3 value</td>
  </tr>
</table>' ),
				'description' => __( 'Enter your table HTML markup. More information about table HTML markup <a href="http://www.w3schools.com/html/html_tables.asp" target="_blank">here</a>', 'js_composer' )
			),
			
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		)
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_html_table extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Testimonials
	 */

	if(isset($GLOBALS['omTestimonialsPlugin'])) {
		vc_map( array(
			'name' => __( 'Testimonials', 'om_theme' ),
			'base' => 'om_testimonials',
			'icon' => 'om-wpb-icon-testimonials',
			'category' => array(__( 'Content', 'js_composer' )),
			'description' => __( 'Testimonials block', 'om_theme' ),
			'params' => array(
				array(
					'type' => 'om_info',
					'heading' => '',
					'param_name' => 'info',
					'description' => sprintf( __('Testimonials are managed under <a href="%s" target="_blank">"Testimonials"</a> section. This block just displays testimonials.','om_theme'), admin_url('edit.php?post_type=testimonials') ),
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Widget title', 'js_composer' ),
					'param_name' => 'title',
					'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Layout mode','om_theme'),
					'param_name' => 'mode',
					'admin_label' => true,
					'value' => array(
						__('In one box with sliding','om_theme') => 'box',
						__('Full list','om_theme') => 'list',
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Autorotate for box mode','om_theme'),
					'param_name' => 'timeout',
					'value' => '',
					'description' => __('Interval in milliseconds. Leave empty to disable autorotate','om_theme'),
					'dependency' => array(
						'element' => 'mode',
						'value' => array('box'),
					),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Pause autorotate on hover', 'om_theme' ),
					'param_name' => 'pause',
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
					'dependency' => array(
						'element' => 'timeout',
						'not_empty' => true,
					),
				),
				array(
					'type' => 'om_categories',
					'heading' => __( 'Testimonials category', 'js_composer' ),
					'param_name' => 'category',
					'args' => array(
						'taxonomy' => 'testimonials-type',
					),
					'description' => __( 'Choose a category, to display testimonials from certain category.', 'om_theme' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Testimonials by ID', 'js_composer' ),
					'param_name' => 'ids',
					'description' => __( 'Specify a list of testimonial IDs separated with a comma to display certain testimonials.', 'js_composer' )
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Randomize testimonials', 'om_theme' ),
					'param_name' => 'randomize',
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Extra class name', 'js_composer'),
					'param_name' => 'el_class',
					'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
				),			
			),
		));
		
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_om_testimonials extends WPBakeryShortCode {
	
			}
		}
	}
	
	/**
	 * Olevmedia Portfolio
	 */

	if(isset($GLOBALS['omPortfolioPlugin']) && version_compare($GLOBALS['omPortfolioPlugin']['version'], '2.0.0', '>=')) {

		vc_map( array(
			'name' => __( 'Portfolio', 'om_theme' ),
			'base' => 'om_portfolio',
			'icon' => 'om-wpb-icon-portfolio',
			'category' => array(__( 'Content', 'js_composer' )),
			'description' => __( 'Portfolio items block', 'om_theme' ),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Widget title', 'js_composer' ),
					'param_name' => 'title',
					'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Layout','om_theme'),
					'param_name' => 'layout',
					'admin_label' => true,
					'value' => array_flip(ompf_get_options_arr('layout')),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Thumbnail width/height ratio','om_theme'),
					'param_name' => 'ratio',
					'admin_label' => true,
					'value' => array_values(ompf_get_options_arr('ratio')),
					'dependency' => array(
						'element' => 'layout',
						'value' => array('fixed'),
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Thumbnail size','om_theme'),
					'param_name' => 'size',
					'admin_label' => true,
					'value' => array_flip(ompf_get_options_arr('size')),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Preview layout','om_theme'),
					'param_name' => 'preview_layout',
					'admin_label' => true,
					'value' => array_flip(ompf_get_options_arr('preview_layout')),
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Item margins','om_theme'),
					'param_name' => 'margins',
					'value' => array(
						__('Standard','om_theme') => 'standard',
						__('No margins','om_theme') => 'none',
					),
					'description' => __('Gap between portfolio items in the grid','om_theme'),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Count','om_theme'),
					'param_name' => 'count',
					'value' => '',
					'description' => __('Number of items to display. Leave empty to display all items.','om_theme'),
				),
				array(
					'type' => 'checkbox',
					'heading' => __('Use hi-res images','om_theme'),
					'description' => __('Check this option of you use element in a row without padding and the dimendions of images is not enough.','om_theme'),
					'param_name' => 'hires',
					'value' => array( __( 'Yes, please', 'om_theme' ) => 'yes' ),
				),
				array(
					'type' => 'om_categories',
					'heading' => __( 'Category', 'js_composer' ),
					'param_name' => 'category',
					'args' => array(
						'taxonomy' => 'portfolio-type',
					),
					'description' => __( 'Choose a category, to display portfolio items from certain category.', 'om_theme' )
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Portfolio items by ID', 'js_composer' ),
					'param_name' => 'ids',
					'description' => __( 'Specify a list of portfolio item IDs separated with a comma to display certain items.', 'js_composer' )
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Items order','om_theme'),
					'param_name' => 'sort',
					'value' => array_flip(ompf_get_options_arr('sort')),
				),
				array(
					'type' => 'checkbox',
					'heading' => __( 'Randomize items', 'om_theme' ),
					'param_name' => 'randomize',
					'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Extra class name', 'js_composer'),
					'param_name' => 'el_class',
					'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
				),	
			),
		));
		
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			class WPBakeryShortCode_om_portfolio extends WPBakeryShortCode {
	
			}
		}
		
	}
	
	/**
	 * Logos
	 */

	vc_map( array(
		'name' => __( 'Logos', 'om_theme' ),
		'base' => 'om_logos',
		'icon' => 'om-wpb-icon-logos',
		'category' => array(__( 'Content', 'js_composer' )),
		'description' => __( 'Align set of logotypes', 'om_theme' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'js_composer' ),
				'param_name' => 'title',
				'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
			),
			array(
				'type' => 'attach_images',
				'heading' => __('Images','om_theme'),
				'description' => __( 'Choose image to display.', 'js_composer' ),
				'param_name' => 'images',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image size', 'js_composer' ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'om_theme' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __('On click','om_theme'),
				'param_name' => 'onclick',
				'value' => array(
					__('Do nothing', 'om_theme') => 'no',
					__('Open custom link', 'om_theme') => 'custom_link',
					__('Open link, defined in the "Description" field of an image', 'om_theme') => 'description',
				),
			),
			array(
				'type' => 'exploded_textarea',
				'heading' => __( 'Custom links', 'js_composer' ),
				'param_name' => 'custom_links',
				'description' => __( 'Enter links for each image. Divide links with linebreaks (Enter) . ', 'om_theme' ),
				'dependency' => array(
					'element' => 'onclick',
					'value' => array( 'custom_link' )
				)
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Link target', 'om_theme' ),
				'param_name' => 'links_target',
				'description' => __( 'Select where to open custom links.', 'js_composer' ),
				'dependency' => array(
					'element' => 'onclick',
					'value' => array( 'custom_link', 'description' ),
				),
				'value' => array(
					__( 'Same window', 'js_composer' ) => '_self',
					__( 'New window', 'js_composer' ) => '_blank',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		),
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_logos extends WPBakeryShortCode {

		}
	}
	
	/**
	 * Charts
	 */

	vc_map(array(
		'name' => __('Charts', 'om_theme'),
		'base' => 'om_chart',
		'description' => __('Insert a simple chart', 'om_theme'),
		'icon' => 'om-wpb-icon-charts',
		'category' => __('Content', 'js_composer'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'om_theme' ),
				'param_name' => 'title',
				'admin_label' => true,
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Chart type','om_theme'),
				'param_name' => 'type',
				'value' => array(
					'Line' => 'Line',
					'Bar' => 'Bar',
					'Radar' => 'Radar',
					'PolarArea' => 'PolarArea',
					'Pie' => 'Pie',
					'Doughnut' => 'Doughnut',
				),
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Labels', 'om_theme' ),
				'description' => __('X axis labels, separated by commas (,). E.g. January, February, March, April', 'om_theme'),
				'param_name' => 'labels',
				'value' => 'January, February, March, April',
				'dependency' => array(
					'element' => 'type',
					'value' => array('Line', 'Bar', 'Radar'),
				),
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Data', 'om_theme' ),
				'param_name' => 'data',
				'description' => __('Chart data. Divide datasets with linebreaks (Enter). Each dataset (line) must have a format<br/>Label|10,20,30,40|#e75956<br/>where "Label" is a label of the dataset. "10,20,30,40" are values, number of values must be equal to number of X axis labels. "#e75956" is the color of the dataset on the chart. Optional, if missed Theme highlight color is used.<br/>For PolarArea, Pie and Doughnut types, value must contain just single value, like "Label|20|#e75956"', 'om_theme'),
				'value' => "First dataset label|10,20,30,40\nSecond dataset label|60,40,10,20|#e75956",
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Chart width/height ratio','om_theme'),
				'param_name' => 'ratio',
				'value' => array('3:1', '2:1', '16:9', '4:3', '1:1', '3:4', '9:16', '1:2', '1:3'),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Display legend', 'om_theme' ),
				'param_name' => 'legend',
				'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' )
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Fill datasets with a color', 'om_theme' ),
				'param_name' => 'fill',
				'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'dependency' => array(
					'element' => 'type',
					'value' => array('Line', 'Radar'),
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Labels Custom Color', 'om_theme' ),
				'param_name' => 'labels_color',
				'value' => '',
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Segment Stroke Custom Color', 'om_theme' ),
				'param_name' => 'segmentstroke_color',
				'value' => '',
				'dependency' => array(
					'element' => 'type',
					'value' => array('PolarArea', 'Pie', 'Doughnut'),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			),

		)
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_chart extends WPBakeryShortCode {
		}
	}				
	
	
	/**
	 * Person
	 */

	vc_map(array(
		'name' => __('Person card', 'om_theme'),
		'base' => 'om_person',
		'description' => __('Photo, name, contacts', 'om_theme'),
		'icon' => 'om-wpb-icon-person',
		'category' => __('Content', 'js_composer'),
		'params' => array(
			array(
				'type' => 'dropdown',
				'heading' => __('Style','om_theme'),
				'param_name' => 'style',
				'value' => array(
					__('Simple','om_theme') => 'simple',
					__('Centered','om_theme') => 'centered',
					__('Colored','om_theme') => 'colored',
				),
				'admin_label' => true,
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Photo', 'om_theme' ),
				'param_name' => 'photo',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Image size', 'js_composer' ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "large" size.', 'om_theme' ),
				'dependency' => array(
					'element' => 'photo',
					'not_empty' => true,
				),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Round image', 'om_theme' ),
				'param_name' => 'img_round',
				'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
				'dependency' => array(
					'element' => 'style',
					'value' => array('simple', 'centered'),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Person name', 'om_theme' ),
				'param_name' => 'name',
				'admin_label' => true,
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Job title', 'om_theme' ),
				'param_name' => 'job',
				'admin_label' => true,
			),
			array(
				'type' => 'textarea',
				'heading' => __( 'Short description', 'om_theme' ),
				'param_name' => 'description',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Email', 'om_theme' ),
				'param_name' => 'email',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Behance link', 'om_theme' ),
				'param_name' => 'behance',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Facebook link', 'om_theme' ),
				'param_name' => 'facebook',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Google+ link', 'om_theme' ),
				'param_name' => 'gplus',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Instagram link', 'om_theme' ),
				'param_name' => 'instagram',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'LinkedIn link', 'om_theme' ),
				'param_name' => 'linkedin',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Pinterest link', 'om_theme' ),
				'param_name' => 'pinterest',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Skype link', 'om_theme' ),
				'param_name' => 'skype',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Twitter link', 'om_theme' ),
				'param_name' => 'twitter',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'YouTube link', 'om_theme' ),
				'param_name' => 'youtube',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			),
		)
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_person extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Wide Box
	 */

	vc_map(array(
		'name' => __('Clickable Wide Box', 'om_theme'),
		'base' => 'om_click_box',
		'icon' => 'om-wpb-icon-click-box',
		'description' => __('Call to action box', 'om_theme'),
		'category' => __('Content', 'js_composer'),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'om_theme' ),
				'param_name' => 'title',
				'admin_label' => true,
				'value' => '',
			),
			array(
				'type' => 'vc_link',
				'heading' => __( 'URL (Link)', 'js_composer' ),
				'param_name' => 'link',
				'description' => __( 'Button link.', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Size', 'om_theme' ),
				'param_name' => 'size',
				'value' => array(
					__('Small','om_theme') => 'sm',
					__('Medium','om_theme') => 'md',
					__('Large','om_theme') => 'lg',
					__('X-Large','om_theme') => 'xlg',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Color', 'om_theme' ),
				'param_name' => 'style',
				'value' => array(
					__('Theme Color','om_theme') => '',
					__('Custom','om_theme') => 'custom',
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Text Custom Color', 'om_theme' ),
				'param_name' => 'text_color',
				'value' => '#ffffff',
				'dependency' => array(
					'element' => 'style',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Background Color', 'om_theme' ),
				'param_name' => 'bg_color',
				'value' => array_merge(om_wpb_get_std_colors(), array(__('Custom','om_theme') => 'custom')),
				'param_holder_class' => 'vc_colored-dropdown',
				'dependency' => array(
					'element' => 'style',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Background Custom Color', 'om_theme' ),
				'param_name' => 'bg_custom_color',
				'value' => '',
				'dependency' => array(
					'element' => 'bg_color',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __( 'Hover Background Color', 'om_theme' ),
				'param_name' => 'hover_bg_color',
				'value' => array_merge(om_wpb_get_std_colors(), array(__('Custom','om_theme') => 'custom')),
				'param_holder_class' => 'vc_colored-dropdown',
				'dependency' => array(
					'element' => 'style',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Hover Background Custom Color', 'om_theme' ),
				'param_name' => 'hover_bg_custom_color',
				'value' => '',
				'dependency' => array(
					'element' => 'hover_bg_color',
					'value' => array('custom'),
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Extra class name', 'js_composer' ),
				'param_name' => 'el_class',
				'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
			),
		)
	));
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_click_box extends WPBakeryShortCode {
		}
	}				
	
	/**
	 * Moving
	 */
	
	vc_map( array(
		'name' => __('Moving Image/Icon', 'om_theme'),
		'description' => __('Floating, Pulsing, Spinning','om_theme'),
		'base' => 'om_moving_box',
		'icon' => 'om-wpb-icon-moving-box',
		'category' => array(__( 'Content', 'js_composer' )),
		'params' => array_merge(
			array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Content', 'om_theme' ),
					'param_name' => 'content_type',
					'admin_label' => true,
					'value' => array(
						__('Image','om_theme') => 'image',
						__('Icon','om_theme') => 'icon',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Animation', 'om_theme' ),
					'param_name' => 'animation',
					'value' => array(
						__('Vertical Float','om_theme') => 'float_vertical',
						__('Horisontal Float','om_theme') => 'float_horisontal',
						__('Pulse','om_theme') => 'pulse',
						__('Tossing','om_theme') => 'tossing',
						__('Spin','om_theme') => 'spin',
					),
					'admin_label' => true,
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Align', 'om_theme' ),
					'param_name' => 'align',
					'value' => array(
						__('Center','om_theme') => 'center',
						__('Left','om_theme') => 'left',
						__('Right','om_theme') => 'right',
					),
				),
				array(
					'type' => 'attach_image',
					'heading' => __('Image', 'om_theme'),
					'param_name' => 'img',
					'dependency' => array(
						'element' => 'content_type',
						'value' => array('image'),
					)
				),
				array(
					'type' => 'textfield',
					'heading' => __( 'Image size', 'js_composer' ),
					'param_name' => 'img_size',
					'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'om_theme' ),
					'dependency' => array(
						'element' => 'content_type',
						'value' => array('image'),
					)
				),
			),
			om_wpb_icon_params(false, array(
				'element' => 'content_type',
				'value' => array('icon'),
			)),
			array(
				array(
					'type' => 'dropdown',
					'heading' => __( 'Icon Color', 'om_theme' ),
					'param_name' => 'color',
					'value' => array_merge(array(__('Theme Hightlight Color', 'om_theme') => 'om-theme-color'), om_wpb_get_std_colors(), array(__('Custom','om_theme') => 'custom')),
					'param_holder_class' => 'vc_colored-dropdown',
					'dependency' => array(
						'element' => 'content_type',
						'value' => array('icon'),
					),
				),
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Icon Custom Color', 'om_theme' ),
					'param_name' => 'custom_color',
					'value' => '',
					'dependency' => array(
						'element' => 'color',
						'value' => array('custom'),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Icon size', 'om_theme'),
					'param_name' => 'icon_size',
					'value' => '64px',
					'description' => __('Icon size in pixels (e.g. "64px") or percents (e.g. "300%")', 'om_theme'),
					'dependency' => array(
						'element' => 'content_type',
						'value' => array('icon'),
					),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Extra class name', 'js_composer'),
					'param_name' => 'el_class',
					'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
				),
			)
		)
	));
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_om_moving_box extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Clickable Icon box
	 */
	
	vc_map( array(
		'name' => __('Clickable Icon Box', 'om_theme'),
		'description' => __('Icon, Title, Text','om_theme'),
		'base' => 'om_click_icon_box',
		'icon' => 'om-wpb-icon-cib',
		'category' => array(__( 'Content', 'js_composer' )),
		'params' => array_merge(
			array(
				array(
					'type' => 'vc_link',
					'heading' => __( 'URL (Link)', 'js_composer' ),
					'param_name' => 'link',
					'description' => __( 'Button link.', 'js_composer' )
				),
			),
			om_wpb_icon_params(),
			array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'om_theme' ),
					'param_name' => 'title',
					'admin_label' => true,
				),
	
				array(
					'type' => 'textarea',
					'heading' => __( 'Text', 'om_theme' ),
					'param_name' => 'content',
				),
				
				array(
					'type' => 'textfield',
					'heading' => __('Extra class name', 'js_composer'),
					'param_name' => 'el_class',
					'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
				),
			)
		),
	));
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_om_click_icon_box extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Clickable Icon box 2
	 */
	
	vc_map( array(
		'name' => __('Icon Box 2', 'om_theme'),
		'description' => __('Horisontal Layout, Background, Title, Text','om_theme'),
		'base' => 'om_click_icon_box2',
		'icon' => 'om-wpb-icon-cib2',
		'category' => array(__( 'Content', 'js_composer' )),
		'params' => array_merge(
			array(
				array(
					'type' => 'vc_link',
					'heading' => __( 'URL (Link)', 'js_composer' ),
					'param_name' => 'link',
					'description' => __( 'Button link.', 'js_composer' )
				),
			),
			om_wpb_icon_params(),
			array(
				array(
					'type' => 'textfield',
					'heading' => __( 'Title', 'om_theme' ),
					'param_name' => 'title',
					'holder' => 'h4',
				),
	
				array(
					'type' => 'textarea',
					'heading' => __( 'Text', 'om_theme' ),
					'param_name' => 'content',
					'holder' => 'div',
				),
				
				array(
					'type' => 'dropdown',
					'heading' => __( 'Background Color', 'om_theme' ),
					'param_name' => 'bg_color',
					'value' => array_merge(array(__('Theme Hightlight Color', 'om_theme') => 'om-theme-color'), om_wpb_get_std_colors(), array(__('Custom','om_theme') => 'custom')),
					'param_holder_class' => 'vc_colored-dropdown',
					'dependency' => array(
						'element' => 'style',
						'value' => array('custom'),
					),
				),
				
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Background Custom Color', 'om_theme' ),
					'param_name' => 'bg_custom_color',
					'value' => '',
					'dependency' => array(
						'element' => 'bg_color',
						'value' => array('custom'),
					),
				),
	
				array(
					'type' => 'colorpicker',
					'heading' => __( 'Text Color', 'om_theme' ),
					'param_name' => 'text_color',
					'value' => '#ffffff',
				),
				
				array(
					'type' => 'textfield',
					'heading' => __('Extra class name', 'js_composer'),
					'param_name' => 'el_class',
					'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
				),
			)
		),
	));
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_om_click_icon_box2 extends WPBakeryShortCode {
		}
	}
	
	/**
	 * Teaser
	 */
	
	vc_map( array(
		'name' => __('Teaser', 'om_theme'),
		'description' => __('Background Image, Title, Text, Link','om_theme'),
		'base' => 'om_teaser',
		'icon' => 'om-wpb-icon-teaser',
		'category' => array(__( 'Content', 'js_composer' )),
		'params' => array(
			array(
				'type' => 'vc_link',
				'heading' => __( 'URL (Link)', 'js_composer' ),
				'param_name' => 'link',
				'description' => __( 'Button link.', 'js_composer' ),
			),
			array(
				'type' => 'attach_image',
				'heading' => __( 'Background Image', 'om_theme' ),
				'param_name' => 'bg_image',
				'value' => '',
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Background Image size', 'js_composer' ),
				'param_name' => 'img_size',
				'description' => __( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "full" size.', 'om_theme' )
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Title', 'om_theme' ),
				'param_name' => 'title',
				'holder' => 'h4',
			),

			array(
				'type' => 'textarea',
				'heading' => __( 'Text', 'om_theme' ),
				'param_name' => 'content',
				'holder' => 'div',
			),
			array(
				'type' => 'colorpicker',
				'heading' => __( 'Text color', 'om_theme' ),
				'param_name' => 'text_color',
				'value' => '',
			),		
			array(
				'type' => 'dropdown',
				'heading' => __( 'Text align', 'om_theme' ),
				'param_name' => 'align',
				'value' => array(
					__('Center','om_theme') => 'center',
					__('Left','om_theme') => 'left',
					__('Right','om_theme') => 'right',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Certain teaser height', 'om_theme' ),
				'param_name' => 'height',
				'description' => __('Specify teaser height in pixels if you need certain height, otherwise the height will be set automatically', 'om_theme'),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		),
	));
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_om_teaser extends WPBakeryShortCode {
		}
	}
	
	
	/**
	 * Posts
	 */
	 
	vc_map( array(
		'name' => __( 'Posts', 'om_theme' ),
		'base' => 'om_posts',
		'icon' => 'om-wpb-icon-posts',
		'category' => array(__( 'Content', 'js_composer' )),
		'description' => __( 'Posts block', 'om_theme' ),
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => __( 'Widget title', 'js_composer' ),
				'param_name' => 'title',
				'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'js_composer' )
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Layout mode','om_theme'),
				'param_name' => 'mode',
				'admin_label' => true,
				'value' => array(
					__('Table view (fixed cells)','om_theme') => 'fixed',
					__('Masonry','om_theme') => 'masonry',
				),
			),
			array(
				'type' => 'dropdown',
				'heading' => __('Columns','om_theme'),
				'param_name' => 'columns',
				'admin_label' => true,
				'value' => array(
					'3' => '3',
					'2' => '2',
				),
			),
			array(
				'type' => 'textfield',
				'heading' => __( 'Total number', 'js_composer' ),
				'param_name' => 'count',
				'value' => '',
				'admin_label' => true,
				'description' => __( 'Leave empty to display all posts', 'om_theme' )
			),
			array(
				'type' => 'om_categories_multiple',
				'heading' => __( 'Posts category', 'js_composer' ),
				'param_name' => 'category',
				'value' => '0',
				'description' => __( 'Choose a category (or multiple caterogires), to display posts from certain category.', 'om_theme' )
			),
			array(
				'type' => 'autocomplete',
				'heading' => __( 'Display only these posts', 'js_composer' ),
				'param_name' => 'ids',
				'settings' => array(
					'multiple' => true,
					'sortable' => true,
					'groups' => true,
				),
				'description' => __( 'If you want to display only certain posts, choose them here.', 'om_theme' )
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Randomize posts', 'om_theme' ),
				'param_name' => 'randomize',
				'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Hide thumbnail', 'om_theme' ),
				'param_name' => 'hide_thumbnail',
				'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Hide meta (date, categories, tags)', 'om_theme' ),
				'param_name' => 'hide_meta',
				'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			),
			array(
				'type' => 'checkbox',
				'heading' => __( 'Hide excerpt', 'om_theme' ),
				'param_name' => 'hide_excerpt',
				'value' => array( __( 'Yes, please', 'js_composer' ) => 'yes' ),
			),
			array(
				'type' => 'textfield',
				'heading' => __('Extra class name', 'js_composer'),
				'param_name' => 'el_class',
				'description' => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer')
			),
		),
	));
	
	add_filter( 'vc_autocomplete_om_posts_ids_callback',
		'om_wpb_posts_field_search', 10, 1 ); // Get suggestion(find). Must return an array
	add_filter( 'vc_autocomplete_om_posts_ids_render',
		'vc_include_field_render', 10, 1 ); // Render exact product. Must return an array (label,value)

	function om_wpb_posts_field_search( $search_string ) {
		$query = $search_string;
		$data = array();
		$args = array( 's' => $query, 'post_type' => 'post' );
		$args['vc_search_by_title_only'] = true;
		$args['numberposts'] = - 1;
		if ( strlen( $args['s'] ) == 0 ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
		$posts = get_posts( $args );
		foreach ( $posts as $post ) {
			$data[] = array(
				'value' => $post->ID,
				'label' => $post->post_title,
				'group' => $post->post_type,
			);
		}
	
		return $data;
	}
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_om_posts extends WPBakeryShortCode {

		}
	}

}
