<?php

class UT2_comment_disable_make_clickable_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'comment_disable_make_clickable', array(
			'title'    => __( 'Disable make_clickable', UT2_SLUG )
		) );
	}

	function tweak() {
		remove_filter('comment_text', 'make_clickable', 9);
	}
}