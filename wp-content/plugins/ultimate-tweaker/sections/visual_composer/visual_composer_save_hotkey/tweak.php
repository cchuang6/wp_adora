<?php

class UT2_visual_composer_save_hotkey_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'visual_composer_save_hotkey', array(
			'title'    => __( 'Save element on Ctrl+Enter', UT2_SLUG )
		) );
	}

	function tweak() {
		if(!defined( 'WPB_VC_VERSION' )) return;

		add_action('vc_backend_editor_render', array($this, '_do'));
	}

	function _do() {
		UT2_Helper::$_->script('vc-save-hotkey', __FILE__, array('deps' => array( 'jquery', 'post', 'mousetrap' )));
	}
}