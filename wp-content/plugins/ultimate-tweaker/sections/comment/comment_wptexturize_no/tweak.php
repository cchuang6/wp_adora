<?php

class UT2_comment_wptexturize_no_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'comment_wptexturize_no', array(
			'title' => __( 'Disable wptexturize', UT2_SLUG ),
			'desc'  => 'You can read information about this function here: http://codex.wordpress.org/Function_Reference/wptexturize',
		) );
	}

	function tweak() {
		remove_filter( "comment_text", "wptexturize" );
	}
}