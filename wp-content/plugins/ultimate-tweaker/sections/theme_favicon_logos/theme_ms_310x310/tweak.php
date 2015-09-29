<?php

class UT2_theme_ms_310x310_Tweak {
	function settings() {
		return UT2_Helper::field( 'theme_ms_310x310', 'media', array(
			'url'   => true,
			'mode'  => false,
			'title' => __( 'Large tile', UT2_SLUG ),
			'desc'  => __( 'Normal size is 310x310px.', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		?>
		<meta name="msapplication-wide310x310logo" content="<?php echo $this->value['url']; ?>" /><?php
	}
}