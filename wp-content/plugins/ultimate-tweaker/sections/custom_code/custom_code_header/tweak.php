<?php

class UT2_custom_code_header_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'custom_code_header', 'textarea', array(
			'title'       => __( 'Custom Header code', UT2_SLUG ),
			'placeholder' => __( 'Example: <script>custom_code();</script>', UT2_SLUG ),
			'desc'        => __( 'Paste other code here. This code will be added before the closing head tag.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'wp_head', array($this, '_do'), 10000 );
	}

	function _do() {
		echo $this->value;
	}
}