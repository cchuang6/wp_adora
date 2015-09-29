<?php

class UT2_security_disable_editor_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'security_disable_editor', array(
			'title' => __( 'Disable file editing', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('edit_files');
		UT2_Helper::blockUserCap('edit_plugins');
		UT2_Helper::blockUserCap('edit_themes');
	}
}