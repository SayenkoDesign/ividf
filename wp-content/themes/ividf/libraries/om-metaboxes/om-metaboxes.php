<?php
/**
 * Olevmedia Metaboxes
 * Version 1.5
 */

if(!defined('OM_METABOXES')) {
	
	define('OM_METABOXES', true);
	$GLOBALS['omMetaboxes'] = array(
		'version' => '1.5',
		'path' => plugin_dir_path( __FILE__ ),
		'path_url' => TEMPLATE_DIR_URI . '/libraries/om-metaboxes/',
		'text_domain' => 'om_theme',
	);
	
	include_once( 'functions/core.php' );
	include_once( 'functions/misc.php' );
	
}