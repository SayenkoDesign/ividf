<?php

function om_customize_register( $wp_customize ) {

	require_once (TEMPLATE_DIR . '/functions/theme-options.php');

	$theme_options=om_get_options_template(true);

	/***********/
	
	$wp_customize->remove_section( 'title_tagline');
	
	/***********/
	
	$wp_customize->add_section('options_notice', array(
		'title' => __('More options','om_theme'),
		'priority'   => 10,
		'description' => __('For more Options see <a href="admin.php?page=om_options">"Theme Options"</a> section','om_theme'),
	));
	
	$wp_customize->add_setting( 'options_notice', array(
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control(new OM_Customize_Notice_Control( // adds a blank option to make section appear
		$wp_customize,
		'options_notice',
		array(
			'label'          => '',
			'section'        => 'options_notice',
			'settings'       => 'options_notice',
			'type'           => 'notice',
		)
	));
	
	/***********/

	$wp_customize->add_section('layout', array(
		'title' => __('Layout','om_theme'),
		'priority'   => 30,
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'overall_layout',
		'section' => 'layout',
	));
	
	/***********/

	$wp_customize->add_section('bg_img', array(
		'title' => __('Background','om_theme'),
		'description' => __('This option makes sense only if "Boxed" layout chosen above','om_theme'),
		'priority'   => 31,
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'background_color',
		'section' => 'bg_img',
	));
		
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'background_img_custom',
		'section' => 'bg_img',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'background_pos',
		'section' => 'bg_img',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'background_attach',
		'section' => 'bg_img',
	));
		
	/***********/

	$wp_customize->add_section('header', array(
		'title' => __('Header','om_theme'),
		'priority'   => 35,
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'header_tagline',
		'section' => 'header',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'social_icons_header',
		'section' => 'header',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'intro_text',
		'section' => 'header',
	));

	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'show_header_search',
		'section' => 'header',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'header_layout',
		'section' => 'header',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'menu_position',
		'section' => 'header',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'show_dropdown_symbol',
		'section' => 'header',
	));
	
	/***********/

	$wp_customize->add_section('footer', array(
		'title' => __('Footer','om_theme'),
		'priority'   => 36,
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'subfooter_text',
		'section' => 'footer',
	));

	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'social_icons_footer',
		'section' => 'footer',
	));	

	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'uncovering_footer',
		'section' => 'footer',
	));

	/***********/
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'hightlight_color',
		'section' => 'colors',
	));

	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'pre_header_background_color',
		'section' => 'colors',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'tagline_color',
		'section' => 'colors',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'header_background_color',
		'section' => 'colors',
	));
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'social_icons_color_header',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'menu_items_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'menu_items_color_hover',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'menu_sub_items_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'menu_sub_items_color_hover',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'background_main_content_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'main_text_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'side_text_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'background_footer_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'footer_titles_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'footer_main_text_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'footer_side_text_color',
		'section' => 'colors',
	));	
	
	om_customize_add_theme_option($wp_customize, $theme_options, array(
		'option_id' => OM_THEME_PREFIX.'social_icons_color_footer',
		'section' => 'colors',
	));	

	/***********/
	
}
add_action( 'customize_register', 'om_customize_register' );

/**
 * Helper Function
 */

