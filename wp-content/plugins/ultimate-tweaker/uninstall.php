<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

define( 'UT_SLUG',          'ultimate-tweaker' );

class UT_Uninstaller {
	static function getRolesNames() {
		global $wp_roles;

		if ( ! isset( $wp_roles ) )
			$wp_roles = new WP_Roles();

		return $wp_roles->get_names();
	}

	static function resetAllSettings() {
		$settings = array(UT_SLUG);
		foreach(self::getRolesNames() as $roleName=>$s) {
			$settings[] = UT_SLUG . '_' . $roleName;
		}

		foreach($settings as $setting) {
			delete_option( $setting );
			delete_option( $setting . '-transients' );
		}
	}
}

UT_Uninstaller::resetAllSettings();