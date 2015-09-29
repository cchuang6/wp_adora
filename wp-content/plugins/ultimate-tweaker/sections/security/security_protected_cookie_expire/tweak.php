<?php

class UT2_security_protected_cookie_expire_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'security_protected_cookie_expire', array(
			'title'    => __( 'Expire Protected Page Cookie', UT2_SLUG ),
		) );

	}

	function tweak() {
		add_action( 'wp', array( $this, '_do' ) );
	}

	function _do() {
		if ( isset( $_COOKIE[ 'wp-postpass_' . COOKIEHASH ] ) ) {
			setcookie( 'wp-postpass_' . COOKIEHASH, '', 0, COOKIEPATH );
		}
	}
}