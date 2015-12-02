<?php

/**
 *
 * Class Shortcode adds and displays the Shortcode
 *
 * @ Custom Login Page
 *
 */
class CLP_Shortcode {
	
	static $options;
	
	function __construct($multisite) {
		
		self::$options = ($multisite) ? get_site_option('clp_shortcode_options') : self::$options = get_option('clp_shortcode_options');
		
		add_shortcode('a5-login-form', array($this, 'clp_display'));
		
	}

	/**
	 *
	 * Display the login form with shortcode
	 *
	 */
	public function clp_display() {
		
		ob_start();
		
		if (!is_user_logged_in()) :
		
			$formargs['redirect'] = (isset(self::$options['redirect']) && !empty(self::$options['redirect'])) ? self::$options['redirect'] : home_url($_SERVER['REQUEST_URI']);						
			$formargs['form_id'] = (isset(self::$options['form_id']) && !empty(self::$options['form_id'])) ? self::$options['form_id'] : 'loginform';
			$formargs['label_username'] = (isset(self::$options['label_username']) && !empty(self::$options['label_username'])) ? self::$options['label_username'] : __('Username');
			$formargs['label_password'] = (isset(self::$options['label_password']) && !empty(self::$options['label_password'])) ? self::$options['label_password'] : __('Password');
			$formargs['label_remember'] = (isset(self::$options['label_remember']) && !empty(self::$options['label_remember'])) ? self::$options['label_remember'] : __('Remember Me');
			$formargs['label_log_in'] = (isset(self::$options['label_log_in']) && !empty(self::$options['label_log_in'])) ? self::$options['label_log_in'] : __('Log In');
			$formargs['id_username'] = (isset(self::$options['id_username']) && !empty(self::$options['id_username'])) ? self::$options['id_username'] : 'user_login';
			$formargs['id_password'] = (isset(self::$options['id_password']) && !empty(self::$options['id_password'])) ? self::$options['id_password'] : 'user_pass';
			$formargs['id_remember'] = (isset(self::$options['id_remember']) && !empty(self::$options['id_remember'])) ? self::$options['id_remember'] : 'rememberme';
			$formargs['id_submit'] = (isset(self::$options['id_submit']) && !empty(self::$options['id_submit'])) ? self::$options['id_submit'] : 'wp-submit';
			$formargs['remember'] = (isset(self::$options['hide_remember']) && !empty(self::$options['hide_remember'])) ? false : true;
			$formargs['value_username'] = (isset(self::$options['value_username']) && !empty(self::$options['value_username'])) ? self::$options['value_username'] : NULL;
			$formargs['value_remember'] = (isset(self::$options['value_remember']) && !empty(self::$options['value_remember'])) ? true : false;
			
			if (isset(self::$options['title']) && !empty(self::$options['title'])) $title_tag = ' title="'.self::$options['title'].'"';
			
			if (isset(self::$options['logo']) && !empty(self::$options['logo'])) $img_tag = '<img src="'.self::$options['logo'].'"'.$title_tag.' />';
			
			if (isset($img_tag)) echo (isset(self::$options['url']) && !empty(self::$options['url'])) ? '<a href="'.self::$options['url'].'"'.$title_tag.'>'.$img_tag.'</a>' : $img_tag;
			
			if (isset(self::$options['login_message']) && !empty(self::$options['login_message'])) echo self::$options['login_message'];
			
			wp_login_form($formargs);
			
			if (isset(self::$options['login_footer']) && !empty(self::$options['login_footer'])) : echo self::$options['login_footer']; 
			
			endif;
		
		else :
		
			wp_loginout( home_url() );
			
			echo ' | ';
			
			wp_register('', '');
			
		endif;
		
		$output = ob_get_contents();
		
		ob_end_clean();
		
		return $output;
		
	}

}

?>