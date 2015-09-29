<?php

class UT2_admin_plugins_active_first_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_plugins_active_first', array(
			'title' => __( 'Active plugins first', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'all_plugins', array( $this, '_sort' ), 11 );
	}

	function _sort($plugins) {
		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		$result_plugins = array();
		$no_active = array();

		foreach($plugins as $slug=>$plugin) {
			if(in_array( $slug, $active_plugins )) {
				$result_plugins[ $slug ] = $plugin;
			} else {
				$no_active[ $slug ] = $plugin;
			}
		}

		return array_merge($result_plugins, $no_active);
	}
}