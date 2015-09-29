<?php

class UT2_login_bg_color_Tweak {
	function settings( ) {

		$f = array();

		$f[] = UT2_Helper::field( 'login_bg_color', 'color', array(
			'title'    => __( 'Background color', UT2_SLUG ),
		) );

		return $f;
	}

	function tweak() {
		add_action('login_head', array($this, '_do'));
	}

	function _do() {
		echo '<style type="text/css">html { background-color: '.$this->value.';}body {background: transparent !important;}</style>';
	}
}