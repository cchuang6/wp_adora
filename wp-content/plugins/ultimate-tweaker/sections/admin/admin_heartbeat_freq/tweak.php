<?php

class UT2_admin_heartbeat_freq_Tweak {
	function settings( ) {
		$f = array();

		$f[] = UT2_Helper::field( 'admin_heartbeat_freq', 'slider', array(
			'title' => __( 'Frequency(seconds):', UT2_SLUG ),
			'default'     => 60,
			'min'         => 15,
			'step'         => 1,
			'max'         => 120,
		) );

		return $f;
	}

	function tweak() {
		add_filter( 'heartbeat_settings', array($this, '_do') );
	}

	function _do( $settings ) {
		$settings['interval'] = (int) $this->value;
		return $settings;
	}

}