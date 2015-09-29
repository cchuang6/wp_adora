<?php

class UT2_admin_no_collapse_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_no_collapse', array(
			'title'   => __( 'Disable collapse', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action('admin_head', array($this, '_do'), 0);
	}
	function _do() {
		?><style>#collapse-menu { display: none; visibility: hidden; }</style><?php
	}
}