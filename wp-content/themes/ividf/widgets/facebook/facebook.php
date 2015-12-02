<?php

function om_widget_facebook_init() {
	register_widget( 'om_widget_facebook' );
}
add_action( 'widgets_init', 'om_widget_facebook_init' );

/* Widget Class */

class om_widget_facebook extends WP_Widget {
	
	private $instance_defaults;

	function __construct() {
	
		parent::__construct(
			'om_widget_facebook',
			OM_THEME_TITLE_NAME.': '.__('Facebook Like Box','om_theme'),
			array(
				'classname' => 'om_widget_facebook',
				'description' => __('Widget that enables Facebook Page owners to attract and gain Likes from your own website.', 'om_theme')
			)
		);
		
		$this->instance_defaults = array(
			'title' => '',
			'url' => 'http://www.facebook.com/platform',
			'hide_cover' => 'false',
			'show_faces' => 'true',
			'show_stream' => 'true',
		);
	}

	/* Front-end display of widget. */
		
	function widget( $args, $instance ) {
		extract( $args );
	
		$instance = wp_parse_args( (array) $instance, $this->instance_defaults );
		
		$title = apply_filters('widget_title', $instance['title'] );
	
		echo wp_kses_post($before_widget);
	
		if ( $title )
			echo wp_kses_post($before_title . $title . $after_title);
			
		//if($instance['no_margins'] == 'true')
		//	echo '<div class="sidebar-eat-margins">';
	
			$lang='en_US';
			if(WPLANG)
				$lang=WPLANG;
		?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/<?php echo esc_attr($lang)?>/sdk.js#xfbml=1&version=v2.3";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			<div class="fb-page" data-href="<?php echo esc_attr($instance['url']) ?>" data-hide-cover="<?php echo ($instance['hide_cover']=='true'?'true':'false') ?>" data-show-facepile="<?php echo ($instance['show_faces']=='true'?'true':'false') ?>" data-show-posts="<?php echo ($instance['show_stream']=='true'?'true':'false') ?>"><div class="fb-xfbml-parse-ignore"></div></div>
		<?php
	
		echo wp_kses_post($after_widget);
	
	}


	/* Sanitize widget form values as they are saved. */
		
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
	
		$instance['url'] = $new_instance['url'] ;
		$instance['hide_cover'] = $new_instance['hide_cover'];
		$instance['show_faces'] = $new_instance['show_faces'];
		$instance['show_stream'] = $new_instance['show_stream'];
		
	
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
			
		<!-- Widget URL: Text Input -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e('Facebook Page URL:', 'om_theme') ?></label>
			<input class="widefat" type="text" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" value="<?php echo esc_attr( $instance['url'] ); ?>" />
		</p>

		<!-- Hide Cover: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php _e('Hide cover Photo', 'om_theme') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" value="true" <?php if( $instance['hide_cover'] == 'true') echo 'checked="checked"'; ?> />
		</p>
		
		<!-- Show Faces: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>"><?php _e('Show Faces', 'om_theme') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_faces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_faces' ) ); ?>" value="true" <?php if( $instance['show_faces'] == 'true') echo 'checked="checked"'; ?> />
		</p>
	
		<!-- Stream: Check Box -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>"><?php _e('Show Stream', 'om_theme') ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_stream' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_stream' ) ); ?>" value="true" <?php if( $instance['show_stream'] == 'true') echo 'checked="checked"'; ?> />
		</p>
		
		<?php
	}
}
?>