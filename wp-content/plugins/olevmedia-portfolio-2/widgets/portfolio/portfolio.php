<?php

function ompf_widget_portfolio_init() {
	register_widget( 'ompf_widget_portfolio' );
}
add_action( 'widgets_init', 'ompf_widget_portfolio_init' );

/* Widget Class */

class ompf_widget_portfolio extends WP_Widget {

	private $instance_defaults;
	
	function __construct() {
	
		parent::__construct(
			'ompf_widget_portfolio',
			__('Olevmedia Portfolio: Recent Works','om_portfolio'),
			array(
				'classname' => 'ompf_widget_portfolio',
				'description' => __('Recent Portfolio Items', 'om_portfolio')
			)
		);
		
		$this->instance_defaults = array(
			'title' => 'Recent Works',
			'postcount' => '2',
			'preview_layout' => 'full',
			'category' => 0,
			'ids' => '',
			'ratio' => '3:2',
			'randomize' => '',
		);
		
	}

	/* Front-end display of widget. */
		
	function widget( $args, $instance ) {
		extract( $args );
		
		$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
	
		$title = apply_filters('widget_title', $instance['title'] );
	
		echo $before_widget;
	
		if ( $title )
			echo $before_title . $title . $after_title;

		if($instance['ids']) {
			$instance['postcount']='';
			$instance['category']='';
		}
		
		echo do_shortcode('[portfolio widget_mode="true"'.
			($instance['ids']?' ids="'.$instance['ids'].'"':'').
			($instance['postcount']?' count="'.$instance['postcount'].'"':'').
			($instance['ratio']?' ratio="'.$instance['ratio'].'"':'').
			($instance['preview_layout']?' preview_layout="'.$instance['preview_layout'].'"':'').
			($instance['category']>0?' category="'.$instance['category'].'"':'').
			($instance['randomize']?' randomize="true"':'').']');

		echo $after_widget;
	
	}


	/* Sanitize widget form values as they are saved. */
		
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
	
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['preview_layout'] = $new_instance['preview_layout'];
		$instance['postcount'] = $new_instance['postcount'];
		$instance['category'] = $new_instance['category'];
		$instance['ratio'] = $new_instance['ratio'];
		$instance['randomize'] = $new_instance['randomize'];
		$instance['ids'] = $new_instance['ids'];
			
		return $instance;
	}


	/* Back-end widget form. */
		 
	function form( $instance ) {
	
		$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
		
		?>
	
		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e('Title:', 'om_portfolio') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
	
		<!-- Postcount: Text Input -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'postcount' )); ?>"><?php _e('Number of posts', 'om_portfolio') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'postcount' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'postcount' )); ?>" value="<?php echo esc_attr($instance['postcount']); ?>" />
		</p>
		
		<!-- Layout -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'preview_layout' )); ?>"><?php _e('Preview layout', 'om_portfolio') ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'preview_layout' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'preview_layout' )); ?>">
			<?php
			$opts=ompf_get_options_arr('preview_layout');
			foreach($opts as $k=>$v)
				echo '<option value="'.$k.'"'.($k==$instance['preview_layout']?' selected="selected"':'').'>'.$v.'</option>';
			?>
			</select>
		</p>
		

		<!-- Ratio: Text Input -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'ratio' )); ?>"><?php _e('Thumbnails width/height ratio', 'om_portfolio') ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'ratio' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'ratio' )); ?>">
			<?php
			$opts=ompf_get_options_arr('ratio');
			foreach($opts as $k=>$v)
				echo '<option value="'.$v.'"'.($v==$instance['ratio']?' selected="selected"':'').'>'.$v.'</option>';
			?>
			</select>
		</p>
		
		<!-- Randomize: Check Box -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'randomize' )); ?>"><?php _e('Randomize items', 'om_portfolio') ?></label>
			<input type="checkbox" id="<?php echo esc_attr($this->get_field_id( 'randomize' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'randomize' )); ?>" value="true" <?php if( $instance['randomize'] == 'true') echo 'checked="checked"'; ?> />
		</p>
		
		<!-- Category: Select Box -->
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e('Portfolio category:', 'om_portfolio') ?></label>
			<?php
				$args = array(
					'show_option_all'    => __('All Categories', 'om_portfolio'),
					'show_option_none'   => __('No Categories', 'om_portfolio'),
					'hide_empty'         => 0, 
					'echo'               => 1,
					'selected'           => $instance['category'],
					'hierarchical'       => 0, 
					'name'               => $this->get_field_name( 'category' ),
					'id'         		     => $this->get_field_id( 'category' ),
					'class'              => '',
					'depth'              => 0,
					'tab_index'          => 0,
					'taxonomy'           => 'portfolio-type',
					'hide_if_empty'      => false 	
				);
		
				wp_dropdown_categories( $args );

			?>
		</p>
		
		<!-- Custom items: Text Input -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'ids' )); ?>"><?php _e('Custom portfolio item IDs', 'om_portfolio') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'ids' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'ids' )); ?>" value="<?php echo esc_attr($instance['ids']); ?>" />
		</p>
						
					
	<?php
	}
}
?>