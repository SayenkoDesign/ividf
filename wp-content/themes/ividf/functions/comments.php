<?php

/**
 * Comment form
 */
 
function om_comment_form_before() {
	echo '<div class="new-comment"><div class="new-comment-pane">';
}
add_action('comment_form_before','om_comment_form_before');

function om_comment_form_after() {
	echo '</div></div>';
}
add_action('comment_form_after','om_comment_form_after');

function om_comment_form_logged_in($str) {
	return $str;
}
add_filter('comment_form_logged_in','om_comment_form_logged_in');

function om_comment_form_default_fields($fields) {

	$req = get_option( 'require_name_email' );
	$commenter = wp_get_current_commenter();
	
	$fields =  array(
		'author' => '
			<div class="one-third">
				<input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" tabindex="1" placeholder="'. esc_attr(__('Name', 'om_theme')) . ($req ? esc_attr(__("*", 'om_theme')) : '' ).'"'. ($req ? ' class="required"':'').' />
			</div>
		',
		
		'email'  => '
			<div class="one-third">
				<input type="text" name="email" id="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" tabindex="2" placeholder="'. esc_attr(__('Email', 'om_theme')) . ($req ? esc_attr(__("*", 'om_theme')) : '' ).'"'. ($req ? ' class="required email"':'').' />
			</div>
		',
		
		'url'    => '
			<div class="one-third last">
				<input type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="22" tabindex="3" placeholder="' . esc_attr(__('Website', 'om_theme')) . '" />
			</div>
		',
	);
		
	return $fields;
}
add_filter('comment_form_default_fields','om_comment_form_default_fields');

function om_comment_form_after_fields() {
	echo '<div class="clear"></div>';
}
add_action('comment_form_after_fields','om_comment_form_after_fields');

/**
 * Comments
 */

if( !function_exists( 'om_comment' ) ) {
	
	function om_comment($comment, $args, $depth) {
		
		$GLOBALS['comment'] = $comment; ?>
		<div class="comment" id="comment-<?php comment_ID() ?>">
			<div class="comment-inner depth-<?php echo esc_attr($depth); ?>" id="comment-inner-<?php comment_ID(); ?>">
				<div class="comment-meta">
					<div class="author"><?php printf(__('<cite class="fn">%s</cite>','om_theme'), get_comment_author_link()) ?></div>
					<div class="date"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s','om_theme'), get_comment_date(),  get_comment_time()) ?></a></div>
					<?php
						$reply=get_comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
						$reply=preg_replace('#<a([^>]*)>([\s\S]*)</a>#','<a$1><span>$2</span></a>',$reply);
						if($reply) {
							echo '<div class="reply">'.$reply.'</div>';
						}
					?>
					<?php edit_comment_link(__('(Edit)','om_theme'),'<div class="edit">','</div>') ?>
					<div class="clear"></div>
				</div>
				<div class="comment-text">
					<?php
						if(preg_match('/src=["\']([^"\']+)["\']/', get_avatar( $comment->comment_author_email, 76 ), $m))
							$src2x=$m[1];
						else
							$src2x=false;
						$avatar=get_avatar( $comment->comment_author_email, 38 );
						if($src2x)
							$avatar=str_replace('src=','data-src-retina="'.$src2x.'" src=',$avatar);
						if($avatar) {
							?>
								<div class="pic">
									<div class="pic-inner">
										<?php echo wp_kses_post ( $avatar ); ?>
									</div>
									<div class="clear"></div>
								</div>
							<?php
						}
					?>
					<div class="text<?php if($avatar) echo ' with-avatar' ?>">
						<?php if ($comment->comment_approved == '0') : ?>
						   <p><em><?php _e('Your comment is awaiting moderation.','om_theme') ?></em></p>
						<?php endif; ?>
						<?php comment_text() ?>
					</div>
					<div class="clear"></div>

				</div>
			</div>
		<?php
	}
}

if( !function_exists( 'om_pings_list' ) ) {
	function om_pings_list($comment, $args, $depth) {
		
	  $GLOBALS['comment'] = $comment;
	  
	  ?><div id="comment-<?php comment_ID(); ?>"><?php comment_author_link();
	  
	}
}

?>