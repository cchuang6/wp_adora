<?php

class UT2_admin_plugins_disable_editor_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_plugins_disable_editor', array(
			'title' => __( 'Disable editor', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('edit_plugins');
//			$this->_do();
//			add_action( 'admin_menu', array( $this, '_removeMenu' ), 0 );
//			add_filter( 'plugin_action_links', array( $this, '_removeActionLink' ), 10, 4 );}
	}

//	function _do() {
//		global $pagenow;
//
//		if($pagenow == 'plugin-editor.php') {
//			wp_die(__( 'Plugin editor is disabled by Ultimate Tweaker.', UT2_SLUG ));
//		}
//	}
//
//	function _removeActionLink( $actions, $plugin_file, $plugin_data, $context ) {
//		if ( array_key_exists( 'edit', $actions ) )
//			unset( $actions['edit'] );
//		return $actions;
//	}
//
//	function _removeMenu() {
//		remove_submenu_page('plugins.php', 'plugin-editor.php');
//	}
}