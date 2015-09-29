<?php

class UT2_theme_apple_icon_120_Tweak {
	function settings() {
		return UT2_Helper::field( 'theme_apple_icon_120', 'media', array(
			'url'     => true,
			'mode'    => false,
			'title'   => __( 'iPhone Retina', UT2_SLUG ),
			'desc'    => __( 'Normal size is 120x120px.', UT2_SLUG ),
			'default' => ''
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		?>
		<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $this->value['url']; ?>" /><?php
	}
}