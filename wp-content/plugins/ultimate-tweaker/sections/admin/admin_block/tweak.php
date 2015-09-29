<?php

class UT2_admin_block_Tweak {
	function isVisible() {
		return !(in_array(UT2_Helper::getRequestRole(), array('administrator', '')));
	}

	function settings( ) {
		return UT2_Helper::switcher( 'admin_block', array(
			'title'    => __( 'Block admin page', UT2_SLUG ),
			'on_desc'    => __( 'User will be redirected to homepage', UT2_SLUG ),
			'off_desc'    => __( 'User can see admin page', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter( 'show_admin_bar', '__return_false' );
		add_action( 'init', array( &$this, '_init' ), 0);
	}

	function _init() {
		if ( is_user_logged_in() && is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			wp_redirect(home_url());
			exit;
		}
	}
}