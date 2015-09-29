<?php

class UT2_custom_code_footer_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'custom_code_footer', 'textarea', array(
			'title'       => __( 'Custom Footer or Tracking code', UT2_SLUG ),
			'placeholder' => __( 'Example: <script>custom_code();</script>', UT2_SLUG ),
			'desc'        => __( 'Paste other tracking code here. This code will be added before the closing body tag.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'wp_footer', array($this, '_do'), 10000 );
	}

	function _do() {
		echo $this->value;
	}
}