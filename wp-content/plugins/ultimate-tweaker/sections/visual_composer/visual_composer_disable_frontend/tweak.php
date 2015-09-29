<?php

class UT2_visual_composer_disable_frontend_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'visual_composer_disable_frontend', array(
			'title'   => __( 'Disable frontend editor', UT2_SLUG ),
		) );
	}

	function tweak() {
		if(!defined( 'WPB_VC_VERSION' )) return;

		if(function_exists('vc_disable_frontend')) {
			vc_disable_frontend();
		}
	}
}