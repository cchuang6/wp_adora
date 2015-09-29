<?php

class UT2_admin_branding_screenoptions_no_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_branding_screenoptions_no', array(
			'title'   => __( 'Remove "Screen Options" panel', UT2_SLUG ),
			'desc'   => __( 'Contextual options panels will be deleted in all pages.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('screen_options_show_screen', '__return_false');
	}
}