<?php

class UT2_comment_no_capital_p_dangit_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'comment_no_capital_p_dangit', array(
			'title'   => __( 'Remove "Wordpress" to "WordPress" filter', UT2_SLUG ),
		) );
	}

	function tweak() {
		if(function_exists('capital_P_dangit')) {
			foreach ( array( 'the_content', 'the_title' ) as $filter )
				remove_filter( $filter, 'capital_P_dangit', 11 );

			remove_filter('comment_text', 'capital_P_dangit', 31 );
		}
	}
}