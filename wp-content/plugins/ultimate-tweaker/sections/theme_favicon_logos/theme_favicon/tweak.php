<?php

class UT2_theme_favicon_Tweak {
	function settings() {
		return UT2_Helper::field( 'theme_favicon', 'media', array(
			'url'   => true,
			'title' => __( 'Favicon', UT2_SLUG ),
//			'desc'    => __( '', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		?>
		<link rel="shortcut icon" href="<?php echo $this->value['url']; ?>" /><?php
	}
}