<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php if(get_option(OM_THEME_PREFIX . 'responsive') == 'true') : ?><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" /><?php endif; ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class( array( OM_THEME_SHORT_PREFIX .'theme', OM_THEME_PREFIX. 'theme' ) ) ?>>
<!--[if lt IE 8]><p class="chromeframe"><?php _e('You are using an <strong>outdated</strong> browser. Please, <a href="http://browsehappy.com/">upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.','om_theme'); ?></p><![endif]-->
	<div class="bg-overlay">
		<div class="container-wrapper">
			
