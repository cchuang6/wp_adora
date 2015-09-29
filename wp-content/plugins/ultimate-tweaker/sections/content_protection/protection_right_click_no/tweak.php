<?php

class UT2_protection_right_click_no_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'protection_right_click_no', array(
			'title'    => __( 'Disable right-click', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::$_->script('dis-right-click', __FILE__, array('deps'=>array("jquery")) );
	}
}
