<?php

class UT2_admin_dashboard_collapse_no_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_dashboard_collapse_no', array(
			'title'    => __( 'Disable widgets collapsing', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action('load-index.php', array($this, '_do'));
	}

	function _do() {
		UT2_Helper::$_->script('script', __FILE__, array( 'in_footer' =>true, 'deps' => array( 'jquery' ,'postbox' )));
	}
}