<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<?php if(get_option(OM_THEME_PREFIX . 'responsive') == 'true') : ?><meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" /><?php endif; ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel='stylesheet' property='stylesheet' id='font-awesome-css'  href='<?php echo get_template_directory_uri(); ?>/libraries/fontawesome/css/font-awesome.min.css?ver=4.3.0' type='text/css' media='all' />
    <link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/custom_jscomposer.css' type='text/css' media='all' />
    
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
	<![endif]-->
    
	<?php wp_head(); ?>
   
    
</head>
<body <?php body_class( array( OM_THEME_SHORT_PREFIX .'theme', OM_THEME_PREFIX. 'theme' ) ) ?>>
<!--[if lt IE 8]><p class="chromeframe"><?php _e('You are using an <strong>outdated</strong> browser. Please, <a href="http://browsehappy.com/">upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.','om_theme'); ?></p><![endif]-->
	<div class="bg-overlay">
		<div class="container-wrapper">
			<div class="hc-wrapper">
				<?php global $page_slider; if(isset($page_slider) && $page_slider && $page_slider['layout'] == 'before_header') om_tpl_header_slider($page_slider) ?>                
				<?php $header_layout=get_option(OM_THEME_PREFIX . 'header_layout'); if(!$header_layout) $header_layout=1; ?>
				<div class="header-wrapper">
					<header class="header header-layout-<?php echo esc_attr($header_layout) ?>">
						<?php
							$wpml_selector = ( get_option( OM_THEME_PREFIX . 'show_wpml_language_selector' ) == 'true' && defined('ICL_SITEPRESS_VERSION') );
							$header_social_icons = (get_option(OM_THEME_PREFIX . 'social_icons_header') == 'true') ? om_get_social_icons_html() : false;
							$header_tagline = get_option(OM_THEME_PREFIX . 'header_tagline');
						?>
						<?php if($header_tagline || $header_social_icons || $wpml_selector) { ?>
							<div class="header-top">
								<div class="container">
									<div class="container-inner">
										<?php if( $wpml_selector ) { ?><div class="header-wpml-selector"><?php do_action('icl_language_selector'); ?><div class="clear"></div></div><?php } ?>
										<div class="header-tagline">
											<?php echo wp_kses_post( $header_tagline ); ?>
										</div>
										<?php if($header_social_icons) { ?>
											<div class="header-socials<?php echo esc_attr( ( $color = get_option( OM_THEME_PREFIX . 'social_icons_color_header') ) ? ' '.$color.'-social-icons':'' ) ?>">
												<?php echo wp_kses_post( $header_social_icons ); ?>
											</div>
										<?php } ?>
										<div class="clear"></div>
									</div>
								</div>
							</div>
						<?php } ?>
		
						<?php
							$logo_arr=om_get_logo();
							$logo='';
						?>
						<div class="header-mid logo-type-<?php echo esc_attr($logo_arr['logo_type']) ?>">
						<?php
							// logo
							if($logo_arr['logo_type'] == 'image') {
								$logo =
									'<div class="logo-box"'. (isset($logo_arr['imagesize'][0]) ? ' style="width:'.intval($logo_arr['imagesize'][0]).'px"' : '' ).'>'.
										'<div class="logo-image"><a href="' . esc_attr($logo_arr['href']) .'">'.$logo_arr['image_block'].'</a></div>'.
									'</div>'
								;
							} elseif($logo_arr['logo_type'] == 'text') {
								$logo =
									'<div class="logo-box">'.
										'<div class="logo-text"><a href="' . esc_attr($logo_arr['href']) .'">'. esc_html($logo_arr['text_block']) .'</a></div>'.
									'</div>'
								;
							}?>							                            				
							<?php			
							//menu
							$menu = wp_nav_menu( array(
								'theme_location' => 'primary-menu',
								'container' => false,
								'fallback_cb' => 'om_primary_menu_fallback',
								'menu_class' => 'primary-menu sf-menu clearfix'
									.(get_option(OM_THEME_PREFIX . 'show_dropdown_symbol')=='true'?' show-dropdown-symbol':'')
									.(get_option(OM_THEME_PREFIX . 'menu_bold')=='true'?' menu-bold':'')
									.(get_option(OM_THEME_PREFIX . 'menu_uppercase')=='true'?' apply-uppercase':''),
								'echo' => false,
							) );
							
							if(get_option(OM_THEME_PREFIX . 'show_header_search') == 'true') {
								$search='
									<div class="header-search">
										<a href="'. home_url() .'/?s=" class="search-popup-link"></a>
										<div class="search-popup">
											'.get_search_form(false).'
										</div>
									</div>
								';
							} else {
								$search='';
							}
							if($menu) {
								if(($header_layout == 1 || $header_layout == 3) && isset($logo_arr['line_height']))
									$menu = '<div class="menu-box" style="line-height:'.intval($logo_arr['line_height']).'px"><nav>' . $menu . $search .'</nav></div>';
								else
									$menu = '<div class="menu-box"><nav>' . $menu . $search . '</nav></div>';
							}
							
							if($header_layout == 1 || $header_layout == 3) {
								?>
									<div class="header-logo-menu-wrapper menu-sticky-node">
										<div class="container-wrapper">
											<div class="header-logo-menu">
												<div class="container">
													<div class="container-inner">
														<div class="logo-menu-wrapper">
															<?php echo om_esc_wpcf($logo); ?>
                                                            <div class="toggle">
                                                            	<span></span>	
                                                            </div>
                                                            <span class="mobile_letstalk">
                                                                <a href="<?php get_site_url(); ?>/contact-us/"> Let’s Talk </a>
                                                            </span>
                                                            
                                                            <div class="header-mobile-menu">
                                                            <div class="container">
                                                                <div class="container-inner">
                                                                    <div class="mobile-header-menu-wrapper">
                                                                        <div class="mobile-header-menu-control"> <?php _e('Menu', 'om_theme') ?></div>
                                                                        <div class="mobile-header-menu-container">
                                                                            <?php
                                                                                    wp_nav_menu( array(
                                                                                        'theme_location' => 'primary-menu',
                                                                                        'container' => false,
                                                                                        'fallback_cb' => 'om_primary_menu_fallback',
                                                                                        'menu_class' => 'header-menu-mobile sf-menu clearfix'.(get_option(OM_THEME_PREFIX . 'show_dropdown_symbol')=='true'?' show-dropdown-symbol':''),
                                                                                    ) );
                                                                                    if(get_option(OM_THEME_PREFIX . 'show_header_search') == 'true') {
                                                                                        get_search_form();
                                                                                    }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <?php echo om_esc_wpcf($menu); ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
							} else {
								if($logo) {
								?>
									<div class="header-logo">
										<div class="container">
											<div class="container-inner">
												<div class="logo-wrapper">
													<?php echo om_esc_wpcf($logo) ?>
												</div>
											</div>
										</div>
									</div>
								<?php
								}
								if($menu) {
								?>
									<div class="header-menu-wrapper menu-sticky-node">
										<div class="container-wrapper">
											<div class="header-menu">
												<div class="container">
													<div class="container-inner">
														<div class="menu-wrapper">
															<?php echo om_esc_wpcf($menu) ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php
								}
							}
						?>
						</div>
						
						<?php /*?><div class="header-mobile-menu">
							<div class="container">
								<div class="container-inner">
									<div class="mobile-header-menu-wrapper">
										<div class="mobile-header-menu-control"> <?php _e('Menu', 'om_theme') ?></div>
										<div class="mobile-header-menu-container">
											<?php
													wp_nav_menu( array(
														'theme_location' => 'primary-menu',
														'container' => false,
														'fallback_cb' => 'om_primary_menu_fallback',
														'menu_class' => 'header-menu-mobile sf-menu clearfix'.(get_option(OM_THEME_PREFIX . 'show_dropdown_symbol')=='true'?' show-dropdown-symbol':''),
													) );
													if(get_option(OM_THEME_PREFIX . 'show_header_search') == 'true') {
														get_search_form();
													}
											?>
										</div>
									</div>
								</div>
							</div>
						</div><?php */?>
					</header>
				</div>
				
