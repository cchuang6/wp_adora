<?php

class UT2_registration_redirect_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'registration_redirect', 'select', array(
			'title'       => __( 'Redirect', UT2_SLUG ),
			'desc'       => __( 'By default, user will be redirected to admin page, or your own.', UT2_SLUG ),
			'data'     => 'pages',
		) );
	}

	function tweak() {
		add_action( 'registration_redirect', array($this, '_do') );
	}

	function _do() {
//		var_dump($this->value);
		return get_page_link($this->value);
	}
}