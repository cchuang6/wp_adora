<?php

class UT2_admin_export_disable_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_export_disable', array(
			'title'   => __( 'Disable export', UT2_SLUG ),
			'desc'   => __( 'Export tool will be totally disabled and link Tools > Export hidden.', UT2_SLUG )
		) );

	}

	function tweak() {
		UT2_Helper::blockUserCap('export');
	}
}