<?php

class UT2_login_error_message_Tweak {
	function settings( ) {
		$f = array();
		$f[] = UT2_Helper::switcher( 'login_error_message', array(
			'title'       => __( 'Login Error message', UT2_SLUG ),
			'off_desc'       => __( 'Default error messages.', UT2_SLUG ),
			'on_desc'       => __( 'Always show one custom error message.', UT2_SLUG ),
			'desc'       => __( 'We recommend use it, because users can see that login exists or not.', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( '_login_error_message_text', 'text', array(
			'required' => array( 'login_error_message', '=', '1' ),

			'right_title'    => __( 'Custom message:', UT2_SLUG ),
			'default'     => __( 'No valid credentials.', UT2_SLUG )
		) );

		return $f;
	}

	function tweak() {
		if($this->value && (@$_REQUEST['action'] !== 'register')) {
			add_filter( 'login_errors', array($this, '_do') );
		}
	}

	function _do( $message ) {
		$text = isset($this->options->_login_error_message_text) ? $this->options->_login_error_message_text
			: __( 'No valid credentials.', UT2_SLUG );
		return $text;
	}
}