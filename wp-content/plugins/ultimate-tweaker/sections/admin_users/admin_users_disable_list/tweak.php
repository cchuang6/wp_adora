<?php

class UT2_admin_users_disable_list_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_users_disable_list', array(
			'title' => __( 'Disable list users', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('list_users');
		add_action('admin_menu', array($this, '_do'), 50);
	}

	function _do() {
		remove_submenu_page('profile.php', 'user-new.php');
	}
}