<?php

class UT2_registration_noemail_passchange_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'registration_noemail_passchange', array(
			'title' => __( 'No password change notification', UT2_SLUG )
		) );

	}

	function tweak() {
		if ( !function_exists( 'wp_password_change_notification' ) ) {
			function wp_password_change_notification() {}
		}
	}
}