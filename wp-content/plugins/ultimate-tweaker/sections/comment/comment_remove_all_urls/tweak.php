<?php

class UT2_comment_remove_all_urls_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'comment_remove_all_urls', array(
			'title'    => __( 'Remove all urls', UT2_SLUG ),
			'on_desc'    => __( 'All urls will be removed.', UT2_SLUG ),
			'off_desc'    => __( 'All urls will be visible.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('comment_text', array($this, '_do'));
	}

	function _do($text) {
		$pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
		$replacement = "";
		$text = preg_replace($pattern, $replacement, $text);
		return $text;
	}
}