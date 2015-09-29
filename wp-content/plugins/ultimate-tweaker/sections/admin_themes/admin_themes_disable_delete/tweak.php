<?php

class UT2_admin_themes_disable_delete_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_themes_disable_delete', array(
			'title' => __( 'Disable deletion', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('delete_themes');
	}
}