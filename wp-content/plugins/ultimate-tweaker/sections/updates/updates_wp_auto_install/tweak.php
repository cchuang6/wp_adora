<?php

class UT2_updates_wp_auto_install_Tweak {
	function settings() {
		return UT2_Helper::field( 'updates_wp_auto_install', 'radio', array(
			'title'   => __( 'Core update Auto Installation', UT2_SLUG ),
			'desc'    => __( 'By default, WordPress auto-installs minor updates only.', UT2_SLUG ),
			'options' => array(
				''      => 'Default',
				'none'  => 'Disable',
				'minor' => 'Only Minor',
				'major' => 'All'
			)
		) );
	}

	function tweak() {
		if ( 'none' == $this->value ) {
			add_filter( 'auto_update_core', '__return_false', 1000 );
		} elseif ( 'minor' == $this->value || 'major' == $this->value ) {
			add_filter( 'automatic_updates_is_vcs_checkout', '__return_false', 1000 );
			add_filter( 'auto_update_core', '__return_true', 1000 );
			add_filter( 'allow_minor_auto_core_updates', '__return_true', 1000 );

			if ( 'minor' == $this->value ) {
				add_filter( 'allow_major_auto_core_updates', '__return_false', 1000 );
			} else {
				add_filter( 'allow_major_auto_core_updates', '__return_true', 1000 );
			}
		}
	}
}