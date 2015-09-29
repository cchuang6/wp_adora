<?php

class UT2_comment_front_spam_links_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'comment_front_spam_links', array(
			'title'   => __( 'Add Spam & Delete links', UT2_SLUG ),
			'desc'   => __( 'Adds links to comments on Front End', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('comment_reply_link', array($this, '_do'), 1000, 4);
	}
	function _do($html, $args, $comment, $post) {
		if (current_user_can('moderate_comments')) {
			$html .= '| <a href="'.admin_url('comment.php?action=cdc&c='.$comment->comment_ID).'">'.__('Delete', UT2_SLUG).'</a> ';
			$html .= '| <a href="'.admin_url('comment.php?action=cdc&dt=spam&c='.$comment->comment_ID).'">'.__('Spam', UT2_SLUG).'</a>';
		}

		return $html;
	}
}