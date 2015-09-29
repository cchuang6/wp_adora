<?php

class UT2_theme_ms_tilecolor_Tweak {
	function settings() {
		return UT2_Helper::field( 'theme_ms_tilecolor', 'color', array(
			'title'       => __( 'Background color for a live tile', UT2_SLUG ),
			'transparent' => false
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		?>
		<meta name="msapplication-TileColor" content="<?php echo $this->value; ?>" /><?php
	}
}