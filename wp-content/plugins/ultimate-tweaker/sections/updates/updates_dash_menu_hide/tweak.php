<?php

class UT2_updates_dash_menu_hide_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'updates_dash_menu_hide', array(
			'title'    => __( 'Hide "Updates" menu', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'admin_menu', array( $this, '_do' ), 110 );
	}

	function _do() {
		if ( ! current_user_can( 'viewdashboard' ) ) {
			remove_submenu_page( 'index.php', 'update-core.php');
		}
	}
}