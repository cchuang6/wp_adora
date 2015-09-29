<?php

class UT2_admin_heartbeat_Tweak {
	function settings( ) {
		$f = array();

		$f[] = UT2_Helper::field( 'admin_heartbeat', 'radio', array(
			'title'    => __( 'Heartbeat location', UT2_SLUG ),
			'options' => array(
				'' => 'Default',
				'only_edit' => 'Only on edit pages',
				'disabled' => 'Disabled',
				'disabled_dashboard' => 'Disabled on Dashboard',
			)
		) );

		return $f;
	}

	function tweak() {
		if($this->value == 'disabled') {
			add_action( 'init', array($this, 'disable_heartbeat'), 1 );
		} elseif($this->value == 'disabled_dashboard') {
			add_action( 'init', array($this, 'disable_dashboard_heartbeat'), 1 );
		} elseif($this->value == 'only_edit') {
			add_action( 'init', array($this, 'only_edit_heartbeat'), 1 );
		}
	}

	function disable_heartbeat() {
		wp_deregister_script('heartbeat');
	}

	function disable_dashboard_heartbeat() {
		global $pagenow;

		if ( $pagenow == 'index.php'  ) {
			wp_deregister_script( 'heartbeat' );
		}
	}
	function only_edit_heartbeat() {
		global $pagenow;

		if ( $pagenow != 'post.php' && $pagenow != 'post-new.php' ) {
			wp_deregister_script( 'heartbeat' );
		}
	}
}