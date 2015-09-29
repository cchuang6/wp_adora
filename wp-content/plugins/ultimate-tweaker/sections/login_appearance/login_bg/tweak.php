<?php

class UT2_login_bg_Tweak {
	function settings( ) {

		$f = array();

		$f[] = UT2_Helper::field( 'login_bg', 'media', array(
			'title'    => __( 'Background image', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( '_login_bg_size', 'radio', array(
			'title'    => __( 'Background image size', UT2_SLUG ),
			'options'  => array(
				'' => 'Cover',
				'repeat' => 'Repeat'
			),
		) );

		return $f;
	}

	function tweak() {
		add_action('login_head', array($this, '_logo'));
	}

	function _logo() {
		$add = '';
		if( $this->options->_login_bg_size == 'repeat') {
			$add = "background-size:initial;background-repeat: repeat;";
		}
		echo '<style type="text/css">html { background-image: url('.$this->value['url'].') !important;background-size:cover; '.$add.' } body {background: transparent !important;}</style>';
	}
}