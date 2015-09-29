<?php

class UT2_updates_plugin_disable_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'updates_plugin_disable', array(
			'title'    => __( 'Disable Plugins Updates', UT2_SLUG ),
			'on_desc'  => 'Plugins updates are disabled.',
			'off_desc' => 'Plugins updates are enabled.',
		) );
	}

	function tweak() {
		add_filter( 'pre_site_transient_update_plugins', '__return_null' );
		remove_action( 'load-update-core.php', 'wp_update_plugins' );


		remove_action( 'load-plugins.php', 'wp_update_plugins' );
		remove_action( 'load-update.php', 'wp_update_plugins' );
		remove_action( 'admin_init', '_maybe_update_plugins' );
		remove_action( 'wp_update_plugins', 'wp_update_plugins' );
		add_filter( 'pre_transient_update_plugins', '__return_null' );

		UT2_Helper::blockUserCap('update_plugins');
	}
}