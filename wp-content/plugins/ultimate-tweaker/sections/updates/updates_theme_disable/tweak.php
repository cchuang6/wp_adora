<?php

class UT2_updates_theme_disable_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'updates_theme_disable', array(
			'title'    => __( 'Disable Theme Updates', UT2_SLUG ),
			'on_desc'  => 'Updates are disabled.',
			'off_desc' => 'Updates are enabled.',
		) );
	}

	function tweak() {
		remove_action('load-update-core.php','wp_update_themes');
		add_filter('pre_site_transient_update_themes', '__return_null');
		wp_clear_scheduled_hook('wp_update_themes');
	}
}