<?php
/**
 * Created by Amino-Studio.
 * Url: http://amino-studio.com/
 * License: http://amino-studio.com/license/
 */

if(!class_exists('UT2_Role_Manager')) {
	class UT2_Role_Manager {
		var $permission;

		function __construct($permission) {
			$this->permission = $permission;

//			$this->init();
			add_action('init', array($this, 'init'));
		}

		function init() {
			if(!current_user_can($this->permission)) return;

			add_action( 'wp_ajax_ut_rm_get', array($this, 'ajaxGet') );
			add_action( 'wp_ajax_ut_rm_save', array($this, 'ajaxSave') );

			$handle = UT2_Helper::$_->script( 'script', __FILE__, array('force_min' => false) );
			UT2_Helper::$_->localize_script( $handle, 'roleManagerConfig', array(
				'title'              => __( 'Role Manager', UT2_SLUG ),
				'loading'            => __( 'Loading...', UT2_SLUG ),
				'saving'             => __( 'Saving...', UT2_SLUG ),
				'deleteConfirmation' => __( 'Do you really want to delete?', UT2_SLUG ),
				'newRoleNameConfirmation' => __( 'Enter new role name:', UT2_SLUG ),
				'createRole'         => __( 'Create new role...', UT2_SLUG ),
				'createRoleTitle'    => __( 'New role creating', UT2_SLUG ),
				'create'             => __( 'Create', UT2_SLUG ),
				'save'               => __( 'Save', UT2_SLUG ),
				'cancel'             => __( 'Cancel', UT2_SLUG ),

				'form_allRequired'    => __( 'All form fields are required.', UT2_SLUG ),
				'form_ID'             => __( 'ID', UT2_SLUG ),
				'form_Name'             => __( 'Name', UT2_SLUG ),
				'form_checkLengthMessage' => __( 'Length of %s must be between %s and %s.', UT2_SLUG ),
				'form_checkRoleIDExistsMessage' => __( 'ID already exists.', UT2_SLUG ),
				'form_checkRoleNameExistsMessage' => __( 'Name already exists.', UT2_SLUG ),
				'form_checkRoleIDRegExpMessage' => __( 'Role ID may consist of a-z, 0-9, underscores, spaces and must begin with a letter.', UT2_SLUG ),


				'nonce'              => wp_create_nonce( 'roleManager' )
			) );

			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_style("wp-jquery-ui-dialog");
		}

		private function _getRoles() {
			global $wp_roles;
			if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();

//			$editable_roles = apply_filters('editable_roles', $wp_roles->roles);
			return $wp_roles->roles;
		}
		private function _getDeprecatedCapabilities() {
			$caps = array(
				'level_0'    => 0,
				'level_1'    => 0,
				'level_2'    => 0,
				'level_3'    => 0,
				'level_4'    => 0,
				'level_5'    => 0,
				'level_6'    => 0,
				'level_7'    => 0,
				'level_8'    => 0,
				'level_9'    => 0,
				'level_10'   => 0,
				'edit_files' => 0
			);

			//$caps['unfiltered_html'] = 0; for Multi site

			return $caps;
		}

		function ajaxGet() {
			if(!current_user_can($this->permission)) return;
			check_ajax_referer( 'roleManager' );

			wp_send_json( array(
				'roles'                   => $this->_getRoles(),
				'deprecated_capabilities' => $this->_getDeprecatedCapabilities(),
			) );
			exit;
		}

		function ajaxSave() {
			if(!current_user_can($this->permission)) return;
			check_ajax_referer( 'roleManager' );
			if(!isset($_POST['data']) || !is_array($_POST['data'])) return;
			$data = $_POST['data'];

			global $wp_roles;
			if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();

			foreach($data as $roleId => $roleMeta) {
				if ( isset( $wp_roles->roles[$roleId] ) && $roleMeta['name'] && $roleMeta['name'] !== $wp_roles->roles[$roleId]['name'] && !empty($roleMeta['name']) ) {
					$display_name = $roleMeta['name'];
					$wp_roles->roles[$roleId]['name'] = $display_name;
					update_option( $wp_roles->role_key, $wp_roles->roles );
					$wp_roles->role_names[$roleId] = $display_name;
				}

				if($roleId == 'administrator') continue;
				if(isset($roleMeta['isDeleted']) && $roleMeta['isDeleted'] && $roleId != 'administrator') {
					remove_role( $roleId );
					continue;
				}

//				if($roleId != 'editor') continue; // DEMO TEST
				$role = get_role($roleId);

				if(!$role) {//create role
					if(isset($roleMeta['isCreated']) && !$roleMeta['isCreated']) continue;
					$newRoleCaps = array();
					if(isset($roleMeta['capabilities']) && is_array($roleMeta['capabilities'])) {
						foreach($roleMeta['capabilities'] as $capabilityId => $enabled) {
							if(filter_var($enabled, FILTER_VALIDATE_BOOLEAN))
								$newRoleCaps[$capabilityId] = true;
						}
					}
					$result = add_role(
						$roleId,
						$roleMeta['name'],
						count($newRoleCaps) ? $newRoleCaps : null
					);
					continue;
				}


//				if($roleMeta['name'] != $role->name)
//					var_dump($roleMeta['name'], $role->name);

				foreach($roleMeta['capabilities'] as $capabilityId => $enabled) {
					if($capabilityId == 'manage_options' && ($roleId == 'administrator' || $roleId == 'ut_administrator')) {
						continue;
					}

					$enabled = filter_var($enabled, FILTER_VALIDATE_BOOLEAN);
					if(!$enabled && $role->has_cap($capabilityId)) $role->remove_cap($capabilityId);
					if($enabled && !$role->has_cap($capabilityId)) $role->add_cap($capabilityId);
				}
//				var_dump($role);
			}

			wp_send_json(array(
				'success' => true
			));
			exit;
		}
	}
}
