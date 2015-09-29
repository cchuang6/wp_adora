<?php

class UT2_theme_move_js_footer_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'theme_move_js_footer', array(
			'title'    => __( 'Move js files to footer', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
	}

	function wp_enqueue_scripts() {
		remove_action('wp_head', 'wp_print_scripts');
		remove_action('wp_head', 'wp_print_head_scripts', 9);
		remove_action('wp_head', 'wp_enqueue_scripts', 1);
	}
}