<?php

class UT2_admin_themes_disable_switch_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_themes_disable_switch', array(
			'title' => __( 'Disable switching', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('switch_themes');
	}
}