<?php

class UT2_admin_themes_disable_editor_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_themes_disable_editor', array(
			'title' => __( 'Disable editor', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('edit_themes');
	}
}