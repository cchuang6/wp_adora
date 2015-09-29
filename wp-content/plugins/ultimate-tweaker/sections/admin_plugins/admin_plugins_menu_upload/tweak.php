<?php

class UT2_admin_plugins_menu_upload_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_plugins_menu_upload', array(
			'title' => __( 'Add "Upload" to sub menu', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'admin_menu', array( $this, '_do' ), 0 );
	}

	function _do() {
		global $submenu;
//		var_dump($submenu);
		if( current_user_can('install_plugins')) {

//			$submenu['plugins.php'][10][0] = sprintf('<a href="%s">%s</a>', self_admin_url('plugin-install.php'), _x('Add New', 'plugin'). sprintf(' or <a href="%s">Upload</a>', self_admin_url('plugin-install.php?tab=upload')));
//			$submenu['plugins.php'][10][0] = _x('Add New', 'plugin'). sprintf(' or <a href="%s">Upload</a>', self_admin_url('plugin-install.php?tab=upload'));
//			$submenu['plugins.php'][10][0] = __( 'Upload', UT2_SLUG );
//			$submenu['plugins.php'][10][2] = 'plugin-install.php?tab=upload';

			add_submenu_page( 'plugins.php' , __( 'Upload' ), __( 'Upload' ), 'install_plugins', ( 'plugin-install.php?tab=upload' ), '');
		}
	}
}