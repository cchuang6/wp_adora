<?php

class UT2_admin_branding_iconcolor_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'admin_branding_iconcolor', 'color', array(
			'title'    => __( 'Icon color', UT2_SLUG ),
			'desc'    => __( 'Normal color state of admin area icons.', UT2_SLUG ),
			'transparent'  => false
		) );
	}

	function tweak() {
		add_action('admin_head', array($this, '_do'));
	}

	function _do() {
		$color = $this->value;
		echo '<style type="text/css">';
		echo '#adminmenu div.wp-menu-image:before,#collapse-button div:after,#dashboard_right_now li a:before, #dashboard_right_now li span:before { color: '.$color.'; }';
		echo '#wpadminbar #adminbarsearch:before, #wpadminbar .ab-icon:before, #wpadminbar .ab-item:before { color: '.$color.'; }';
		echo '</style>';
	}
}