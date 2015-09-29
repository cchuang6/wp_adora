<?php

class UT2_visual_composer_remove_meta_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'visual_composer_remove_meta', array(
			'title'   => __( 'Remove meta tag in head', UT2_SLUG ),
		) );
	}

	function tweak() {
		if(!defined( 'WPB_VC_VERSION' )) return;

		add_action('vc_after_init', array($this, '_do'));

	}

	function _do() {
		if(function_exists('visual_composer')) {
			if(method_exists( visual_composer(), 'addMetaData' )) {
				remove_action( 'wp_head', array( visual_composer(), 'addMetaData' ) );
			}
		}
	}
}