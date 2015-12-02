<?php

/**
 * Add menu item
 */

function ompf_add_options_page() {
	
	if(!$GLOBALS['omPortfolioPlugin']['config']['display_options_page'])
		return;
	
  //add_options_page(__('Portfolio Options', 'om_portfolio'), __('Portfolio Options', 'om_portfolio'), 'manage_options', 'ompf_options','ompf_options_page');
  add_submenu_page( 'edit.php?post_type=portfolio', __('Portfolio Options', 'om_portfolio'), __('Portfolio Options', 'om_portfolio'), 'manage_options', 'ompf_options', 'ompf_options_page' );
	
}
add_action('admin_menu', 'ompf_add_options_page', 11);

/**
 * Add settings for the page
 */

function ompf_add_options_settings() {
	
	global $ompf_portfolio_options;
	
	if(!$GLOBALS['omPortfolioPlugin']['config']['display_options_page'])
		return;
		
	if(isset($ompf_portfolio_options) && is_array($ompf_portfolio_options)) {
		foreach($ompf_portfolio_options as $option) {
			if(isset($option['id']) && $option['id']) {
				register_setting('ompf_settings_group', $option['id']);
			}
		}
	}
	
}
add_action('admin_init', 'ompf_add_options_settings');

/**
 * Options page content
 */

function ompf_options_page() {

	global $ompf_portfolio_options;
	
	$code='';
	?>
	<div class="wrap ompf-options-wrap">
		<div id="icon-options-general" class="icon32"><br></div>
		<h2><?php _e('Portfolio Options', 'om_portfolio'); ?></h2>

		<form method="post" action="options.php" style="max-width:800px">
	    <?php settings_fields( 'ompf_settings_group' ); ?>
	    <table class="form-table">
	<?php
		if(isset($ompf_portfolio_options) && is_array($ompf_portfolio_options)) {
			foreach($ompf_portfolio_options as $option) {
				
				if(has_filter('ompf_options_page_type_'.$option['type'])) {
					$output .= apply_filters('ompf_options_page_type_'.$option['type'], $option);
					continue;
				}
				
				switch($option['type']) {
					
					case 'text':
						echo '
							<tr valign="top">
							<th scope="row"><label for="'.$option['id'].'">'.$option['name'].'</label></th>
							<td>
								<input type="text" name="'.$option['id'].'" id="'.$option['id'].'" value="'. esc_attr(get_option($option['id'])) .'" class="regular-text" />
						';
						if(isset($option['desc']) && $option['desc'])
							echo '<p class="description">'.$option['desc'].'</p>';
						echo '
							</td>
							</tr>
						';
					break;
					
					case 'select':
						echo '
							<tr valign="top">
							<th scope="row"><label for="'.$option['id'].'">'.$option['name'].'</label></th>
							<td>
								<select name="'.$option['id'].'" id="'.$option['id'].'" >
						';
						if(isset($option['options']) && is_array($option['options'])) {
							$std=get_option($option['id']);
							foreach($option['options'] as $k=>$v) {
								echo '<option value="'.$k.'"'.($std==$k?' selected="selected"':'').'>'.$v.'</option>';
							}
						}
						echo '
								</select>
						';
						if(isset($option['desc']) && $option['desc'])
							echo '<p class="description">'.$option['desc'].'</p>';
						echo '
							</td>
							</tr>
						';
					break;

					case 'intro':
						echo '
							</table>
							<div style="margin:10px 0;border:1px solid #ccc;background:#eee;border-radius:3px;padding:13px 10px" id="'.$option['id'].'">'.$option['message'].'</div>
							<table class="form-table">
						';
					break;
					
					case 'select_page':

						echo '
							<tr valign="top">
							<th scope="row"><label for="'.$option['id'].'">'.$option['name'].'</label></th>
							<td>
								<select name="'.$option['id'].'" id="'.$option['id'].'" ><option value="0">'.__('None (default)','om_theme').'</option>
						';
						$args=array(
							'post_type' => 'page',
							'post_status' => 'publish,private,pending,draft',
						);
						$arr=get_pages($args);
						$defaults = array(
							'depth' => 0, 'child_of' => 0,
							'selected' => get_option($option['id']), 'echo' => 0,
						);
		        $r = wp_parse_args( $args, $defaults );
		        echo walk_page_dropdown_tree($arr, 0, $r);
						echo '
								</select>
						';
						if(isset($option['desc']) && $option['desc'])
							echo '<p class="description">'.$option['desc'].'</p>';
						echo '
							</td>
							</tr>
						';
		
					break;
										
				}
				if(isset($option['code']))
					$code.=$option['code'];
			}
		}
	?>
	    </table>
	    
	    <?php submit_button(); ?>
		</form>
		<?php echo $code ?>
	</div>
<?php

}