<?php

if($GLOBALS['omTestimonialsPlugin']['config']['update_api_url']) {

	// Take over the update check
	add_filter('pre_set_site_transient_update_plugins', 'omtm_check_for_plugin_update');
	
	function omtm_check_for_plugin_update($checked_data) {
		global $wp_version;
		
		//Comment out these two lines during testing.
		if (empty($checked_data->checked) || !isset($checked_data->checked[ $GLOBALS['omTestimonialsPlugin']['plugin_basename'] ]))
			return $checked_data;
		
		$plugin_slug=basename(dirname( $GLOBALS['omTestimonialsPlugin']['plugin_basename'] ));
		
		$args = array(
			'slug' => $plugin_slug,
			'version' => $checked_data->checked[ $GLOBALS['omTestimonialsPlugin']['plugin_basename'] ],
		);
		$request_string = array(
			'body' => array(
				'action' => 'basic_check',
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
		
		// Start checking for an update
		$raw_response = wp_remote_post($GLOBALS['omTestimonialsPlugin']['config']['update_api_url'], $request_string);
		
		if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
			$response = unserialize($raw_response['body']);
		
		if (is_object($response) && !empty($response)) // Feed the update data into WP updater
			$checked_data->response[ $GLOBALS['omTestimonialsPlugin']['plugin_basename'] ] = $response;
		
		return $checked_data;
	}
	
	
	// Take over the Plugin info screen
	add_filter('plugins_api', 'omtm_plugin_api_call', 10, 3);
	
	function omtm_plugin_api_call($def, $action, $args) {
		global $wp_version;
		
		$plugin_slug=basename(dirname( $GLOBALS['omTestimonialsPlugin']['plugin_basename'] ));
		
		if (!isset($args->slug) || ($args->slug != $plugin_slug))
			return false;
		
		$request_string = array(
			'body' => array(
				'action' => $action,
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
		
		$request = wp_remote_post($GLOBALS['omTestimonialsPlugin']['config']['update_api_url'], $request_string);
		
		if (is_wp_error($request)) {
			$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
		} else {
			$res = unserialize($request['body']);
		
			if ($res === false)
				$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
		}
		
		return $res;
	}
	
}