<?php

class UT2_admin_plugins_disable_delete_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_plugins_disable_delete', array(
			'title' => __( 'Disable deletion', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('delete_plugins');
//			$this->_do();
//			add_filter( 'plugin_action_links', array( $this, '_removeActionLink' ), 10, 4 );
	}

//	function _do() {
//		global $pagenow;
//
//		if($pagenow == 'plugins.php' && in_array($this->current_action(), array('delete', 'delete-selected'))) {
//			wp_die(__( 'Plugin activation/deactivation is disabled by Ultimate Tweaker.', UT2_SLUG ));
//		}
//	}
//
//	function _removeActionLink( $actions, $plugin_file, $plugin_data, $context ) {
//		if ( array_key_exists( 'delete', $actions ) )
//			unset( $actions['delete'] );
//		return $actions;
//	}
//
//	function _removeMenu() {
//		remove_submenu_page('plugins.php', 'plugin-editor.php');
//	}
//
//	public function current_action() {
//		if ( isset( $_REQUEST['filter_action'] ) && ! empty( $_REQUEST['filter_action'] ) )
//			return false;
//
//		if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] )
//			return $_REQUEST['action'];
//
//		if ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] )
//			return $_REQUEST['action2'];
//
//		return false;
//	}
}