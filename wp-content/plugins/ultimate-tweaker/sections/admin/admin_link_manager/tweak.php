<?php

class UT2_admin_link_manager_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_link_manager', array(
			'title'   => __( 'Enable links manager', UT2_SLUG ),
			'desc'   => __( 'Show hidden(from v.3.5) links manager and blogroll if you need.', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'pre_option_link_manager_enabled', '__return_true' );
	}
}