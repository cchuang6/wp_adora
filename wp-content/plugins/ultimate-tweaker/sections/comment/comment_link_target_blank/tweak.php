<?php

class UT2_comment_link_target_blank_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'comment_link_target_blank', array(
			'title'    => __( 'Open external comment links in new window', UT2_SLUG ),
			'desc'    => __( 'Adds target="_blank"', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::$_->script('comment-link-target-blank', __FILE__, array('deps' => array( 'jquery' )));
	}
}