$om_customize_controls=1;
function om_customize_add_theme_option($wp_customize, $theme_options, $args) {
	global $om_customize_controls;
	
	if(isset($args['option_id']) && isset($theme_options[$args['option_id']])) {
		
		$option_id=$args['option_id'];
		$option=$theme_options[$option_id];
		
		switch($option['type']) {
			default:
				$sanitize_callback='wp_kses_post';
		}

		$wp_customize->add_setting( $args['option_id'] , array(
				'capability' => 'edit_theme_options',
				'type' => 'option',
				'sanitize_callback' => $sanitize_callback,
		) );
	
		switch($option['type']) {
			case 'text':
				$wp_customize->add_control(new WP_Customize_Control(
					$wp_customize,
					$args['option_id'],
					array(
						'label'          => $option['name'],
						'section'        => $args['section'],
						'settings'       => $option_id,
						'type'           => 'text',
						'priority'       => $om_customize_controls++,
					)
				));
			
				break;
				
			case 'textarea':
				$wp_customize->add_control(new OM_Customize_Textarea_Control(
					$wp_customize,
					$args['option_id'],
					array(
						'label'          => $option['name'],
						'section'        => $args['section'],
						'settings'       => $option_id,
						'type'           => 'textarea',
						'priority'       => $om_customize_controls++,
					)
				));
			
				break;

			case 'checkbox':
				$wp_customize->add_control(new WP_Customize_Control(
					$wp_customize,
					$args['option_id'],
					array(
						'label'          => $option['name'],
						'section'        => $args['section'],
						'settings'       => $option_id,
						'type'           => 'radio',
						'choices'        => array(
							'false' => 'No',
							'true' => 'Yes',
						),
						'priority'       => $om_customize_controls++,
					)
				));
			
				break;		
				
			case 'upload':
				$wp_customize->add_control(new WP_Customize_Image_Control(
					$wp_customize,
					$args['option_id'],
					array(
						'label'          => $option['name'],
						'section'        => $args['section'],
						'settings'       => $option_id,
						'priority'       => $om_customize_controls++,
					)
				));
			
				break;		

			case 'images':
				$i=1;
				$choices=array();
				foreach($option['options'] as $k=>$v) {
					$choices[$k]=__('Variant','om_theme').' '.$i;
					$i++;
				}
			
				$wp_customize->add_control(new WP_Customize_Control(
					$wp_customize,
					$args['option_id'],
					array(
						'label'          => $option['name'],
						'section'        => $args['section'],
						'settings'       => $option_id,
						'type'           => 'radio',
						'choices'        => $choices,
						'priority'       => $om_customize_controls++,
					)
				));	
				
				break;
				
			case 'select2':
			
				$wp_customize->add_control(new WP_Customize_Control(
					$wp_customize,
					$args['option_id'],
					array(
						'label'          => $option['name'],
						'section'        => $args['section'],
						'settings'       => $option_id,
						'type'           => 'select',
						'choices'        => $option['options'],
						'priority'       => $om_customize_controls++,
					)
				));	
				
				break;	
				
			case 'color':
			
				$wp_customize->add_control(new WP_Customize_Color_Control(
					$wp_customize,
					$args['option_id'],
					array(
						'label'          => $option['name'],
						'section'        => $args['section'],
						'settings'       => $option_id,
						'priority'       => $om_customize_controls++,
					)
				));	
				
				break;
		}

	
	}
}

/**
 * Force inline css styling when preview
 */
 
function om_start_previewing_theme() {
	add_filter( 'option_' . OM_THEME_PREFIX . 'use_inline_css', 'om_previewing_use_inline_css' );
}

function om_previewing_use_inline_css() {
	return 'true';
}

if(! function_exists('is_customize_preview') ) { // function exists since WP 4.0
	function is_customize_preview() {
		global $wp_customize;
		return is_a( $wp_customize, 'WP_Customize_Manager' ) && $wp_customize->is_preview();
	} 
}

if(is_customize_preview())
	om_start_previewing_theme();


/**
 * Hook to update custom css file
 */
 
function om_customize_save_after() {
	do_action('om_options_updated');
}
 
add_action('customize_save_after', 'om_customize_save_after');

/**
 * Custom Controls
 */

if(class_exists('WP_Customize_Control')) {

	if(!class_exists('OM_Customize_Textarea_Control')) {
		
		class OM_Customize_Textarea_Control extends WP_Customize_Control {
		    public $type = 'textarea';
		 
		    public function render_content() {
		        ?>
		        <label>
		        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		        <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
		        </label>
		        <?php
		    }
		}
		
	}
	
	if(!class_exists('OM_Customize_Notice_Control')) {
		
		class OM_Customize_Notice_Control extends WP_Customize_Control {
		    public $type = 'notice';
		 
		    public function render_content() {
		        ?>
		        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		        <input type="hidden" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
		        <?php
		    }
		}
		
	}

}