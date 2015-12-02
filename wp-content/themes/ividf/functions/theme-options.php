<?php

require_once (TEMPLATE_DIR . '/functions/theme-options-fields.php');

/*************************************************************************************
 *	Add default options after activation
 *************************************************************************************/

function om_option_setup(){

	$options_template = om_get_options_template();
	
	foreach($options_template as $option) {
		if(isset($option['id'])) {
			$db_option = get_option($option['id']);
			if($db_option === false){
				update_option($option['id'], $option['std']);
			}
		}
	}
	
	do_action('om_options_updated');
}

if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	add_action('admin_head','om_option_setup');
}

/*************************************************************************************
 *	Admin Backend Message
 *************************************************************************************/

function om_options_admin_head() { 
	
	//Tweaked the message on theme activate
	?>
  <script type="text/javascript">
  jQuery(function(){
		var message = '<p>This theme comes with an <a href="<?php echo admin_url('themes.php?page=om_options'); ?>">options panel</a> to configure settings.</p>';
  	jQuery('.themes-php #message2').html(message);
  });
  </script>
  <?php
}

add_action('admin_head', 'om_options_admin_head'); 

/*************************************************************************************
 *	Options Admin Interface
 *************************************************************************************/
 
function om_options_add_admin() {

  add_menu_page(__('Theme Options', 'om_theme'), __('Theme Options', 'om_theme'), 'edit_theme_options', 'om_options','om_options_page', '', 61.87);
	
} 

add_action('admin_menu', 'om_options_add_admin');

/*************************************************************************************
 *	Reset/Import/Export Options
 *************************************************************************************/
 
function om_options_rie() {

  // Reset Options
  if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'om_options' && isset($_REQUEST['om_options_action']) && $_REQUEST['om_options_action'] == 'reset') {
		om_reset_options();
		header("Location: admin.php?page=om_options&reset=true");
		die;
  }

	// Export Options
  if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'om_options' && isset($_REQUEST['om_options_action']) && $_REQUEST['om_options_action'] == 'export') {
  	$dump=om_options_export_dump();
  	header("Content-Type: text/plain");
  	header("Content-Length: ".strlen($dump)."\n\n");
  	header("Content-Disposition: attachment; filename=".OM_THEME_NAME.".options.dat");
		echo  $dump; //not escape needed: serialized array, output to file
		die;
  }
  
  // Import Options
  if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'om_options' && isset($_REQUEST['om_options_action']) && $_REQUEST['om_options_action'] == 'import' ) {
  	if(@$_FILES['import_file']['tmp_name']) {
  		if ( om_options_do_import($_FILES['import_file']['tmp_name']) ) {
				header("Location: admin.php?page=om_options&import_ok=true");
				die;
  		}
  	}
  	header("Location: admin.php?page=om_options&import_error=true");
		die;
  }
	
}

add_action('admin_init', 'om_options_rie');

function om_options_do_import($file) {
	$s=trim(file_get_contents($file));
	$options=@unserialize($s);
	
	return om_options_do_import_data($options);
}

function om_options_do_import_data($options) {
	if(is_array($options)) {
		if($options['theme_prefix'] == OM_THEME_PREFIX) {
			foreach($options['options'] as $k=>$v) {
				update_option($k, $v);
			}
			do_action('om_options_updated');
			return true;
		}
	}
	
	return false;
}

/*************************************************************************************
 *	Options Reset Function
 *************************************************************************************/

function om_reset_options() {

	$options_template = om_get_options_template();
	
	foreach($options_template as $option) {
		if(isset($option['id'])) {
			update_option($option['id'], $option['std']);
		}
	}
	
	do_action('om_options_updated');
}

/*************************************************************************************
 *	Export Options
 *************************************************************************************/
 
function om_options_export_dump() {

	$options =  om_get_options_template();

	$output = array('theme_prefix' => OM_THEME_PREFIX, 'options' => array());
	
	foreach ($options as $value) {
	   
	  if(isset($value['id']) && $value['id'])
	  {
	  	$output['options'][$value['id']] = get_option($value['id']);
	  }
  
	}

	return serialize($output);
}

/*************************************************************************************
 *	Build the Options Page
 *************************************************************************************/

