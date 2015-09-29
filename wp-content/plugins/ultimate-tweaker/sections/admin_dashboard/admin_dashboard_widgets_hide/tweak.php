<?php

class UT2_admin_dashboard_widgets_hide_Tweak {
	function settings( ) {
		$els = array(
			'dashboard_right_now' => __( 'At a Glance' ),
			'network_dashboard_right_now' => __( 'Right Now' ),
			'dashboard_activity' => __( 'Activity' ),
			'dashboard_quick_press' => __( 'Quick Draft' ),
			'dashboard_primary' => __( 'WordPress News' ),
		);

		if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) {
			$els['woocommerce_dashboard_recent_reviews'] = __( 'WooCommerce Recent Reviews', 'woocommerce' );
			$els['woocommerce_dashboard_status'] = __( 'WooCommerce Status', 'woocommerce' );
		}

		return UT2_Helper::field( 'admin_dashboard_widgets_hide', 'checkbox', array(
			'title'    => __( 'Hide dashboard widgets', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'options'  => $els,
		) );
	}

	function tweak() {
		add_action('wp_dashboard_setup', array($this, '_do'), 999);
	}

	function _do() {
		if(!$this->value || !is_array($this->value)) return;

		global $wp_meta_boxes;

		foreach($this->value as $id=>$v) {
			if(!$v) continue;

			switch($id) {
				case 'dashboard_right_now':
				case 'network_dashboard_right_now':
				case 'dashboard_activity':
//				case 'dashboard_recent_comments':
//				case 'dashboard_incoming_links':
//				case 'dashboard_plugins':
					unset($wp_meta_boxes['dashboard']['normal']['core'][$id]);
					break;
				case 'dashboard_primary':
//				case 'dashboard_secondary':
				case 'dashboard_quick_press':
//				case 'dashboard_recent_drafts':
					unset($wp_meta_boxes['dashboard']['side']['core'][$id]);
					break;
				case 'woocommerce_dashboard_status':
				case 'woocommerce_dashboard_recent_reviews':
					unset($wp_meta_boxes['dashboard']['normal']['core'][$id]);
					break;
			}
		}
	}
}