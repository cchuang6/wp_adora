<?php

class UT2_admin_appearance_bg_color_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::field( 'admin_appearance_bg_color', 'color', array(
			'title' => __( 'Background color', UT2_SLUG ),
		) );

		return $f;
	}

	function tweak() {
		add_action( 'admin_head', array( $this, '_do' ), 1 );
	}

	function _do() {
		echo '<style type="text/css">' .
		     'html { background-color:'.$this->value.' }' .
		     '</style>';
	}
}