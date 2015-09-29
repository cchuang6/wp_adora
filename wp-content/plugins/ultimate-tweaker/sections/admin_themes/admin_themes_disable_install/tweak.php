<?php

class UT2_admin_themes_disable_install_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_themes_disable_install', array(
			'title' => __( 'Disable installation', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('install_themes');
	}
}