<?php

class UT2_maintenance_button_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'maintenance_button', array(
			'title'    => __( 'Button in toolbar', UT2_SLUG ),
		) );
	}

	function tweak() {
		UT2_Helper::$_->style('style', __FILE__);
		add_action( 'init', array( $this, 'init' ), 0 );
		add_action( 'admin_bar_menu', array( &$this, 'admin_bar_menu' ), 8);
	}

	function init() {
		if ( isset( $_GET['ut_maintenance'] ) ) {
			$is_enabled = $_GET['ut_maintenance'] == 1 ? 1 : 0;
			$settings       = get_option( UT2_OPTION );
			if(!is_array($settings)) $settings = array();
			$settings['maintenance'] = $is_enabled;
			update_option( UT2_OPTION, $settings );
		}
	}

	function admin_bar_menu($wp_admin_bar) {
		$id = 'ut_maintenance';
		$checkedIcon = '<span class="ut_maintetance_icon dashicons-before dashicons-yes"></span>';
		$uncheckedIcon = '<span class="ut_maintetance_icon"></span>';
		$title = '<img style=" vertical-align: middle;" src="http://local/wp/tweaker/wp-content/plugins/ultimate-tweaker/assets/under3.svg">';//<span class="ab-label">' . __( 'Enabled', UT2_SLUG ) . '</span>

		$settings       = get_option( UT2_OPTION );
		if(!is_array($settings)) $settings = array();
		$is_enabled = @$settings['maintenance'] ? 1 : 0;

			$wp_admin_bar->add_menu( array(
			'id'        => $id,
			'parent'    => 'top-secondary',
			'title'     => $title,
			'href'      => '',
			'meta'      => array(
				'class'     => ($is_enabled?'maintenance-enabled':''),
				'title'     => __('Maintenance Mode', UT2_SLUG),
			),
		) );

		$wp_admin_bar->add_menu( array(
			'id'        => $id . '-enabled',
			'parent'    => $id,
			'title'     => ($is_enabled?$checkedIcon:$uncheckedIcon) . __('Enabled', UT2_SLUG),
			'href'      => add_query_arg( array( 'ut_maintenance' => 1 ) )
		) );

		$wp_admin_bar->add_menu( array(
			'id'        => $id . '-disabled',
			'parent'    => $id,
			'title'     => (!$is_enabled?$checkedIcon:$uncheckedIcon) . __('Disabled', UT2_SLUG),
			'href'      => add_query_arg( array( 'ut_maintenance' => 0 ) )
		) );
	}
}