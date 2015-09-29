<?php

class UT2_theme_fast_click_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'theme_fast_click',array(
			'title'       => __( 'Enable fast click on Touch-devices', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::$_->script('fastclick', __FILE__, array('deps' => array( 'jquery' )));
	}
}