<?php

class UT2_theme_ms_70x70_Tweak {
	function settings() {
		return UT2_Helper::field( 'theme_ms_70x70', 'media', array(
			'url'   => true,
			'mode'  => false,
			'title' => __( 'Small tile', UT2_SLUG ),
			'desc'  => __( 'Normal size is 70x70px.', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		?>
		<meta name="msapplication-square70x70logo" content="<?php echo $this->value['url']; ?>" /><?php
	}
}