<?php

class UT2_theme_apple_icon_76_Tweak {
	function settings() {
		return UT2_Helper::field( 'theme_apple_icon_76', 'media', array(
			'url'   => true,
			'mode'  => false,
			'title' => __( 'iPad', UT2_SLUG ),
			'desc'  => __( 'Normal size is 76x76px.', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		?>
		<link rel="apple-touch-icon" sizes="76x76" href="<?php echo $this->value['url']; ?>" /><?php
	}
}