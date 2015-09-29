<?php

class UT2_admin_menu_hide_Tweak {
	function settings( ) {
		if(did_action('admin_menu')) {
			$this->_init();
		} else {
			add_action( 'admin_menu', array( &$this, '_init' ), 999 );
		}
	}


	function read() {
		static $cache;
		if($cache) return $cache;

		$menu_els = array();

		global $menu;
		global $submenu;

		$menu_els = array();
		$currentRole = UT2_Helper::getRequestRole();
		$role = get_role( $currentRole );

		foreach($menu as $m) {
			if(isset($m[5]) && $m[5] == 'menu-users' && $role && !isset($role->capabilities['list_users'])) { // fix profile
				$m = array( __('Profile'), 'read', 'profile.php', '', 'menu-top menu-icon-users', 'menu-users', 'dashicons-admin-users' );
			}
			if($role && !isset($role->capabilities[$m[1]])) continue;
			$name = $m[0] ? $m[0] : $m[2];
			if($m[2] == 'ultimate-tweaker') continue;
			if($m[2] == 'edit-comments.php') $name = 'Comments';
			if($m[2] == 'plugins.php') $name = 'Plugins';
			$name = strip_tags($name);
			if(strrpos($m[2], 'separator', -strlen($m[2])) !== FALSE) $name = '<i style="color:gray;">&mdash; separator &mdash;</i>';

			$menu_els[$m[2]] = $name;

			if(isset($submenu[$m[2]])) {
				foreach($submenu[$m[2]] as $sm) {
					if($role && !isset($role->capabilities[$sm[1]])) continue;
					$submenu_name      = $sm[0] ? $sm[0] : $sm[2];
					if($sm[2] == $m[2]) continue;
					$menu_els[ htmlspecialchars_decode('_' . $sm[2]) ] = '<span style="margin: 0px 5px;float:left;">↳</span><span style="">' . $submenu_name . '</span>';
				}
			}
		}

		$cache = $menu_els;

		return $menu_els;
	}


	function _init( ) {
		$menu_els = $this->read();
		//var_dump($menu_els);

		$this->fields = UT2_Helper::field( 'admin_menu_hide', 'checkbox', array(
			'title'    => __( 'Hide menu elements', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'options'  => $menu_els,
			'default'  => ''
		) );

		add_filter( "ut/options/tweaks", array($this, '_insertFields') );
//		add_filter( "redux/options/".UT2_Helper::getCurrentOptName()."/section/".'admin_menu', array($this, '_insertFields') );
	}

	function _insertFields($s) {
		$s['admin_menu_hide']['fields'][] = $this->fields;
		return $s;
	}

	function tweak() {
		add_action('admin_menu', array($this, '_do'), 1000);
	}

	function _do() {
		if(!is_array($this->value)) return;

		$this->read();

		foreach($this->value as $id=>$v) {
			if(!$v) continue;

			$id = htmlspecialchars($id);

			if($id[0] === '_') {
				$id = ltrim($id, '_');
				global $submenu;
				foreach($submenu as $menu => $sm) {
					foreach($sm as $sm_el) {
						if($sm_el[2] === $id) {
							remove_submenu_page($menu, $id);
//							break;
						}
					}
				}
			} else {
				remove_menu_page( $id );
			}
		}
	}
}