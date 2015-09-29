<?php

class UT2_theme_apple_icon_60_Tweak {
	function settings( ) {
		$f = array();

		$f[] = UT2_Helper::field( 'info', array(
			'desc' => __( 'For all icons, the PNG format is recommended. You should avoid using interlaced PNGs.<br/>The standard bit depth for icons is 24 bits — that is, 8 bits each for red, green, and blue — plus an 8-bit alpha channel.<br/>If you want you can read more in <a href="https://developer.apple.com/library/ios/documentation/UserExperience/Conceptual/MobileHIG/IconMatrix.html#//apple_ref/doc/uid/TP40006556-CH27" target="_blank">iOS Human Interface Guidelines</a> page.', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( 'theme_apple_icon_60', 'media', array(
			'url'      => true,
			'mode'      => false,
			'title'    => __( 'iPhone', UT2_SLUG ),
			'desc' => __( 'Normal size is 60x60px.', UT2_SLUG )
		) );

		return $f;
	}

	function tweak() {
		add_action('wp_head', array($this, '_do'));
	}

	function _do() {
		?><link rel="apple-touch-icon" href="<?php echo $this->value['url']; ?>" /><?php
	}
}