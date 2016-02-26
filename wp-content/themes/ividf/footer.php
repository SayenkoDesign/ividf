			</div>
			<?php
				$subfooter = get_option( OM_THEME_PREFIX.'subfooter_text' );
				$footer_columns_layout = get_option( OM_THEME_PREFIX.'footer_layout' );
				$footer_menu = has_nav_menu( 'footer-menu' );
				$footer_social_icons = ( get_option( OM_THEME_PREFIX . 'social_icons_footer' ) == 'true' ) ? om_get_social_icons_html() : false;
				
				if( $footer_columns_layout == '1v4-1v4-1v4-1v4')
					$footer_columns=array(
						'footer-column-1'=>'one-fourth',
						'footer-column-2'=>'one-fourth',
						'footer-column-3'=>'one-fourth',
						'footer-column-4'=>'one-fourth last',
					);
				elseif( $footer_columns_layout == '2v4-1v4-1v4')
					$footer_columns=array(
						'footer-column-1'=>'one-half',
						'footer-column-2'=>'one-fourth',
						'footer-column-3'=>'one-fourth last',
					);
				elseif( $footer_columns_layout == '1v4-1v4-2v4')
					$footer_columns=array(
						'footer-column-1'=>'one-fourth',
						'footer-column-2'=>'one-fourth',
						'footer-column-3'=>'one-half last',
					);
				elseif( $footer_columns_layout == '1v3-1v3-1v3')
					$footer_columns=array(
						'footer-column-1'=>'one-third',
						'footer-column-2'=>'one-third',
						'footer-column-3'=>'one-third last',
					);
				elseif( $footer_columns_layout == '2v3-1v3')
					$footer_columns=array(
						'footer-column-1'=>'two-third',
						'footer-column-2'=>'one-third last',
					);
				elseif( $footer_columns_layout == '1v3-2v3')
					$footer_columns=array(
						'footer-column-1'=>'one-third',
						'footer-column-2'=>'two-third last',
					);
				elseif( $footer_columns_layout == '1v2-1v2')
					$footer_columns=array(
						'footer-column-1'=>'one-half',
						'footer-column-2'=>'one-half last',
					);
				else
					$footer_columns=array(
						'footer-column-1'=>'',
					);
				$is_footer_sidebars=false;
				foreach($footer_columns as $id=>$class) {
					if ( is_active_sidebar($id) ) {
						$is_footer_sidebars=true;
						break;
					}
				}
				
				if($is_footer_sidebars || $subfooter || $footer_menu || $footer_social_icons) { ?>
				
					<footer>
						<div class="footer">
							<?php if($is_footer_sidebars) { ?>
								<div class="footer-widgets">
									<div class="container">
										<div class="container-inner">
											<?php
												foreach($footer_columns as $id=>$class) {
													echo '<div class="footer-widgets-column '.esc_attr($class).'">';
													dynamic_sidebar( $id );
													echo '</div>';
												}
											?>
											<div class="clear"></div>	
										</div>
									</div>		
								</div>
							<?php } ?>
							
							<?php if($is_footer_sidebars && ($subfooter || $footer_menu || $footer_social_icons)) { ?>
								<div class="footer-hor-divider"></div>
							<?php } ?>
							
							<?php if($subfooter || $footer_menu || $footer_social_icons) { ?>
								<div class="sub-footer<?php echo (($subfooter!='')?' with-sub-footer-text':' no-sub-footer-text'); ?>">
									<div class="container">
										<div class="container-inner">
											<div class="sub-footer-menu-social-text clearfix">
												<?php if($footer_menu || $footer_social_icons) { ?>
													<div class="sub-footer-menu-social">
														<?php
															if($footer_menu) {
																wp_nav_menu( array(
																	'theme_location' => 'footer-menu',
																	'container' => false,
																	'menu_class' => 'footer-menu clearfix',
																) );
															}
															if($footer_social_icons) {
																echo '<div class="footer-social-icons'. esc_attr( ( $color = get_option( OM_THEME_PREFIX . 'social_icons_color_footer') ) ? ' '.$color.'-social-icons':'' ) .'">';
																echo wp_kses_post( $footer_social_icons );
																echo '</div>';
															}
														?>
													</div>
												<?php } ?>
												<?php if($subfooter) { echo '<div class="sub-footer-text">'.wp_kses_post($subfooter).'</div>'; } ?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						
							
						</div>
					</footer>
					
				<?php } ?>
		</div>
	</div>
<?php echo get_option( OM_THEME_PREFIX . 'code_before_body' ) ?>

<!-- Modal -->
<div class="modal fade" id="video1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
        <!--<iframe width="100%" height="420" src="https://www.youtube.com/embed/l4tPrcePdGM" frameborder="0" allowfullscreen></iframe>-->
        <iframe width="900" id="ytplayer1" height="506" src="https://www.youtube.com/embed/lsAL7rITEnQ?autoplay=0" frameborder="0" autostart="true" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="video2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
        <!--<iframe width="100%" height="420" src="https://www.youtube.com/embed/l4tPrcePdGM" frameborder="0" allowfullscreen></iframe>-->
        <iframe width="900" id="ytplayer2" height="506" src="https://www.youtube.com/embed/ubT-G-wMbp4?autoplay=0" frameborder="0" autostart="true" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Services Modal -->
<div class="modal fade" id="video4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
     
        <iframe width="900" id="ytplayer4" height="506" src="https://www.youtube.com/embed/LJW1BU6Ouys?autoplay=0" frameborder="0" autostart="true" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>

<!-- this is idf -->
<div class="modal fade" id="video3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
        <!--<iframe width="100%" height="420" src="https://www.youtube.com/embed/l4tPrcePdGM" frameborder="0" allowfullscreen></iframe>-->
        <iframe width="900" id="ytplayer3" height="506" src="https://www.youtube.com/embed/BS8nKrIxGHQ?autoplay=0" frameborder="0" autostart="true" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery(".toggle").click(function(){        
		jQuery(".mobile-header-menu-container").toggle();		
    });
	
	
                jQuery('#popv4').click(function() 
		{ 
		var src_ = jQuery("iframe#ytplayer4").attr('src').replace("autoplay=0", "autoplay=1");
		jQuery("iframe#ytplayer4").attr('src', src_);		
		});

		jQuery('#popv3').click(function() 
		{ 
		var src_ = jQuery("iframe#ytplayer3").attr('src').replace("autoplay=0", "autoplay=1");
		jQuery("iframe#ytplayer3").attr('src', src_);		
		});
		
		jQuery('#popv1').click(function() 
		{
		var src_1 = jQuery("iframe#ytplayer1").attr('src').replace("autoplay=0", "autoplay=1");
		jQuery("iframe#ytplayer1").attr('src', src_1);		
		});
		
		
		jQuery('#popv2').click(function() 
		{
		var src_2 = jQuery("iframe#ytplayer2").attr('src').replace("autoplay=0", "autoplay=1");
		jQuery("iframe#ytplayer2").attr('src', src_2);		
		});
	
	
	
	jQuery('.close').click(function() {
		var vurl = jQuery('#video1').find('iframe').attr('src');
		jQuery('#video1').find('iframe').attr('src', vurl);
		
		var vurl = jQuery('#video2').find('iframe').attr('src');
		jQuery('#video2').find('iframe').attr('src', vurl);
		
		var vurl = jQuery('#video3').find('iframe').attr('src');
		jQuery('#video3').find('iframe').attr('src', vurl);
		
		
		var change_src_1 = jQuery("iframe#ytplayer1").attr('src').replace("autoplay=1", "autoplay=0");
		jQuery("iframe#ytplayer1").attr('src', change_src_1);
		
		var change_src_2 = jQuery("iframe#ytplayer2").attr('src').replace("autoplay=1", "autoplay=0");
		jQuery("iframe#ytplayer2").attr('src', change_src_2);
		
		var change_src_3 = jQuery("iframe#ytplayer3").attr('src').replace("autoplay=1", "autoplay=0");
		jQuery("iframe#ytplayer3").attr('src', change_src_3);
		
		
		
		
	});
	
});
</script>

<script>
jQuery(document).ready(function() {

	if(window.location.hash != ''){
		var offsetSize = jQuery(".header").innerHeight();
		var offsetSize_ = jQuery(window.location.hash).offset().top-offsetSize;
		jQuery("html, body").animate({scrollTop:offsetSize_}, 500);
	}

});
</script>

<?php wp_footer(); ?>



</body>
</html>