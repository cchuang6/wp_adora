<?php

class UT2_updates_footer_nag_hide_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'updates_footer_nag_hide', array(
			'title'   => __( 'Hide message in footer', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'update_footer' , array( &$this, '_clearVersion' ), 90 );
	}

	function _clearVersion( $version ) {

		return '';
	}
}