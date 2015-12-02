<?php

if(class_exists( 'bbPress' )) {
	
	add_filter( 'bbp_no_breadcrumb', '__return_true' );

	/*************************************************************************************
	 *	Product page meta
	 *************************************************************************************/
	 
	require_once (TEMPLATE_DIR . '/functions/bbpress-meta.php');
	
}