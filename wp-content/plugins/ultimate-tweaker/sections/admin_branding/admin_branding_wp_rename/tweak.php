<?php

class UT2_admin_branding_wp_rename_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::switcher( 'admin_branding_wp_rename', array(
			'title' => __( '"&#87;ordPress" rename', UT2_SLUG ),
			'desc'  => __( '', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( '_admin_branding_wp_rename', 'text', array(
			'required'    => array( 'admin_branding_wp_rename', '=', '1' ),
			'right_title' => __( 'Text:', UT2_SLUG ),
			'default'     => 'Custom Text'
		) );

		return $f;
	}

	function tweak() {
		$this->text = $this->options->_admin_branding_wp_rename;
		add_filter( 'gettext', array( $this, '_do' ) );
		add_filter( 'ngettext', array( $this, '_do' ) );
	}

	function _do( $str ) {
		return str_ireplace( 'WordPress', $this->text, $str );
	}
}