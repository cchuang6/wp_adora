<?php

class UT2_settings_ut_user_Tweak {
	function settings() {
		$user_query = new WP_User_Query( array(
			'role' => 'administrator'
		) );
		$users = array();

		if ( ! empty( $user_query->results ) ) {
			foreach ( $user_query->results as $user ) {
				$users[$user->ID] = $user->display_name;

			}
		}

		return UT2_Helper::field( 'settings_ut_user', 'select', array(
			'title' => __( 'Exception users', UT2_SLUG ),
			'multi'    => true,
			'desc'  => __( 'All settings are disabled for this users. You can select only administrators.', UT2_SLUG ),
			'options' => $users,
		) );
	}

	function tweak() {}
}