function om_options_page(){
	$options =  om_get_options_template();
	?>

	<div class="wrap" id="om-container">
		<div id="om-popup-save" class="om-popup"><div><?php _e('Options Updated', 'om_theme'); ?></div></div>
		<div id="om-popup-reset" class="om-popup"><div><?php _e('Options Reset', 'om_theme'); ?></div></div>
		<div id="om-popup-import-ok" class="om-popup"><div><?php _e('Options Imported', 'om_theme'); ?></div></div>
		<div id="om-popup-import-error" class="om-popup"><div><?php _e('Sorry, there has been an error while import', 'om_theme'); ?></div></div>
		<form action="" enctype="multipart/form-data" id="om-options-form">
			<div id="om-container-header">
				<div class="icon-options"></div>
				<div class="logo">
					<h2><?php _e('Theme Options', 'om_theme'); ?></h2>
				</div>
				<div class="clear"></div>
		   </div>
			<?php $options_html = om_options_generator($options); ?>
			<div class="save_bar top">
				<img style="display:none;margin-right:7px;vertical-align:middle" src="<?php echo TEMPLATE_DIR_URI ?>/admin/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
				<input type="submit" value="<?php _e('Save All Changes','om_theme');?>" class="button-primary" />
			</div>
			<div id="om-container-pane">
				<div id="om-options-sections">
					<ul>
						<?php echo om_esc_sg($options_html['menu']); ?>
					</ul>
				</div>
				<div id="om-options-content">
					<?php echo om_esc_sg($options_html['options']); ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="save_bar bottom">
				<input type="button" value="<?php _e('Reset Options','om_theme');?>" class="button submit-button reset-button" onclick="if(confirm('Click OK to reset. Any settings will be lost!')){document.getElementById('om-options-form-reset').submit()}">
				<img style="display:none;margin-right:7px;vertical-align:middle" src="<?php echo TEMPLATE_DIR_URI ?>/admin/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
				<input type="submit" value="<?php _e('Save All Changes','om_theme');?>" class="button-primary" />
			</div>
		</form>
		<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" id="om-options-form-reset">
			<input type="hidden" name="om_options_action" value="reset" />
		</form>
	</div>
	
	<div class="clear"></div>
	<p><a href="#" onclick="jQuery('#om_options_import_export').slideToggle(200);return false;"><?php _e('(+) Export / Import Options','om_theme'); ?></a></p>
	
	<div id="om_options_import_export" style="display:none;border-left:1px solid #eee;padding-left:20px">
		<b><?php _e('Export:','om_theme'); ?></b>
		<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" target="_blank">
			<input type="submit" value="<?php _e('Download Export File','om_theme');?>" class="button" />
			<input type="hidden" name="om_options_action" value="export" />
		</form>
	
		<br />
		<b><?php _e('Import:','om_theme'); ?></b>
		<form action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" method="post" enctype="multipart/form-data">
			<?php _e('Choose a file from your computer:','om_theme'); ?>
			<input type="file" name="import_file" size="25" />
			<input type="submit" value="<?php _e('Upload and Import','om_theme');?>" class="button" />
			<input type="hidden" name="om_options_action" value="import" />
		</form>
	</div>

	<div class="clear"></div>
<?php
}

/*************************************************************************************
 *	Load required CSS/JS for Options Page
 *************************************************************************************/
 
function om_enqueue_scripts_options_scripts($hook) {
	if('toplevel_page_om_options' != $hook)
		return;
		
	wp_enqueue_style('theme-options', TEMPLATE_DIR_URI.'/admin/css/theme-options.css', array(), OM_THEME_VERSION);
	wp_enqueue_style('wp-color-picker');
	
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('wp-color-picker');
	om_enqueue_admin_browse_button();
	wp_enqueue_script('theme-options', TEMPLATE_DIR_URI.'/admin/js/theme-options.js', array(), OM_THEME_VERSION);

	add_action('admin_head', 'om_admin_head');
	
}
add_action('admin_enqueue_scripts', 'om_enqueue_scripts_options_scripts');

function om_admin_head() {
	?>
 	<script type="text/javascript" language="javascript">
		jQuery(document).ready(function(){
			
			<?php if(isset($_REQUEST['reset'])) { ?>
				var reset_popup = jQuery('#om-popup-reset');
				reset_popup.fadeIn();
				window.setTimeout(function(){
					reset_popup.fadeOut();                        
				}, 2000);
			<?php } ?>
			
			<?php if(isset($_REQUEST['import_ok'])) { ?>
				var import_ok_popup = jQuery('#om-popup-import-ok');
				import_ok_popup.fadeIn();
				window.setTimeout(function(){
					import_ok_popup.fadeOut();                        
				}, 3000);
			<?php } ?>

			<?php if(isset($_REQUEST['import_error'])) { ?>
				var import_ok_error = jQuery('#om-popup-import-error');
				import_ok_error.fadeIn();
				window.setTimeout(function(){
					import_ok_error.fadeOut();                        
				}, 4000);
			<?php } ?>
			
		});
		</script>
<?php
}

/*************************************************************************************
 *	Ajax Save Action
 *************************************************************************************/

add_action('wp_ajax_om_theme_options_ajax', 'om_ajax_callback');

