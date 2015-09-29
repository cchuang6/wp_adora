<?php

class UT2_media_attachment_comments_no_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'media_attachment_comments_no', array(
			'title'    => __( 'Disable comments', UT2_SLUG ),
		) );

	}

	function tweak() {
		add_filter( 'comments_open', array($this, '_do'), 10 , 2 );
	}

	function _do( $open, $post_id ) {
		$post = get_post( $post_id );
		if( $post->post_type == 'attachment' ) {
			return false;
		}
		return $open;
	}
}