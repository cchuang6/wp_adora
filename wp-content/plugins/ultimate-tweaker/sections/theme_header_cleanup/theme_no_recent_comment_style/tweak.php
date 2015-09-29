<?php

class UT2_theme_no_recent_comment_style_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'theme_no_recent_comment_style', array(
			'title'    => __( 'Remove recent comments widget styles', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'show_recent_comments_widget_style', '__return_false' );
	}
}