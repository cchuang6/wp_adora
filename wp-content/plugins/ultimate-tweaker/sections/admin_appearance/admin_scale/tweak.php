<?php

class UT2_admin_scale_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::switcher( 'admin_scale', array(
			'title' => __( 'Zoom page', UT2_SLUG ),
		) );


		$f[] = UT2_Helper::field('_admin_scale_percent', 'slider', array(
			'required'    => array( 'admin_scale', '=', '1' ),
			'right_title' => __( 'Percent:', UT2_SLUG ),
			'default'       => 100,
			'min'           => 1,
			'step'          => 1,
			'max'           => 200,
			'display_value' => 'text'
		));

		return $f;
	}

	function tweak() {
		add_filter( 'admin_head', array( $this, '_do' ) );
	}

	function _do( $str ) {
		$percent = (int)$this->options->_admin_scale_percent;
		echo '<style>html {zoom: '.($percent/100).';zoom:'.$percent.'%;}</style>';
	}
}