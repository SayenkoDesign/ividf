<?php
	$post_type=get_post_type();
	if($post_type != 'post' && $post_type != 'portfolio')
		$post_type='page';

	$fb_comments=false;
	if(function_exists('om_facebook_comments') && get_option(OM_THEME_PREFIX . 'fb_comments_'.$post_type) == 'true') {
		if(get_option(OM_THEME_PREFIX . 'fb_comments_position') == 'after')
			$fb_comments='after';
		else
			$fb_comments='before';
	}
	
	$native_comments=(get_option(OM_THEME_PREFIX . 'hide_comments_'.$post_type) != 'true');

	if($native_comments && !comments_open() && !have_comments() )
		$native_comments=false;

	if($fb_comments || $native_comments) { ?>

	<div class="comments-section">
		
		<h3 class="comments-title"><?php _e('Comments', 'om_theme') ?></h3>

		<?php if($fb_comments == 'before') { om_facebook_comments();	} ?>
		
		<?php if($native_comments) : ?>

			<!-- Native Comments -->
				<?php
				if ( post_password_required() ) {
					?><p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'om_theme') ?></p><?php
				} else {
				
					?><div class="discussion" id="comments"><div class="discussion-comments"><?php
			
					/*************************************************************************************
					 *	New Comment Form
					 *************************************************************************************/
					
					if ( comments_open() ) {
				
						comment_form(array(
							'comment_field' => '<div><textarea name="comment" id="comment" rows="4" tabindex="4" placeholder="' . esc_attr(__('Leave your message here', 'om_theme') . __("*", 'om_theme')) . '" class="required"></textarea></div><div class="clear" style="height:1px"></div>',
							'comment_notes_after' => '',
						));
						
					}
										
					/*************************************************************************************
					 *	Display comments
					 *************************************************************************************/	
					if ( have_comments() ) {
						
						if ( ! empty($comments_by_type['comment']) ) { // if there are normal comments 
							wp_list_comments(array(
								'type' => 'comment',
								'style' => 'div',
								'callback' => 'om_comment'
							));
						}
					  
					  if ( ! empty($comments_by_type['pings']) ) { // if there are pings 
					
							?><h3 id="pings"><?php _e('Trackbacks for this post', 'om_theme') ?></h3><?php
					
					  	wp_list_comments(array(
					  		'type' => 'pings',
					  		'style' => 'div',
					  		'callback' => 'om_pings_list'
					  	));
						}
					
						$nav_prev=get_previous_comments_link(__('Older Comments','om_theme'));
						$nav_next=get_next_comments_link(__('Newer Comments','om_theme'));
						if( $nav_prev || $nav_next ) {
							echo om_prev_next_nav($nav_prev, $nav_next);
						}
					
						/*************************************************************************************
						 *	No comments or closed
						 *************************************************************************************/
					
						if ('closed' == $post->comment_status ) { // if the post has comments but comments are now closed 
							?><p class="nocomments"><?php _e('Comments are closed.', 'om_theme') ?></p><?php
						}
					}
					?>
					</div>
					<?php // <div class="discussion-comments">
					
					?></div><?php // <div class="discussion" id="comments">
				}
				?>
			<!-- / Native Comments -->

		<?php endif; ?>		
		
		<?php if($fb_comments == 'after') { om_facebook_comments();	} ?>
	
	</div><?php
	
	}