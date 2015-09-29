<?php

class UT2_protection_prtscr_no_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'protection_prtscr_no', array(
			'title' => __( 'Disable PrintScreen button', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::$_->script('dis-prtscr', __FILE__, array('deps'=>array("jquery")) );
	}
}