function om_ajax_callback() {

	$action = $_POST['type'];
	
	if ( get_magic_quotes_gpc() ) {
		$_POST = stripslashes_deep( $_POST );
	}
	
	// Save All Options
	if ($action == 'options') {
		
		parse_str($_POST['data'],$output);
		$output=array_map( 'stripslashes_deep', $output );
		
   	$options = om_get_options_template();
		
		foreach($options as $option_array) {

			if(isset($option_array['id'])) { // Non - Headings...

				$id = $option_array['id'];
				$new_value = '';
				
				if(isset($output[$id])){
					$new_value = $output[$id];
				}
		
				switch($option_array['type']) {
					
					case 'checkbox':
					
						if($new_value == 'true')
							update_option($id,'true');
						else
							update_option($id,'false');
							
					break;
					
					case 'multicheck':
					
						$option_options = $option_array['options'];
	
						$tmp=array();					
						foreach ($option_options as $options_id => $options_value){
							
						  $tmp[$options_id]=isset($output[$id][$options_id]);
						}
						update_option($id,$tmp);
							
					break;
					
					case 'form_fields':
					
						if(!is_array(@$output[$id]))
							$output[$id]=array();
						
						update_option($id,$output[$id]);
							
					break;
					
					case 'styling_presets':
					
						$tmp=array();
						
						if(is_array($option_array['options'])) {
							foreach($option_array['options'] as $k) {
								$tmp[$k]=@$output[$k];
							}
						}
						$name=$output[$id.'_new'];
						if($name) {
							$output[$id] = get_option($id);
							$output[$id][$name] = $tmp;
							update_option($id,$output[$id]);
						}
							
					break;
					
					default:
					
						update_option($id,$new_value);
						
					break;
					
				}
			}	
		}
		
		do_action('om_options_updated');
		
	}
	// Apply Styling
	elseif ($action == 'style_preset_apply') {
		
		$data = $_POST['data'];
		if(@$data['id'] && @$data['name']) {
			$presets = get_option($data['id']);
			$data['name']=urldecode($data['name']);
			
			if(is_array(@$presets[$data['name']])) {
				foreach($presets[$data['name']] as $k=>$v) {
					update_option($k,$v);
				}
			}
			do_action('om_options_updated');
			
		}
	}
	// Remove Styling
	elseif ($action == 'style_preset_remove') {
		
		$data = $_POST['data'];
		if(@$data['id'] && @$data['name']) {
			
			$presets = get_option($data['id']);
			unset($presets[urldecode($data['name'])]);
			
			update_option($data['id'],$presets);
			
		}
	}
	
  die();

}


/*************************************************************************************
 *	Generates The Options
 *************************************************************************************/
 
