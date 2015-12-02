<?php

function om_widget_testimonials_init() {
	register_widget( 'om_widget_testimonials' );
}
add_action( 'widgets_init', 'om_widget_testimonials_init' );

/* Widget Class */

class om_widget_testimonials extends WP_Widget {

	private $instance_defaults;
	
	function __construct() {
	
		parent::__construct(
			'om_widget_testimonials',
			OM_THEME_TITLE_NAME.': '.__('Testimonials','om_theme'),
			array(
				'classname' => 'om_widget_testimonials',
				'description' => __('Use this widget to display testimonials', 'om_theme')
			)
		);
		
		$this->instance_defaults = array(
			'title' => __('Testimonials','om_theme'),
			'category' => 0,
			'autorotate' => 0,
			'ids' => '',
		);
	}

	/* Front-end display of widget. */
		
	function widget( $args, $instance ) {
		extract( $args );
		
		$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$instance['autorotate'] = intval($instance['autorotate']);
	
		echo wp_kses_post($before_widget);
	
		if ( $title )
			echo wp_kses_post($before_title . $title . $after_title);
		
		echo do_shortcode('[om_testimonials timeout="'.esc_attr($instance['autorotate']).'"'.($instance['category']?' category="'.esc_attr($instance['category']).'"':'').($instance['ids']?' ids="'.esc_attr($instance['ids']).'"':'').']');
		
		echo wp_kses_post($after_widget);
	}


	/* Sanitize widget form values as they are saved. */
		
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		
		$instance['category'] = $new_instance['category'];
		
		$instance['autorotate'] = $new_instance['autorotate'];
		
		$instance['ids'] = $new_instance['ids'];
			
		return $instance;
	}


	/* Back-end widget form. */
		 
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
		
		?>
	
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e('Title:', 'om_theme') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		
		<!-- Category: Select Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>"><?php _e('Testimonials category:', 'om_theme') ?></label>
			<?php
				$args = array(
					'show_option_all'    => __('All Categories', 'om_theme'),
					'hide_empty'         => 0, 
					'echo'               => 1,
					'selected'           => $instance['category'],
					'hierarchical'       => 0, 
					'name'               => $this->get_field_name( 'category' ),
					'id'         		     => $this->get_field_id( 'category' ),
					'class'              => '',
					'depth'              => 0,
					'tab_index'          => 0,
					'taxonomy'           => 'testimonials-type',
					'hide_if_empty'      => false 	
				);
		
				wp_dropdown_categories( $args );

			?>
		</p>
		
		<!-- IDs: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"><?php _e('A list of testimonials ID separated with a comma to display certain testimonials.', 'om_theme') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>" value="<?php echo esc_attr( $instance['ids'] ); ?>" />
		</p>
		
		<!-- Autorotate: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'autorotate' ) ); ?>"><?php _e('Autorotate (interval in milliseconds. Leave empty to disable):', 'om_theme') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'autorotate' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'autorotate' ) ); ?>" value="<?php echo esc_attr( $instance['autorotate'] ); ?>" />
		</p>
		
		<?php
	}
}
?>