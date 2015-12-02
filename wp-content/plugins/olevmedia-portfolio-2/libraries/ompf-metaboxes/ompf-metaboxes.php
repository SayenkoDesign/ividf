<?php
/**
 * Olevmedia Metaboxes
 * Version 1.3
 */

if(!defined('OMPF_METABOXES')) {
	
	define('OMPF_METABOXES', true);
	$GLOBALS['ompfMetaboxes'] = array(
		'version' => '1.3',
		'path' => plugin_dir_path( __FILE__ ),
		'path_url' => $GLOBALS['omPortfolioPlugin']['path_url'] . 'libraries/ompf-metaboxes/',
		'text_domain' => 'om_portfolio',
	);
	
	include_once( 'functions/core.php' );
	include_once( 'functions/misc.php' );
	
}