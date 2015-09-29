<?php

class UT2_admin_menu_add_menus_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_menu_add_menus', array(
			'title'    => __( 'Add "Menus" to menu root level', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'admin_menu', array( $this, '_do' ), 0 );
	}

	function _do() {
		if ( current_theme_supports( 'menus' ) || current_theme_supports( 'widgets' )  ) {
			if( current_user_can('edit_theme_options')) {
				remove_submenu_page( 'themes.php', 'nav-menus.php' );
				add_menu_page( __( 'Menus' ), __( 'Menus' ), 'edit_theme_options', 'nav-menus.php', '', 'dashicons-menu', 30 );
			}
		}
	}
}