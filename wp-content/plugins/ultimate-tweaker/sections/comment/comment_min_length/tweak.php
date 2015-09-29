<?php

class UT2_comment_min_length_Tweak {
	function settings( ) {
		$f = array();
		$f[] = UT2_Helper::switcher( 'comment_min_length', array(
			'title'   => __( 'Check min length', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( '_comment_min_length_num', 'slider', array(
			'required' => array( 'comment_min_length', '=', '1' ),

			'title'    => (__( 'Min length', UT2_SLUG )),
			'default'       => 20,
			'min'           => 1,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'label'
		) );

		return $f;
	}

	function tweak() {
		add_action( 'preprocess_comment', array($this, '_do') );
	}

	function _do( $commentdata ) {
		$minimalCommentLength = isset($this->options->_comment_min_length_num) ? (int) $this->options->_comment_min_length_num : 20;

		if ( strlen( trim( $commentdata['comment_content'] ) ) < $minimalCommentLength )
		{
			wp_die( sprintf(__('All comments must be at least %s characters long.', UT2_SLUG), $minimalCommentLength));
		}
		return $commentdata;
	}
}