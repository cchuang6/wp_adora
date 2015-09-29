<?php

class UT2_security_nosniff_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'security_nosniff', array(
			'title'   => __( 'Add nosniff header', UT2_SLUG )
		) );
	}

	function tweak() {
		header('X-Content-Type-Options: nosniff');
	}
}