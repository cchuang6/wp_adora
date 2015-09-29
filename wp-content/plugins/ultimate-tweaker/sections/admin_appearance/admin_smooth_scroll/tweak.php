<?php

class UT2_admin_smooth_scroll_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_smooth_scroll',array(
			'title'       => __( 'Enable smooth scroll in Chrome', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::$_->script('smooth-scroll', __FILE__, array('deps' => array( 'jquery' )));
	}
}