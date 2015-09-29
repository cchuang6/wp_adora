<?php

class UT2_admin_import_disable_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_import_disable', array(
			'title'   => __( 'Disable import', UT2_SLUG ),
			'desc'   => __( 'Import tool will be totally disabled and link Tools > Import hidden.', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::blockUserCap('import');
	}
}