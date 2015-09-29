<?php

class UT2_admin_dashboard_menu_hidden_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_dashboard_menu_hidden', array(
			'title'    => __( 'Hide dashboard', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'admin_menu', array( $this, '_do' ), 110 );
	}

	function _do() {
		if ( ! current_user_can( 'viewdashboard' ) ) {
			remove_menu_page( 'index.php' );
			remove_menu_page( 'separator1' );
		}
	}
}