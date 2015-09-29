<?php

class UT2_visual_composer_hide_teaser_metabox_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'visual_composer_hide_teaser_metabox', array(
			'title'   => sprintf(__( 'Hide "%s" metabox', UT2_SLUG ), __( 'VC: Custom Teaser', "js_composer" )),
		) );
	}

	function tweak() {
		if(!defined( 'WPB_VC_VERSION' )) return;

		if(!function_exists('vc_editor_post_types')) return;

		add_action( 'admin_head', array(&$this, '_do') );
	}

	function _do() {
		$pt_array = vc_editor_post_types();
		foreach ( $pt_array as $pt ) {
			remove_meta_box('vc_teaser', $pt, 'side');
		}
	}
}