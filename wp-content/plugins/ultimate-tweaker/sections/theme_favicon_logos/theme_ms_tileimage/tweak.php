<?php

class UT2_theme_ms_tileimage_Tweak {
	function settings() {
		return UT2_Helper::field( 'theme_ms_tileimage', 'media', array(
			'url'   => true,
			'mode'  => false,
			'title' => __( 'Tile image', UT2_SLUG ),
			'desc'  => __( 'Background image for live tile.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		?>
		<meta name="msapplication-TileImage" content="<?php echo $this->value['url']; ?>" /><?php
	}
}