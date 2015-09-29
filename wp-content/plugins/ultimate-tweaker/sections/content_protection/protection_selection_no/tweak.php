<?php

class UT2_protection_selection_no_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'protection_selection_no', array(
			'title' => __( 'Disable selection', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
//			add_action( 'wp_enqueue_scripts', array( $this, '_do' ) );
	}

	function _do() {
//		global $wp_styles;
//		$ref = @$wp_styles->queue[0];
		echo '<style>' .
		     '*,*:focus {-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;outline-style:none;}'
		     . '</style>';
//		wp_add_inline_style( $ref, '*,*:focus {-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;outline-style:none;}' );
	}
}