<?php

class UT2_content_twitter_name_link_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'content_twitter_name_link', array(
			'title'    => __( 'Convert Twitter name to links in content', UT2_SLUG ),
			'desc'    => __( 'Automatically converts @username in content to link to twitter account page', UT2_SLUG ),
			'on_desc'    => __( "@username will be converted to &lt;a href=\"http://twitter.com/username\"" .
			                    " target=\"_blank\" rel=\"nofollow\">@username&lt;/a>", UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('the_content', array($this, '_do'));
		add_filter('comment_text', array($this, '_do'));
	}

	function _do($content) {
		return preg_replace('/([^a-zA-Z0-9-_&])@([0-9a-zA-Z_]+)/', "$1<a href=\"http://twitter.com/$2\" target=\"_blank\" rel=\"nofollow\">@$2</a>", $content);
	}
}