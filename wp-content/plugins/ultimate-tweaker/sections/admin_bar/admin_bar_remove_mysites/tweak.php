<?php

class UT2_admin_bar_remove_mysites_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_bar_remove_mysites', array(
			'title'   => __( 'My Sites', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'wp_before_admin_bar_render', array($this, '_do') );
	}

	function _do() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('my-sites');
	}
}