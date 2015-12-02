<?php

function om_widget_recent_posts_init() {
	register_widget( 'om_widget_recent_posts' );
}
add_action( 'widgets_init', 'om_widget_recent_posts_init' );

/* Widget Class */

class om_widget_recent_posts extends WP_Widget {

	function __construct() {
	
		parent::__construct(
			'om_widget_recent_posts',
			OM_THEME_TITLE_NAME.': '.__('Recent Posts','om_theme'),
			array(
				'classname' => 'om_widget_recent_posts',
				'description' => __('The most recent posts on your site with or without thumbnails', 'om_theme')
			)
		);
	}

	/* Front-end display of widget. */
		
	function widget( $args, $instance ) {
		extract( $args );
	
		$title = apply_filters('widget_title', $instance['title'] );
		$instance['postcount'] = intval($instance['postcount']);
	
		echo wp_kses_post($before_widget);
	
		if ( $title )
			echo wp_kses_post($before_title . $title . $after_title);
	
		if($instance['ids']) {
			$instance['postcount']='';
			$instance['category']='';
		}

		echo do_shortcode('[recent_posts'.
			($instance['ids']?' ids="'.esc_attr($instance['ids']).'"':'').
			($instance['postcount']?' count="'.esc_attr($instance['postcount']).'"':'').
			($instance['category']>0?' category="'.esc_attr($instance['category']).'"':'').
			($instance['show_thumb']?' thumbnail="true"':'').
			($instance['excerpt']?' excerpt="true"':'').']');
	
		echo wp_kses_post($after_widget);
	
	}


	/* Sanitize widget form values as they are saved. */
		
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	
		$instance['title'] = strip_tags( $new_instance['title'] );
	
		$instance['postcount'] = $new_instance['postcount'];
		$instance['category'] = $new_instance['category'];
		$instance['show_thumb'] = $new_instance['show_thumb'];
		$instance['excerpt'] = $new_instance['excerpt'];
		$instance['ids'] = $new_instance['ids'];
			
		return $instance;
	}


	/* Back-end widget form. */
		 
	function form( $instance ) {
	
		// Set up some default widget settings
		$defaults = array(
			'title' => __('Recent Posts','om_theme'),
			'postcount' => '2',
			'category' => 0,
			'show_thumb' => true,
			'excerpt' => false,
			'ids' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
	
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e('Title:', 'om_theme') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
	
		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'postcount' ) ); ?>"><?php _e('Number of posts', 'om_theme') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'postcount' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'postcount' ) ); ?>" value="<?php echo esc_attr( $instance['postcount'] ); ?>" />
		</p>

		<!-- Show Thumb: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_thumb' ) ); ?>"><?php _e('Show thumbnails', 'om_theme') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_thumb' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_thumb' ) ); ?>" value="true" <?php if( $instance['show_thumb'] == 'true') echo 'checked="checked"'; ?> />
		</p>
		
		<!-- Show Excerpt: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>"><?php _e('Show excerpt', 'om_theme') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt' ) ); ?>" value="true" <?php if( $instance['excerpt'] == 'true') echo 'checked="checked"'; ?> />
		</p>

		<!-- Category: Select Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e('Posts category:', 'om_theme') ?></label>
			<?php
				$args = array(
					'show_option_all'    => __('All Categories', 'om_theme'),
					'show_option_none'   => __('No Categories', 'om_theme'),
					'hide_empty'         => 0, 
					'echo'               => 1,
					'selected'           => $instance['category'],
					'hierarchical'       => 0, 
					'name'               => $this->get_field_name( 'category' ),
					'id'         		     => $this->get_field_id( 'category' ),
					'class'              => 'widefat',
					'depth'              => 0,
					'tab_index'          => 0,
					'taxonomy'           => 'category',
					'hide_if_empty'      => false 	
				);
		
				wp_dropdown_categories( $args );

			?>
		</p>
		
		<!-- Custom posts: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>"><?php _e('Custom post IDs', 'om_theme') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ids' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ids' ) ); ?>" value="<?php echo esc_attr( $instance['ids'] ); ?>" />
		</p>
							
	<?php
	}
}
?>