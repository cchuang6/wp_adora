<?php

class UT2_security_xss_protection_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'security_xss_protection', array(
			'title'   => __( 'Add xss protection header', UT2_SLUG )
		) );
	}

	function tweak() {
		header('X-XSS-Protection: 1; mode=block');
	}
}