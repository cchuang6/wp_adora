<?php

class UT2_comment_close_days_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::switcher( 'comment_close_days', array(
			'title' => __( 'Enable comments closing', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( '_comment_close_days_num', 'slider', array(
			'required'      => array( 'comment_close_days', '=', '1' ),
			'title'         => ( __( 'Close comments after days', UT2_SLUG ) ),
			'default'       => 7,
			'min'           => 1,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'label'
		) );


		$f[] = UT2_Helper::switcher( '_comment_close_days_notify', array(
			'title' => __( 'Show close comments notify text', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( '_comment_close_days_notify_text', 'text', array(
			'required'    => array( '_comment_close_days_notify', '=', '1' ),
			'right_title' => __( 'Close comments notify text:', UT2_SLUG ),
			'desc'        => __( 'Default: (This topic will automatically close in %s. )', UT2_SLUG ),
			'default'     => __( '(This topic will automatically close in %s. )', UT2_SLUG ),
		) );

		return $f;
	}

	function tweak() {
		add_filter( 'the_posts', array( $this, '_do' ) );
		add_action( 'preprocess_comment', array( $this, '_doPrePost' ) );

		if ( @$this->options->_comment_close_days_notify ) {
			add_action( 'comment_form_top', array( $this, '_doNotify' ) );
		}
	}

	function _do( $posts ) {
		$comment_close_days_num = isset( $this->options->_comment_close_days_num ) ? (int) $this->options->_comment_close_days_num : 7;

		if ( ! $posts ) {
			return $posts;
		}
		if ( ! is_single() ) {
			return $posts;
		}

		if ( time() - strtotime( $posts[0]->post_date_gmt ) > ( $comment_close_days_num * 24 * 60 * 60 ) ) {
			$posts[0]->comment_status = 'closed';
			$posts[0]->ping_status    = 'closed';
		}

		return $posts;
	}


	function _doPrePost( $commentdata ) {
		$comment_close_days_num = isset( $this->options->_comment_close_days_num ) ? (int) $this->options->_comment_close_days_num : 7;

		$post = get_post( $commentdata['comment_post_ID'] );

		if ( time() - strtotime( $post->post_date_gmt ) > ( $comment_close_days_num * 24 * 60 * 60 ) ) {
			wp_die( __( 'Comments are closed.', UT2_SLUG ) );
		}

		return $commentdata;
	}

	function _doNotify() {
		global $post;

		$text = isset( $this->options->_comment_close_days_notify_text ) ? $this->options->_comment_close_days_notify_text
			: __( '(This topic will automatically close in %s. )', UT2_SLUG );

		if ( $post->comment_status == 'open' ) {
			$comment_close_days_num = isset( $this->options->_comment_close_days_num ) ? (int) $this->options->_comment_close_days_num : 7;
			$expires                = strtotime( "{$post->post_date_gmt} GMT" ) + $comment_close_days_num * DAY_IN_SECONDS;
			printf( $text, human_time_diff( $expires ) );
		}
	}
}