<?php

class UT2_seo_meta_copyright_Tweak {
	function settings() {
		$f   = array();

		$f[] = UT2_Helper::field( 'seo_meta_copyright', 'text', array(
			'title'       => __( 'Meta copyright', UT2_SLUG ),
			'placeholder' => __( 'Example: All rights reserved © Amino, 2015', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( '_seo_meta_copyright_mode', 'radio', array(
			'title'   => __( 'Meta Copyright Pages', UT2_SLUG ),
			'options' => array(
				''         => 'All pages',
				'singular' => 'Singular'
			),
		) );

		return $f;
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ) );
	}

	function _do() {
		if ( $this->options->_seo_meta_copyright_mode == 'singular' && ! is_singular() ) {
			return;
		}

		echo "<meta name=\"copyright\" content=\"" . wptexturize( $this->value ) . "\">";
	}
}