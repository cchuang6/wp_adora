<?php

class UT2_post_author_notification_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'post_author_notification', array(
			'title' => __( 'Automatically email contributor when their post is published', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'publish_post', array( &$this, '_do' ) );
	}

	function _do( $post_id ) {
		$post   = get_post( $post_id );
		$author = get_userdata( $post->post_author );
		$message = "
Hi " . $author->display_name . ",
Your post, " . $post->post_title . " has just been published. Thank you!
";
		wp_mail( $author->user_email, "Your article is published and online", $message );
	}
}