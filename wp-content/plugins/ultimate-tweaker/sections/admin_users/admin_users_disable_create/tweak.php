<?php

class UT2_admin_users_disable_create_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_users_disable_create', array(
			'title' => __( 'Disable creation new', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('create_users');
	}
}