<?php

class UT2_admin_dashboard_one_column_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_dashboard_one_column', array(
			'title'    => __( 'Dashboard 1 column layout', UT2_SLUG ),
			'on_desc'    => __( 'Force 1 column layout.', UT2_SLUG ),
			'off_desc'    => __( 'Depends user setting: 1 or 2.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('screen_layoUT2_columns', array($this, '_do'));
		add_filter('get_user_option_screen_layoUT2_dashboard', create_function('', 'return 1;'));
	}

	function _do($columns) {
		$columns['dashboard'] = 1;
		return $columns;
	}
}