<?php

class UT2_content_link_target_blank_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'content_link_target_blank', array(
			'title'    => __( 'Open external post links in new window', UT2_SLUG ),
			'desc'    => __( 'Adds target="_blank"', UT2_SLUG ),
		) );
	}

	function tweak() {
		UT2_Helper::$_->script('post-link-target-blank', __FILE__, array('deps' => array( 'jquery' )));
	}
}