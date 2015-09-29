<?php

class UT2_theme_jquery_cdn_Tweak {
	function settings() {
		$f   = array();
		$f[] = UT2_Helper::switcher( 'theme_jquery_cdn', array(
			'title' => __( 'Load jQuery from CDN', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( '_theme_jquery_cdn_source', 'radio', array(
			'required'    => array( 'theme_jquery_cdn', '=', '1' ),
			'right_title' => __( 'CDN source:', UT2_SLUG ),
			'options'     => array(
				''       => 'jQuery CDN (provided by MaxCDN)',
				'google' => 'Google CDN'
			)
		) );

		$f[] = UT2_Helper::field( '_theme_jquery_cdn_mode', 'radio', array(
			'required'    => array( 'theme_jquery_cdn', '=', '1' ),
			'right_title' => __( 'jQuery scripts from CDN:', UT2_SLUG ),
			'options'     => array(
				''     => 'Only jQuery',
				'both' => 'jQuery and jQuery-migrate'
			)
		) );

		return $f;
	}

	function tweak() {
		add_action( 'wp_enqueue_scripts', array( $this, '_do' ), 10 );
	}

	function _do() {
		$wp_jquery_ver = $GLOBALS['wp_scripts']->registered['jquery']->ver;
		$jquery_ver    = $wp_jquery_ver == '' ? '1.11.1' : $wp_jquery_ver;

		$j_url = $this->options->_theme_jquery_cdn_source == 'google' ? '//ajax.googleapis.com/ajax/libs/jquery/' . $wp_jquery_ver . '/jquery.min.js' : '//code.jquery.com/jquery-' . $wp_jquery_ver . '.min.js';

		if ( $this->options->_theme_jquery_cdn_mode == 'both' ) {
//			$jm_url =  $this->options->_theme_jquery_cdn_source == 'google' ? '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' : '//code.jquery.com/jquery-migrate-1.2.1.min.js';
			$jm_url = '//code.jquery.com/jquery-migrate-1.2.1.min.js';

			wp_deregister_script( 'jquery-migrate' );
			wp_register_script( 'jquery-migrate', $jm_url );
			wp_deregister_script( 'jquery-core' );
			wp_register_script( 'jquery-core', $j_url );
		} else {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', $j_url );
		}
	}
}