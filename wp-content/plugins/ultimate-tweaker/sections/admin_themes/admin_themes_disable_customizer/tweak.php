<?php

class UT2_admin_themes_disable_customizer_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_themes_disable_customizer', array(
			'title' => __( 'Disable customizing', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('edit_theme_options');
	}
}