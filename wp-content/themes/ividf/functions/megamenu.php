<?php

/**
 * Backend Part
 */

class OmMenuWalkerEdit extends Walker_Nav_Menu {
	
	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker_Nav_Menu::start_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	function start_lvl( &$output, $depth = 0, $args = array() ) {}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker_Nav_Menu::end_lvl()
	 *
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {}
	
	/**
	 * Start the element output.
	 *
	 * @see Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id = $item->ID;
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)', 'om_theme' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)', 'om_theme'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		?>
		<li id="menu-item-<?php echo esc_attr($item_id); ?>" class="<?php echo implode(' ', $classes ); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo (0 == $depth ? 'style="display: none;"' : ''); ?>><?php _e( 'sub item', 'om_theme' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up', 'om_theme'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down', 'om_theme'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo esc_attr($item_id); ?>" title="<?php esc_attr_e('Edit Menu Item', 'om_theme'); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php _e( 'Edit Menu Item', 'om_theme' ); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo esc_attr($item_id); ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo esc_attr($item_id); ?>">
							<?php _e( 'URL', 'om_theme' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo esc_attr($item_id); ?>">
						<?php _e( 'Navigation Label', 'om_theme' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>">
						<?php _e( 'Title Attribute', 'om_theme' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr($item_id); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr($item_id); ?>" value="_blank" name="menu-item-target[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php _e( 'Open link in a new window/tab', 'om_theme' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>">
						<?php _e( 'CSS Classes (optional)', 'om_theme' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>">
						<?php _e( 'Link Relationship (XFN)', 'om_theme' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr($item_id); ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo esc_attr($item_id); ?>">
						<?php _e( 'Description', 'om_theme' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo esc_attr($item_id); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.', 'om_theme'); ?></span>
					</label>
				</p>
				
				<p class="field-om_icon hide-if-no-js description description-wide">
					<label for="edit-menu-item-om_icon-<?php echo esc_attr($item_id); ?>">
						<?php _e( 'Icon', 'om_theme' ); ?><br />
						<select id="edit-menu-item-om_icon-<?php echo esc_attr($item_id); ?>" class="widefat edit-menu-item-om_icon" name="menu-item-om_icon[<?php echo esc_attr($item_id); ?>]">
							 <?php echo om_get_icons_options_list($item->om_icon) ?>
						</select>
					</label>
				</p>
				
				<p class="field-megamenu description description-wide">
					<label for="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>">
						<input type="hidden" name="menu-item-megamenu[<?php echo esc_attr($item_id); ?>]" value="0" />
						<input type="checkbox" id="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>" value="1" name="menu-item-megamenu[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->megamenu, '1' ); ?> />
						<?php _e( 'Enable MegaMenu for nested items', 'om_theme' ); ?>
						<script>
							jQuery(function($){
								var change=function(obj){
									if($(obj).is(':checked')) {
										$('#edit-menu-item-megamenu_hide_titles-<?php echo esc_attr($item_id); ?>-wrapper').show();
									} else {
										$('#edit-menu-item-megamenu_hide_titles-<?php echo esc_attr($item_id); ?>-wrapper').hide();
									}
								}
								$('#edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>').change(function(){
									change(this);
								});
								change($('#edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>'));
							});
						</script>
					</label>
				</p>

				<p class="field-megamenu_hide_titles description description-wide" id="edit-menu-item-megamenu_hide_titles-<?php echo esc_attr($item_id); ?>-wrapper">
					<label for="edit-menu-item-megamenu_hide_titles-<?php echo esc_attr($item_id); ?>">
						<input type="hidden" name="menu-item-megamenu_hide_titles[<?php echo esc_attr($item_id); ?>]" value="0" />
						<input type="checkbox" id="edit-menu-item-megamenu_hide_titles-<?php echo esc_attr($item_id); ?>" value="1" name="menu-item-megamenu_hide_titles[<?php echo esc_attr($item_id); ?>]"<?php checked( $item->megamenu_hide_titles, '1' ); ?> />
						<?php _e( 'Hide MegaMenu column titles', 'om_theme' ); ?>
					</label>
				</p>
				
				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php _e( 'Move', 'om_theme' ); ?></span>
						<a href="#" class="menus-move-up"><?php _e( 'Up one', 'om_theme' ); ?></a>
						<a href="#" class="menus-move-down"><?php _e( 'Down one', 'om_theme' ); ?></a>
						<a href="#" class="menus-move-left"></a>
						<a href="#" class="menus-move-right"></a>
						<a href="#" class="menus-move-top"><?php _e( 'To the top', 'om_theme' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original: %s', 'om_theme'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr($item_id); ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php _e( 'Remove', 'om_theme' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo esc_attr($item_id); ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo esc_attr($item_id); ?>"><?php _e('Cancel', 'om_theme'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($item_id); ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}

}

class OmMegaMenu {
	
	protected $fields=array(
		'megamenu',
		'megamenu_hide_titles',
		'om_icon',
	);

	function __construct() {
		
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'om_OmMenuWalkerEdit' ) );
		
		add_action( 'wp_update_nav_menu_item', array( $this, 'update_custom_fields' ), 10, 3); //, $menu_id, $menu_item_db_id, $args;
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'get_custom_fields' ) );
		
		add_action('admin_head-nav-menus.php', array( $this, 'custom_css' ));
		
	}

	function om_OmMenuWalkerEdit( $className ){
		return 'OmMenuWalkerEdit';
	}
	
	/**
	 * Custom CSS
	 */
	 
