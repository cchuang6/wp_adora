<?php

class UT2_auto_updates_enable_Tweak {
	function settings( ) {
		$f = array();
		$f[] = UT2_Helper::switcher( 'auto_updates_enable', array(
			'title'    => __( 'Enable Auto Updates', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( 'auto_updates_key', 'text', array(
			'title'    => __( 'Item Purchase Code', UT2_SLUG ),
			'required' => array( 'auto_updates_enable', '=', '1' ),
			'desc'    => __( 'Enter your Envato license key here if you wish to receive auto updates.', UT2_SLUG )
			             . '<br /<br /><br />' . '<img src="' . plugins_url( 'license-key-hint.jpg', __FILE__ ) . '" />',
		) );

		return $f;
	}

	function tweak() {

	}
}