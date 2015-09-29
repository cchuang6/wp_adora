<?php

class UT2_admin_dashboard_hide_welcome_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_dashboard_hide_welcome', array(
			'title' => __( 'Hide "Welcome to WordPress!" widget', UT2_SLUG )
		) );
	}

	function tweak() {
		remove_action( 'welcome_panel', 'wp_welcome_panel' );
		add_filter( 'get_user_metadata', array( &$this, '_get_user_metadata' ), 10, 4 );
	}

	function _get_user_metadata( $value, $object_id, $meta_key, $single ) {
		if ( $meta_key == 'show_welcome_panel' ) {
			return false;
		}

		return $value;
	}
}