<?php

class UT2_security_pingback_disable_Tweak {
	function settings( ) {
		return UT2_Helper::switcher('security_pingback_disable', array(
			'title' => __( 'Disable Pingbacks', UT2_SLUG )
		));
	}

	function tweak() {
		add_filter('xmlrpc_enabled', '__return_false');
		add_filter( 'xmlrpc_methods', array($this, 'Remove_Pingback_Method') );

		if(!function_exists('remove_pingback_url')) {
			function remove_pingback_url( $output, $show ) {
				if ( $show == 'pingback_url' ) {
					$output = '';
				}

				return $output;
			}
		}
		add_filter( 'bloginfo_url', 'remove_pingback_url', 10, 2 );

		add_filter('wp_headers', array($this, 'remove_pingback'));
	}

	function remove_pingback( $headers )
	{
		unset($headers['X-Pingback']);

		return $headers;
	}


	function Remove_Pingback_Method( $methods ) {
		unset( $methods['pingback.ping'] );
		unset( $methods['pingback.extensions.getPingbacks'] );
		return $methods;
	}
}