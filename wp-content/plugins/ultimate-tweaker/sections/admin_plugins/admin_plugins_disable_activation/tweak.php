<?php

class UT2_admin_plugins_disable_activation_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_plugins_disable_activation', array(
			'title' => __( 'Disable activation/deactivation', UT2_SLUG )
		) );
	}

	function tweak() {
		$this->_do();
		add_filter( 'plugin_action_links', array( $this, '_removeActionLink' ), 10, 4 );
	}

//	function _cap( $allcaps, $cap, $args) {
//		if ( 'activate_plugins' == $args[0] ) {
//			$allcaps['activate_plugins'] = false;
//		}

//		return $allcaps;
//	}
	function _do() {
		global $pagenow;

		if($pagenow == 'plugins.php' && in_array($this->current_action(), array('activate', 'deactivate', 'activate-selected', 'deactivate-selected'))) {
			wp_die(__( 'Plugin activation/deactivation is disabled by Ultimate Tweaker.', UT2_SLUG ));
		}
	}

	function _removeActionLink( $actions, $plugin_file, $plugin_data, $context ) {
		if ( array_key_exists( 'activate', $actions ) )
			unset( $actions['activate'] );
		if ( array_key_exists( 'deactivate', $actions ) )
			unset( $actions['deactivate'] );
		return $actions;
	}

	function _removeMenu() {
		remove_submenu_page('plugins.php', 'plugin-editor.php');
	}

	public function current_action() {
		if ( isset( $_REQUEST['filter_action'] ) && ! empty( $_REQUEST['filter_action'] ) )
			return false;

		if ( isset( $_REQUEST['action'] ) && -1 != $_REQUEST['action'] )
			return $_REQUEST['action'];

		if ( isset( $_REQUEST['action2'] ) && -1 != $_REQUEST['action2'] )
			return $_REQUEST['action2'];

		return false;
	}
}