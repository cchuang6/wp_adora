<?php

class UT2_general_page404_redirect_Tweak {
	function settings() {
		return UT2_Helper::field( 'general_page404_redirect', 'select', array(
			'title' => __( 'Not Found(error 404) page', UT2_SLUG ),
			'desc'  => __( 'Then WordPress does not found the page, you can use any another page to show and suggest another usable information on site. By default standart theme page shows.', UT2_SLUG ),
			'data'  => 'pages',
		) );
	}

	function tweak() {
		add_action( 'template_redirect', array( $this, '_do' ) );
	}

	function _do() {
		if ( is_404() ) {
			header( "Status: 404 Not Found" );
			header( "HTTP/1.0 404 Not Found" );
			define( 'DONOTCACHEPAGE', true );
			wp_redirect( get_page_link( $this->value ) );
			exit;
		}
	}
}