function om_options_generator($options) {

  $counter = 0;
	$menu = '';
	$output = '';
	foreach ($options as $value) {
	   
		$counter++;
		$val = '';
		//Start Heading
		if ( $value['type'] != "heading" )
		{
			$output .= '<div class="om-options-section section-'.$value['type'].'">';
			if(@$value['mode'] == 'toggle') {
				$output .= '<h3 class="heading"><a href="#" onclick="jQuery(\'#'.$value['id'].'-container\').slideToggle(300);return false">'. $value['name'] .' [+]</a></h3>';
				$output .= '<div class="option" id="'.$value['id'].'-container" style="display:none"><div class="om-options-controls">';
			} else {
				$output .= '<h3 class="heading">'. $value['name'] .'</h3>';
				$output .= '<div class="option"><div class="om-options-controls">';
			}
		}
		//End Heading
		$select_value = '';                                   
		switch ( $value['type'] ) {
		
			case 'text':
				$val = $value['std'];
				$std = get_option($value['id']);
				if ( $std != "")
					$val = $std;
				$output .= '<input name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. esc_attr($val) .'" class="om-options-input" />';
			break;
			
			case 'select':
	
				$output .= '<select name="'. $value['id'] .'" id="'. $value['id'] .'" class="om-options-input">';
				$select_value = get_option($value['id']);
				foreach ($value['options'] as $option) {
					$selected = '';
					 if($select_value != '') {
						 if ( $select_value == $option )
						 	$selected = ' selected="selected"';
				   } else {
						 if ( isset($value['std']) )
							 if ($value['std'] == $option)
							 	$selected = ' selected="selected"';
					 }
					 $output .= '<option'. $selected .'>'.$option.'</option>';
				 } 
				 $output .= '</select>';
			break;
			
			case 'select-cat':
				
				$val = $value['std'];
				$std = get_option($value['id']);
				if ( $std != "") { $val = $std; }
				
				$args = array(
					'show_option_all'    => __('All Categories', 'om_theme'),
					'show_option_none'   => __('No Categories', 'om_theme'),
					'hide_empty'         => 0, 
					'echo'               => 0,
					'selected'           => $val,
					'hierarchical'       => 0, 
					'name'               => $value['id'],
					'class'              => 'postform',
					'depth'              => 0,
					'tab_index'          => 0,
					'taxonomy'           => 'category',
					'hide_if_empty'      => false 	
				);
		
				 $output .= '<div class="om-options-input">'.wp_dropdown_categories( $args ).'</div>';
			break;
			
			case 'select-page':
				
				$val = $value['std'];
				$std = get_option($value['id']);
				if ( $std != "") { $val = $std; }
				
				/*
				$args = array(
					'selected'         => $val,
					'echo'             => 0,
					'name'             => $value['id'],
					'show_option_none' => 'None (default)',
					'option_none_value' => 0,
				);
				$output .= '<div class="om-options-input">'.wp_dropdown_pages( $args ).'</div>';
				*/
			
				$args=array(
					'post_type' => 'page',
					'post_status' => 'publish,private,pending,draft',
				);
				$arr=get_pages($args);
				$defaults = array(
					'depth' => 0, 'child_of' => 0,
					'selected' => $val, 'echo' => 0,
				);
        $r = wp_parse_args( $args, $defaults );
				$output .= '<div class="om-options-input"><select name="'.$value['id'].'"><option value="0">'.__('None (default)','om_theme').'</option>';
				$output .= walk_page_dropdown_tree($arr, 0, $r);
				$output .= '</select></div>';
		

			break;

			case 'select-tax':
				
				$val = $value['std'];
				$std = get_option($value['id']);
				if ( $std != "") { $val = $std; }
				
				$args = array(
					'show_option_all'    => __('All', 'om_theme').' '.$value['taxonomy'],
					'show_option_none'   => __('No', 'om_theme').' '.$value['taxonomy'],
					'hide_empty'         => 0, 
					'echo'               => 0,
					'selected'           => $val,
					'hierarchical'       => 0, 
					'name'               => $value['id'],
					'class'              => 'postform',
					'depth'              => 0,
					'tab_index'          => 0,
					'taxonomy'           => $value['taxonomy'],
					'hide_if_empty'      => false 	
				);
		
				$output .= '<div class="om-options-input">'.@wp_dropdown_categories( $args ).'</div>';
			break;
			
			case 'select2':
	
				$output .= '<select name="'. $value['id'] .'" id="'. $value['id'] .'" class="om-options-input">';
			
				$select_value = get_option($value['id']);
				 
				foreach ($value['options'] as $option => $name) {
					
					$selected = '';
					
					 if($select_value != '') {
						 if ( $select_value == $option) { $selected = ' selected="selected"';} 
				     } else {
						 if ( isset($value['std']) )
							 if ($value['std'] == $option) { $selected = ' selected="selected"'; }
					 }
					  
					 $output .= '<option'. $selected .' value="'.$option.'">'.$name.'</option>';
				 
				 } 
				 $output .= '</select>';
			break;

			case 'textarea':
				
				$rows = '8';
				$ta_value = '';
				if(isset($value['std'])) {
					$ta_value = $value['std']; 
				}
				$std = get_option($value['id']);
				if( $std != "") { $ta_value = stripslashes( $std ); }
				if(isset($value['rows'])){
					$rows = $value['rows'];
				}
				$output .= '<textarea name="'. $value['id'] .'" id="'. $value['id'] .'" rows="'.$rows.'" class="om-options-input">'.esc_textarea($ta_value).'</textarea>';
			break;

			case "radio":
				
				 $select_value = get_option( $value['id']);
					   
				 foreach ($value['options'] as $key => $option) 
				 { 
	
					 $checked = '';
					   if($select_value != '') {
							if ( $select_value == $key) { $checked = ' checked'; } 
					   } else {
						if ($value['std'] == $key) { $checked = ' checked'; }
					   }
					$output .= '<label><input type="radio" name="'. $value['id'] .'" value="'. $key .'" '. $checked .' /> ' . $option .'</label><br />';
				
				}
			break;

			case "checkbox": 
			
				$std = $value['std'];  
				$saved_std = get_option($value['id']);
				$checked = '';
				
				if(!empty($saved_std)) {
					if($saved_std == 'true') {
					$checked = 'checked="checked"';
					}
					else{
					   $checked = '';
					}
				}
				elseif( $std == 'true') {
				   $checked = 'checked="checked"';
				}
				else {
					$checked = '';
				}
				$output .= '<input type="checkbox" name="'.  $value['id'] .'" id="'. $value['id'] .'" value="true" '. $checked .' />';
			break;
			
			case "multicheck":
			
				$std =  $value['std'];         
				$saved_std = get_option($value['id']);
				
				foreach ($value['options'] as $key => $option) {
												 
					if(!empty($saved_std)) { 
					  if($saved_std[$key] == 'true'){
						 $checked = 'checked="checked"';  
					  } 
					  else{
						  $checked = '';   
					  }    
					} 
					elseif( $std[$key] == 'true') {
					  $checked = 'checked="checked"';
					}
					else {
						$checked = '';
					}
					
					$output .= '<input type="checkbox" name="'. $value['id'] .'['.$key.']" id="'. $value['id'] .'_'.$key .'" value="true" '. $checked .' /><label for="'. $value['id'] .'_'.$key .'">'. $option .'</label><br />';

				}
			break;
			
			case "upload":
			
				$val = $value['std'];
				$std = get_option($value['id']);
				if ( $std != "")
					$val = $std;
				$strip_id=str_replace(']','',str_replace('[','_',$value['id']));
	
				$output .= '
					<input name="'. $value['id'] .'" id="'. $strip_id .'_input" type="text" value="'. esc_attr($val) .'" class="om-options-input" />
					<div class="upload_button_div">
						<span class="button input-browse-button" id="'.$strip_id.'" rel="'. $strip_id .'_input" data-mode="preview" data-base-id="'.$strip_id.'" data-library="image" data-choose="'.__('Choose a file','om_theme').'" data-select="'.__('Select','om_theme').'">Browse Image</span>
						<span class="button input-browse-button-remove" id="'. $strip_id .'_remove" data-base-id="'.$strip_id.'" title="">Remove</span>
					</div>
					<div class="clear"></div>
					<div class="om-option-image-preview" id="'.$strip_id.'_image">'.($val? '<a href="'.esc_url($val).'" target="_blank"><img src="'.esc_url($val).'" /></a>':'').'</div>
					<div class="clear"></div>
				';
  			
			break;

			case "note":
			
				$output .= '<div class="notes"><p>'. $value['message'] .'</p></div>';
			break;
			
			case "intro":
			
				$output .= '<div class="intro"><p>'. $value['message'] .'</p></div>';
			break;
			
			case "subheader":
			
				$output .= '<div class="subheader"><p>'. $value['message'] .'</p></div>';
			break;
			
			case "color":
			
				$val = $value['std'];
				$stored  = get_option( $value['id'] );
				if ( $stored != "") { $val = $stored; }
				//$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
				//$output .= '<input class="om-option-color" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
				$output .= '<input class="wp-color-picker-field" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. esc_attr($val) .'" data-default-color="'. esc_attr($val) .'" />';
			break;   
			
			
			case 'font':

				$stored = get_option($value['id']);
				if(!is_array($stored))
					$stored=$value['std'];
	
				$output .= __('Source:','om_theme').' <select name="'. $value['id'] .'[type]" id="'. $value['id'] .'" style="width:auto" onchange="jQuery(\'.om-font-'.$value['id'].'-type-box\').hide();jQuery(\'#'. $value['id'] .'_container_\'+this.value).show()">';
			
				$output .= '<option value="standard"'.(@$stored['type']=='standard'?' selected="selected"':'').'>'.__('Standard fonts','om_theme').'</option>';
				$output .= '<option value="google"'.(@$stored['type']=='google'?' selected="selected"':'').'>'.__('Google.Fonts','om_theme').'</option>';
				$output .= '<option value="external"'.(@$stored['type']=='external'?' selected="selected"':'').'>'.__('Any external fonts (e.g. Typekit)','om_theme').'</option>';
				$output .=  '</select>';
				
				$output .= '<div id="'. $value['id'] .'_container_standard" class="om-font-'.$value['id'].'-type-box"'.((@$stored['type']=='standard' || @$stored['type'] == '')?'':' style="display:none"').'>';
				$output .= __('Font family:','om_theme').' <select name="'. $value['id'] .'[standard][family]" id="'. $value['id'] .'_standard_family" style="width:auto">';
				foreach ($value['options'] as $option => $name) {
					$output .= '<option value="'.$option.'"'.(@$stored['standard']['family']==$option?' selected="selected"':'').'>'.$name.'</option>';
				} 
				$output .= '</select>';
				$output .= '</div>';
				
				$output .= '<div id="'. $value['id'] .'_container_google" class="om-font-'.$value['id'].'-type-box"'.((@$stored['type']=='google')?'':' style="display:none"').'>';
				$output .= __('Font name:','om_theme').' <input name="'. $value['id'] .'[google][family]" id="'. $value['id'] .'_google_family" type="text" value="'. esc_attr(@$stored['google']['family']) .'" style="width:250px" />';
				$output .= '<div class="om-options-note">'.__('Choose the the font from <a href="http://www.google.com/fonts" target="_blank">http://www.google.com/fonts</a> and enter the name.', 'om_theme').'</div>';
				if(!isset($stored['google']['weight_normal']))
					$stored['google']['weight_normal']=400;
				$output .= __('Font weight for normal text:','om_theme').' <select name="'. $value['id'] .'[google][weight_normal]" id="'. $value['id'] .'_google_weight_normal" style="width:150px">
						<option value="100"'.(@$stored['google']['weight_normal']==100?' selected="selected"':'').'>100</option>
						<option value="200"'.(@$stored['google']['weight_normal']==200?' selected="selected"':'').'>200</option>
						<option value="300"'.(@$stored['google']['weight_normal']==300?' selected="selected"':'').'>300</option>
						<option value="400"'.(@$stored['google']['weight_normal']==400?' selected="selected"':'').'>400 ('.__('standard','om_theme').')</option>
						<option value="500"'.(@$stored['google']['weight_normal']==500?' selected="selected"':'').'>500</option>
						<option value="600"'.(@$stored['google']['weight_normal']==600?' selected="selected"':'').'>600</option>
						<option value="700"'.(@$stored['google']['weight_normal']==700?' selected="selected"':'').'>700</option>
						<option value="800"'.(@$stored['google']['weight_normal']==800?' selected="selected"':'').'>800</option>
						<option value="900"'.(@$stored['google']['weight_normal']==900?' selected="selected"':'').'>900</option>
					</select>';
				if(!isset($stored['google']['weight_bold']))
					$stored['google']['weight_bold']=700;
				$output .= '<br/>'.__('Font weight for bold text:','om_theme').' <select name="'. $value['id'] .'[google][weight_bold]" id="'. $value['id'] .'_google_weight_bold" style="width:150px">
						<option value="100"'.(@$stored['google']['weight_bold']==100?' selected="selected"':'').'>100</option>
						<option value="200"'.(@$stored['google']['weight_bold']==200?' selected="selected"':'').'>200</option>
						<option value="300"'.(@$stored['google']['weight_bold']==300?' selected="selected"':'').'>300</option>
						<option value="400"'.(@$stored['google']['weight_bold']==400?' selected="selected"':'').'>400</option>
						<option value="500"'.(@$stored['google']['weight_bold']==500?' selected="selected"':'').'>500</option>
						<option value="600"'.(@$stored['google']['weight_bold']==600?' selected="selected"':'').'>600</option>
						<option value="700"'.(@$stored['google']['weight_bold']==700?' selected="selected"':'').'>700 ('.__('standard','om_theme').')</option>
						<option value="800"'.(@$stored['google']['weight_bold']==800?' selected="selected"':'').'>800</option>
						<option value="900"'.(@$stored['google']['weight_bold']==900?' selected="selected"':'').'>900</option>
					</select>';

				$output .= '<div class="om-options-note">'.__('Please, make sure that chosen font supports chosen weight', 'om_theme').'</div>';
				$output .= '<div style="padding-bottom:5px"><i>'.__('Latin charset by default. Include additional character sets for fonts (make sure at <a href="http://www.google.com/fonts/" target="_blank">http://www.google.com/fonts/</a> before that charset is available for chosen font):', 'om_theme').'</i></div>';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][latin_ext]" value="true" '.(@$stored['google']['latin_ext']?' checked="checked"':'').' /> '.__('Latin Extended', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][arabic]" value="true" '.(@$stored['google']['arabic']?' checked="checked"':'').' /> '.__('Arabic', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][cyrillic]" value="true" '.(@$stored['google']['cyrillic']?' checked="checked"':'').' /> '.__('Cyrillic', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][cyrillic_ext]" value="true" '.(@$stored['google']['cyrillic_ext']?' checked="checked"':'').' /> '.__('Cyrillic Extended', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][devanagari]" value="true" '.(@$stored['google']['devanagari']?' checked="checked"':'').' /> '.__('Devanagari', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][greek]" value="true" '.(@$stored['google']['greek']?' checked="checked"':'').' /> '.__('Greek', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][greek_ext]" value="true" '.(@$stored['google']['greek_ext']?' checked="checked"':'').' /> '.__('Greek Extended', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][hebrew]" value="true" '.(@$stored['google']['hebrew']?' checked="checked"':'').' /> '.__('Hebrew', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][khmer]" value="true" '.(@$stored['google']['khmer']?' checked="checked"':'').' /> '.__('Khmer', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][telugu]" value="true" '.(@$stored['google']['telugu']?' checked="checked"':'').' /> '.__('Telugu', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][vietnamese]" value="true" '.(@$stored['google']['vietnamese']?' checked="checked"':'').' /> '.__('Vietnamese', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '</div>';
				
				$output .= '<div id="'. $value['id'] .'_container_external" class="om-font-'.$value['id'].'-type-box"'.((@$stored['type']=='external')?'':' style="display:none"').'>';
				$output .= __('Embed code for the &lt;head&gt; section:','om_theme').'<br/><textarea name="'. $value['id'] .'[external][embed]" id="'. $value['id'] .'_external_embed" rows="3" style="width:300px">'. esc_textarea(@$stored['external']['embed']) .'</textarea><br/>';
				$output .= __('Font family:','om_theme').'<br/><input name="'. $value['id'] .'[external][family]" id="'. $value['id'] .'_external_family" type="text" value="'. esc_attr(@$stored['external']['family']) .'" style="width:300px" />';
				$output .= '<div class="om-options-note">'.__('Enter the value for "font-family" attribute, also you can specify the stack of the fonts', 'om_theme').'</div>';
				$output .= '</div>';

			break;
			
			case 'font_full':

				$stored = get_option($value['id']);
				if(!is_array($stored))
					$stored=$value['std'];
	
				$output .= __('Source:','om_theme').' <select name="'. $value['id'] .'[type]" id="'. $value['id'] .'" style="width:auto" onchange="jQuery(\'.om-font-'.$value['id'].'-type-box\').hide();jQuery(\'#'. $value['id'] .'_container_\'+this.value).show()">';
			
				$output .= '<option value="standard"'.(@$stored['type']=='standard'?' selected="selected"':'').'>'.__('Standard fonts','om_theme').'</option>';
				$output .= '<option value="google"'.(@$stored['type']=='google'?' selected="selected"':'').'>'.__('Google.Fonts','om_theme').'</option>';
				$output .= '<option value="external"'.(@$stored['type']=='external'?' selected="selected"':'').'>'.__('Any external fonts (e.g. Typekit)','om_theme').'</option>';
				$output .=  '</select>';
				
				$output .= '<div id="'. $value['id'] .'_container_standard" class="om-font-'.$value['id'].'-type-box"'.((@$stored['type']=='standard' || @$stored['type'] == '')?'':' style="display:none"').'>';
				$output .= __('Font family:','om_theme').' <select name="'. $value['id'] .'[standard][family]" id="'. $value['id'] .'_standard_family" style="width:auto">';
				foreach ($value['options'] as $option => $name) {
					$output .= '<option value="'.$option.'"'.(@$stored['standard']['family']==$option?' selected="selected"':'').'>'.$name.'</option>';
				} 
				$output .= '</select>';
				$output .= '</div>';
				
				$output .= '<div id="'. $value['id'] .'_container_google" class="om-font-'.$value['id'].'-type-box"'.((@$stored['type']=='google')?'':' style="display:none"').'>';
				$output .= __('Font name:','om_theme').' <input name="'. $value['id'] .'[google][family]" id="'. $value['id'] .'_google_family" type="text" value="'. esc_attr(@$stored['google']['family']) .'" style="width:250px" />';
				$output .= '<div class="om-options-note" style="margin-top:-5px">'.__('Choose the the font from <a href="http://www.google.com/fonts/" target="_blank">http://www.google.com/fonts/</a> and enter the name.', 'om_theme').'</div>';
				$output .= '<div style="padding-bottom:5px"><i>'.__('Latin charset by default. Include additional character sets for fonts (make sure at <a href="http://www.google.com/fonts/" target="_blank">http://www.google.com/fonts/</a> before that charset is available for chosen font):', 'om_theme').'</i></div>';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][latin_ext]" value="true" '.(@$stored['google']['latin_ext']?' checked="checked"':'').' /> '.__('Latin Extended', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][arabic]" value="true" '.(@$stored['google']['arabic']?' checked="checked"':'').' /> '.__('Arabic', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][cyrillic]" value="true" '.(@$stored['google']['cyrillic']?' checked="checked"':'').' /> '.__('Cyrillic', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][cyrillic_ext]" value="true" '.(@$stored['google']['cyrillic_ext']?' checked="checked"':'').' /> '.__('Cyrillic Extended', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][devanagari]" value="true" '.(@$stored['google']['devanagari']?' checked="checked"':'').' /> '.__('Devanagari', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][greek]" value="true" '.(@$stored['google']['greek']?' checked="checked"':'').' /> '.__('Greek', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][greek_ext]" value="true" '.(@$stored['google']['greek_ext']?' checked="checked"':'').' /> '.__('Greek Extended', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][hebrew]" value="true" '.(@$stored['google']['hebrew']?' checked="checked"':'').' /> '.__('Hebrew', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][khmer]" value="true" '.(@$stored['google']['khmer']?' checked="checked"':'').' /> '.__('Khmer', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][telugu]" value="true" '.(@$stored['google']['telugu']?' checked="checked"':'').' /> '.__('Telugu', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '<label style="white-space:nowrap"><input type="checkbox" name="'.  $value['id'] .'[google][vietnamese]" value="true" '.(@$stored['google']['vietnamese']?' checked="checked"':'').' /> '.__('Vietnamese', 'om_theme').'</label> &nbsp;&nbsp; ';
				$output .= '</div>';
				
				$output .= '<div id="'. $value['id'] .'_container_external" class="om-font-'.$value['id'].'-type-box"'.((@$stored['type']=='external')?'':' style="display:none"').'>';
				$output .= __('Embed code for the &lt;head&gt; section:','om_theme').' <textarea name="'. $value['id'] .'[external][embed]" id="'. $value['id'] .'_external_embed" rows="3" cols="8">'. esc_textarea(@$stored['external']['embed']) .'</textarea><br/>';
				$output .= __('Font family:','om_theme').' <input name="'. $value['id'] .'[external][family]" id="'. $value['id'] .'_external_family" type="text" value="'. esc_attr(@$stored['external']['family']) .'" style="width:220px" />';
				$output .= '<div class="om-options-note" style="margin-top:-5px">'.__('Enter the value for "font-family" attribute, also you can specify the stack of the fonts', 'om_theme').'</div>';
				$output .= '</div>';
				
				$output .= __('Font size:','om_theme').' <select name="'. $value['id'] .'[size]" id="'. $value['id'].'_size" style="width:auto">';
				for ($i = 8; $i < 71; $i++){ 
					$output .= '<option value="'. $i .'" ' . (@$stored['size']==$i?' selected="selected"':'') . '>'. $i .'px</option>';
				}
				$output .= '</select><br/>';

				$output .= __('Line height:','om_theme').' <select name="'. $value['id'] .'[lineheight]" id="'. $value['id'].'_lineheight" style="width:auto">';
				for ($i = 1; $i <= 2; $i+=0.01){
					$output .= '<option value="'. $i .'" ' . (abs(@$stored['lineheight']-$i) < 0.00001?' selected="selected"':'') . '>'. number_format($i,2) .'em</option>';
				}
				$output .= '</select>';


			break;
			
			case "images":
				$i = 0;
				$select_value = get_option( $value['id']);
					   
				foreach ($value['options'] as $key => $option) { 
					$i++;
	
					$checked = '';
					$selected = '';
				  if($select_value != '') {
						if ( $select_value == $key) { $checked = ' checked'; $selected = 'om-radio-img-selected'; } 
				  } else {
						if ($value['std'] == $key) { $checked = ' checked'; $selected = 'om-radio-img-selected'; }
						elseif ($i == 1  && !isset($select_value)) { $checked = ' checked'; $selected = 'om-radio-img-selected'; }
						elseif ($i == 1  && $value['std'] == '') { $checked = ' checked'; $selected = 'om-radio-img-selected'; }
						else { $checked = ''; }
					}	
					
					$output .= '<span>';
					$output .= '<input type="radio" id="om-radio-img-' . $value['id'] . $i . '" class="checkbox om-radio-img-radio" value="'.$key.'" name="'. $value['id'].'" '.$checked.' />';
					$output .= '<div class="om-radio-img-label">'. $key .'</div>';
					$output .= '<img src="'.esc_url($option).'" alt="" class="om-radio-img-img '. $selected .'" onClick="document.getElementById(\'om-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
					$output .= '</span>';
					
				}
			break; 
			
			case "info":
				$default = $value['std'];
				$output .= $default;
			break;                                   
			
			case "form_fields": 
			
				$std = $value['std'];  
				$saved_std = get_option($value['id']);
				if(!is_array($saved_std))
					$saved_std=array();

				for($i=0;$i<10;$i++) {
					$output .= __('<b>Field','om_theme').' '.($i+1).'</b><br/>';
					$output .= __('Name:','om_theme').' <input type="text" name="'.  $value['id'] .'['.$i.'][name]" value="'.esc_attr(@$saved_std[$i]['name']).'" /><br/>';
					$output .= __('Type:','om_theme').' <select style="width:120px" name="'.  $value['id'] .'['.$i.'][type]"><option value="text">String</option><option value="email">Email</option><option value="textarea"'.(@$saved_std[$i]['type']=='textarea'?' selected="selected"':'').'>Textarea</option><option value="checkbox"'.(@$saved_std[$i]['type']=='checkbox'?' selected="selected"':'').'>Checkbox</option></select> &nbsp;&nbsp;&nbsp;';
					$output .= __('Required:','om_theme').' <input type="checkbox" name="'.  $value['id'] .'['.$i.'][required]" '.(@$saved_std[$i]['required']?' checked="checked"':'').' />';
					$output .= '<br/><div style="border-bottom:1px dotted #aaa"></div><br/>';
				}
			break;
			
			case "styling_presets": 
			
				$saved_std = get_option($value['id']);
				if(!is_array($saved_std))
					$saved_std=array();

				if(empty($saved_std))
					$output .= '<i>'.__('No presets created yet.','om_theme').'</i><br />';
				else {
					$output .= '<table border="0" cellpadding="10" cellspacing="0">';
					foreach($saved_std as $k=>$v) {
						$output .= '<tr>
							<td style="border-bottom:1px dotted #aaa"><b>'.esc_html($k).'</b></td>
							<td style="border-bottom:1px dotted #aaa"><span class="button om-style-apply-button" id="'.$value['id'].'_apply" data-optionid="'.$value['id'].'" data-optionname="'.esc_attr($k).'">'.__('Apply','om_theme').'</span></td>
							<td style="border-bottom:1px dotted #aaa"><span class="button om-style-remove-button" id="'.$value['id'].'_apply" data-optionid="'.$value['id'].'" data-optionname="'.esc_attr($k).'">'.__('Remove','om_theme').'</span></td>
						</tr>';
					}
					$output .= '</table><br />';
				}
				$output .= '<br /><b>'.__('Save current styling options as new preset:','om_theme').'</b><br/>Name: <input type="text" name="'.$value['id'].'_new" style="width:60%" /> <span class="button " id="om-styling-button-save">'.__('Save','om_theme').'</span> <br />';
			break;
						
			case "heading":
				
				if($counter >= 2){
				   $output .= '</div>'."\n";
				}
				$jquery_click_hook = preg_replace("/[^A-Za-z0-9]/", "", strtolower($value['name']) );
				$jquery_click_hook = "om-option-section-" . $jquery_click_hook;
				$menu .= '<li><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a></li>';
				$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
			break;
			
		} 
		
		if ( $value['type'] != "heading" ) { 
			if ( $value['type'] != "checkbox" ) 
				$output .= '<br/>';
			if(!isset($value['desc']))
				$explain_value = '';
			else
				$explain_value = $value['desc']; 
				
			$output .= '</div><div class="om-options-explain">'. $explain_value .'</div>';
			$output .= '<div class="clear"> </div></div></div>';
		}
		
		if(isset($value['code']))
			$output.=$value['code'];
	   
	}

	$output .= '</div>';
	return array('options'=>$output,'menu'=>$menu);

}
