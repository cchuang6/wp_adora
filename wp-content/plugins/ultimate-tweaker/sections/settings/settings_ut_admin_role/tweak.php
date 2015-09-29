<?php

class UT2_settings_ut_admin_role_Tweak {
	function settings( ) {
		$this->fields = array();

		$this->fields[] = UT2_Helper::field( 'settings_ut_admin_role', 'radio', array(
			'title'    => __( '"Ultimate Tweaker Administrator" role', UT2_SLUG ),
			'options'  => array(
				'on' => __('Enabled', UT2_SLUG ),
				'off' =>__( 'Disabled', UT2_SLUG )
			),
			'default'  => 'off',
		) );

		if(current_user_can('UT2_administrator')) {
			$this->fields[] = UT2_Helper::field( '_settings_ut_admin_role_hide', 'radio', array(
				'required' => array( 'settings_ut_admin_role', '=', 'on' ),
				'title'    => __( 'Plugin visibility', UT2_SLUG ),
				'options'  => array(
					'' => 'Visible for Administrator',
					'block' => 'Visible only for "Ultimate Tweaker Administrator"',
//					'hidden_url' => 'Hidden, but' . sprintf(__( ' you can open later by this url: %s)', UT2_SLUG ), admin_url('?ut')),
//					'block' => 'Hide & Block access',
				),
				'default'  => '',
//				'desc' => __( 'Ultimate Tweaker always visible for "Ultimate Tweaker Administrator"', UT2_SLUG ),
			) );

			$this->fields[] = UT2_Helper::field( '_settings_ut_admin_role_hide_user', 'radio', array(
				'title'    => __( 'Hide "Ultimate Tweaker Administrator" users', UT2_SLUG ),
				'options'  => array(
					'' => 'Visible',
					'hidden' => 'Hidden',
				),
				'default'  => '',
			) );
		} else {
			$this->fields[] = UT2_Helper::field( '_settings_ut_admin_role_info1', 'info_field', array(
				'required' => array( 'settings_ut_admin_role', '=', 'on' ),
				'title'    => __( 'Plugin visibility', UT2_SLUG ),
				'html' => '<i class=\"redux_field_th\">Available only for Ultimate Tweaker Administrator</i>'
			) );
			$this->fields[] = UT2_Helper::field( '_settings_ut_admin_role_info2', 'info_field', array(
				'title'    => __( 'Hide "Ultimate Tweaker Administrator" users', UT2_SLUG ),
				'html' => '<i class=\"redux_field_th\">Available only for Ultimate Tweaker Administrator</i>'
			) );
		}

		add_filter( "ut/options/tweaks", array($this, '_insertFields') );
	}

	function _insertFields($s) {
		$s['settings_ut_admin_role']['fields'] = $this->fields;
		return $s;
	}

	function tweak() {
		if(!$this->value) $this->value = 'off';
		add_action( 'init', array( &$this, '_init' ), 0);

		if($this->value == 'off') return;
		if(current_user_can('UT2_administrator')) return;

		$settings_ut_admin_role_hide_user = $this->options->_settings_ut_admin_role_hide_user;
		if($settings_ut_admin_role_hide_user == 'hidden') {
			add_filter( 'editable_roles', array( $this, '_exclude_role' ) );

			add_filter( "views_users", array( $this, '_views_users' ) );

			$this->ids = array();
			$user_query = new WP_User_Query( array( 'role' => 'UT2_administrator' ) );
			if ( !empty( $user_query->results ) ) {
				foreach ( $user_query->results as $user ) {
					$this->ids[] = $user->ID;
				}
			}
			if(count($this->ids))
				add_action('pre_user_query', array($this, '_pre_user_query'));
		}

		if($this->options->_settings_ut_admin_role_hide == 'block') {
			add_action('current_screen', array($this, '_doHide'), 50);
		}
	}


	function _views_users($views)
	{
		if (isset($views['UT2_administrator'])) {
			unset($views['UT2_administrator']);
		}

		return $views;
	}
	function _exclude_role($roles)
	{
		if (isset($roles['UT2_administrator'])) {
			unset($roles['UT2_administrator']);
		}

		return $roles;
	}


	function _pre_user_query($user_search) {
		global $wpdb;

		$user_search->query_where = str_replace('WHERE 1=1',
			"WHERE 1=1 AND {$wpdb->users}.id NOT IN(".join(',',$this->ids).")", $user_search->query_where);
	}

	function _doHide(){
		remove_menu_page('ultimate-tweaker');

		add_action( 'load-toplevel_page_ultimate-tweaker', array($this, '_block') );
		add_filter( 'all_plugins', array( $this, '_hidePlugin' ) );


	}

	function _hidePlugin( $plugins  ) {
		unset($plugins['ultimate-tweaker/ultimate-tweaker.php']);

		return $plugins;
	}

	function _block() {
		wp_redirect(admin_url());
		exit;
//		wp_die(__('Cheatin&#8217; uh?'));
	}

	function _init() {
		$roleName = 'UT2_administrator';
		global $wp_roles;
		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();

		if($this->value == 'on') {
			$adm = $wp_roles->get_role($roleName);
			if(!$adm) {
				$adm = $wp_roles->get_role('administrator');
				$adm && $wp_roles->add_role($roleName, __('Ultimate Tweaker Administrator', UT2_SLUG), $adm->capabilities);
			}
		} else {
			$adm = $wp_roles->get_role($roleName);
			if($adm) {
				remove_role( $roleName );
			}
		}
	}
}