	function custom_css() {
	  echo '<style>
	  	.menu-item .field-megamenu,
	  	.menu-item .field-megamenu_hide_titles {display:none}
	  	.menu-item.menu-item-depth-0 .field-megamenu,
	  	.menu-item.menu-item-depth-0 .field-megamenu_hide_titles {display:block}
	  </style>';
	}

	/**
	 * Save fields in the database
	 */
	
	function update_custom_fields( $menu_id, $menu_item_db_id, $args ) {
		
		foreach($this->fields as $field) {
			if ( isset( $_REQUEST['menu-item-'.$field] ) && is_array( $_REQUEST['menu-item-'.$field] ) ) {
				update_post_meta( $menu_item_db_id, '_menu_item_'.$field, $_REQUEST['menu-item-'.$field][$menu_item_db_id] );
			}
		}
	}	

	/**
	 * Get fields from the database
	 */
	 
	function get_custom_fields( $menu_item ) {
		foreach($this->fields as $field) {
			$menu_item->$field = get_post_meta( $menu_item->ID, '_menu_item_'.$field, true );
		}
		return $menu_item;
	}
	
}

/**
 * FrontEnd Part
 */
 
function om_megamenu_nav_menu ($items) {
	
	$hide_titles=array();
	
	foreach($items as $item) {
		if ($item->menu_item_parent == 0) {
			$megamenu = isset($item->megamenu) ? $item->megamenu : get_post_meta( $item->ID, '_menu_item_megamenu', true );
			if($megamenu) {
				$item->classes[] = 'megamenu-enable';
				
				$megamenu_hide_titles = isset($item->megamenu_hide_titles) ? $item->megamenu_hide_titles : get_post_meta( $item->ID, '_menu_item_megamenu_hide_titles', true );
				if($megamenu_hide_titles) {
					$item->classes[] = 'megamenu-hide-titles';
					$hide_titles[]=$item->ID;
				}
			}
		}
	}
	
	if(!empty($hide_titles)) {
		foreach($items as $item) {
			if(in_array($item->menu_item_parent, $hide_titles))
				$item->hide_item=true;
		}
	}
	
	return $items;    
}

function om_megamenu_nav_menu_link_attr ($atts, $item) {
	
	$icon = isset($item->om_icon) ? $item->om_icon : get_post_meta( $item->ID, '_menu_item_om_icon', true );
	
	if($icon) {
		if(isset($atts['class']))
			$atts['class'].=' ';
		else
			$atts['class']='';
			
		$atts['class'].=om_icon_classes_before($icon);
	}
	
	return $atts;
}

function om_megamenu_walker_nav_menu_start_el($item_output, $item, $depth, $args) {
	
	if(isset($item->hide_item) && $item->hide_item)
		$item_output='';
	return $item_output;
}
/**
 * Initialization
 */

if( get_option( OM_THEME_PREFIX . 'menu_megamenu_active') == 'true' ) {

	$GLOBALS['OmMegaMenu'] = new OmMegaMenu();
	
	add_filter('wp_nav_menu_objects', 'om_megamenu_nav_menu');
	add_filter('nav_menu_link_attributes', 'om_megamenu_nav_menu_link_attr', 10, 3);
	add_filter('walker_nav_menu_start_el', 'om_megamenu_walker_nav_menu_start_el', 10, 4);
	
	
}
