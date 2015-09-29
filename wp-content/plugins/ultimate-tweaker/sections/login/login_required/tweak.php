<?php

class UT2_login_required_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'login_required', array(
			'title'    => __( 'Log In required to see site', UT2_SLUG ),
		) );

	}

	function tweak() {
		global $pagenow;
		if($pagenow != 'wp-login.php' && !is_user_logged_in()) {
			auth_redirect();
		}
	}
}