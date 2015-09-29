<?php

class UT2_theme_apple_icon_180_Tweak {
	function settings() {
		return UT2_Helper::field( 'theme_apple_icon_180', 'media', array(
			'url'   => true,
			'mode'  => false,
			'title' => __( 'iPhone 6 Plus', UT2_SLUG ),
			'desc'  => __( 'Normal size is 180x180px.', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		?>
		<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $this->value['url']; ?>" /><?php
	}
}//		https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html#//apple_ref/doc/uid/TP40002051-CH3-SW6