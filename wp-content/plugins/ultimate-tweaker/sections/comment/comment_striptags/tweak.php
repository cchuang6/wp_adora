<?php

class UT2_comment_striptags_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'comment_striptags', array(
			'title'    => __( 'Strip all tags', UT2_SLUG ),
			'on_desc'    => __( 'All tags will be deleted', UT2_SLUG ),
			'off_desc'    => __( 'All tags will be visible', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('comment_text', 'strip_tags');
	}
}