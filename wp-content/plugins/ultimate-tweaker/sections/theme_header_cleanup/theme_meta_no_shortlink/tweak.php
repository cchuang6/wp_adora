<?php

class UT2_theme_meta_no_shortlink_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'theme_meta_no_shortlink', array(
			'title'    => __( 'Remove shortlink for the page', UT2_SLUG ),
			'on_desc'  => __( "<strike>&lt;link rel='shortlink' href='http://wp/?p=1' /></strike> in &lt;head>.", UT2_SLUG ),
			'off_desc' => __( "&lt;link rel='shortlink' href='http://wp/?p=1' />  in &lt;head>.", UT2_SLUG ),
		) );
	}

	function tweak() {
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	}
}