<?php

class UT2_updates_wp_disable_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'updates_wp_disable', array(
			'title'   => __( 'Disable WordPress Updates', UT2_SLUG ),
			'on_desc'       => ' Updates are disabled.',
			'off_desc'      => ' Updates are enabled.',
		) );
	}

	function tweak() {
		if(!function_exists('remove_admin_bar_links')) {
			function remove_admin_bar_links() {
				global $wp_admin_bar;
				$wp_admin_bar->remove_menu( 'updates' );
			}
		}
		add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

		add_action('admin_menu','wphidenag');

		if(!function_exists('wphidenag')) {
			function wphidenag() {
				remove_action( 'admin_notices', 'update_nag', 3 );
			}
		}
		//			add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );

		add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
		remove_action( 'init', 'wp_version_check' );
		remove_action( 'wp_version_check', 'wp_version_check' );
		remove_action( 'admin_init', '_maybe_update_core' );
		add_filter( 'pre_transient_update_core', create_function( '$a',
			"return null;" ) );

		UT2_Helper::blockUserCap('update_core');
//			add_action( 'wp_before_admin_bar_render', array($this, '_hideAdminBar') );
	}

//	function _hideAdminBar() {
//		global $wp_admin_bar;
//		$wp_admin_bar->remove_menu('updates');
//	}
}