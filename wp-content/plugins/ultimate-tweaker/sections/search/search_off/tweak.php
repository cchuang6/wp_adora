<?php

class UT2_search_off_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'search_off', array(
			'title'    => __( 'Search off', UT2_SLUG ),
			'desc'  => 'If you are using Google Search you can turn off default search.',
		) );
	}

	function tweak() {
		unset( $_GET['s'] );
		unset( $_POST['s'] );
		unset( $_REQUEST['s'] );

		function fb_filter_query( $query, $error = true ) {
			if ( is_search() ) {
				$query->is_search = false;
				$query->query_vars['s'] = false;
				$query->query['s'] = false;

				// to error
				if ( $error == true )
					$query->is_404 = false;
			}
		}

		add_action( 'parse_query', 'fb_filter_query' );
		add_filter( 'get_search_form', create_function( '$a', "return null;" ) );
	}
}