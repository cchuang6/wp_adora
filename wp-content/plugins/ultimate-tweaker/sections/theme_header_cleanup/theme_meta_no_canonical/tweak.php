<?php

class UT2_theme_meta_no_canonical_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'theme_meta_no_canonical', array(
			'title'    => __( 'Remove canonical link for the page', UT2_SLUG ),
			'subtitle' => __( '', UT2_SLUG ),
			'on_desc'  => __( "<strike>&lt;link rel='canonical' href='http://wp/?p=1' /></strike> in &lt;head>.", UT2_SLUG ),
			'off_desc' => __( "&lt;link rel='canonical' href='http://wp/?p=1' />  in &lt;head>.", UT2_SLUG ),
		) );
	}

	function tweak() {
		remove_action( 'wp_head', 'rel_canonical' );
	}
}