<?php

class UT2_settings_deactivation_hook_Tweak {
	function settings() {
		return UT2_Helper::field( 'info', array(
			'desc'  => sprintf(__( 'You can turn off Ultimate Tweaker if you open page with "?ut_off=%s"<br>You can do this key any time: open wp-config.php file, take AUTH_KEY  and calculate md5(AUTH_KEY)', UT2_SLUG ), md5(AUTH_KEY)),
		) );
	}

	function tweak() {}
}