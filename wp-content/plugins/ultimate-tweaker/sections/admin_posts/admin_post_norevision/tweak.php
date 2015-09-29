<?php

class UT2_admin_post_norevision_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_post_norevision', array(
			'title'   => __( 'Disable revisions', UT2_SLUG )
		) );
	}

	function tweak() {
		remove_action ( 'post_updated', 'wp_save_post_revision' );
	}
}