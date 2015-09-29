<?php

class UT2_theme_remove_ver_cssjs_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'theme_remove_ver_cssjs',  array(
			'title'    => __( 'Remove version parameter from css/js', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'style_loader_src', array($this, 'remove_cssjs_ver'), 10, 2 );
		add_filter( 'script_loader_src', array($this, 'remove_cssjs_ver'), 10, 2 );
	}

	function remove_cssjs_ver( $src ) {
		if ( strpos( $src, '?ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}
}