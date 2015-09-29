<?php

class UT2_visual_composer_icon_click_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'visual_composer_icon_click', array(
			'title'    => __( 'Open on icon click', UT2_SLUG )
		) );
	}

	function tweak() {
		if(!defined( 'WPB_VC_VERSION' )) return;

		add_action('vc_backend_editor_render', array($this, '_do'));
	}

	function _do() {
		UT2_Helper::$_->script('vc-icon-click', __FILE__, array('deps' => array( 'jquery', 'post' )));
		UT2_Helper::$_->inlineStyle('.vc_element-icon', 'cursor: pointer;', 'js_composer');
	}
}