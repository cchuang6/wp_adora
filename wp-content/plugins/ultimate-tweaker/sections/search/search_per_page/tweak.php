<?php

class UT2_search_per_page_Tweak {
	function settings() {
		$t   = array();
		$t[] = UT2_Helper::switcher( 'search_per_page', array(
			'title' => __( 'Posts per page', UT2_SLUG ),
		) );


		$f[] = UT2_Helper::field( '_search_per_page_amount', 'slider', array(
			'required'      => array( 'search_per_page', '=', '1' ),
			'right_title'   => __( 'Number of posts per page:', UT2_SLUG ),
			'default'       => 10,
			'min'           => 2,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		) );

		return $t;
	}

	function tweak() {
		add_filter( 'pre_get_posts', array( $this, '_do' ) );
	}

	function _do() {
		if ( is_search() ) {
			set_query_var( 'posts_per_archive_page', (int) $this->options->_search_per_page_amount );
		}
	}
}