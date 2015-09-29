<?php

class UT2_security_self_pinging_disable_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'security_self_pinging_disable', array(
			'title'   => __( 'Disable Self Pingbacks', UT2_SLUG ),
			'on_desc' => __( 'Pingbacks are disabled', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'pre_ping', array(&$this, '_do') );
	}

	function _do( &$links ) {
		$home = get_option( 'home' );
		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, $home ) ) {
				unset( $links[ $l ] );
			}
		}
	}
}