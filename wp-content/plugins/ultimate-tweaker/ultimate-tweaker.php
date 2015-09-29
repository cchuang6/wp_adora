<?php
/*
Plugin Name: Ultimate Tweaker
Plugin URI: http://amino-studio.com/ultimate-tweaker/
Description:
Version: 1.3.6
Text Domain: ultimate-tweaker
Author: Amino-Studio <support@amino-studio.com>
Author URI: http://amino-studio.com/
License: http://amino-studio.com/license/
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if(isset($_REQUEST['ut_off']) && $_REQUEST['ut_off'] == md5(AUTH_KEY)) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	deactivate_plugins( plugin_basename( __FILE__ ) );
	die( 'Ultimate Tweaker deactivated. Write to support@amino-studio.com. Thank you!' );
}

define( 'UT2_NAME',          'Ultimate Tweaker' );
define( 'UT2_VERSION',       '1.3.6' );
define( 'UT2_SLUG',          'ultimate-tweaker' );
define( 'UT2_OPTION',        'ultimate-tweaker' );
define( 'UT2_PLUGIN_PATH',   plugin_dir_path( __FILE__ ) );
define( 'UT2_PLUGIN_URL',    plugin_dir_url( __FILE__ ) );
define( 'UT2_UPDATER_ID',    898 );

if ( ! class_exists( 'ultimate_tweaker2_Plugin_File' ) ) {
	class ultimate_tweaker2_Plugin_File {
		var $IS_ADMIN;
		var $debugMessagesEnabled = false;
		var $debugMessages = null;

		function __construct() {
			// Admin tweak notice - refresh

			require_once( UT2_PLUGIN_PATH . 'framework/helper.php' );
			require_once( UT2_PLUGIN_PATH . 'data.php' );

			$USE_MIN  = isset( $_REQUEST['nomin'] ) ? false : true;
			$IS_DEBUG = defined( 'WP_DEBUG' ) && WP_DEBUG == true;//defined( 'WP_ENV' ) && WP_ENV === 'development';
			if($IS_DEBUG) $USE_MIN = false;
//			$USE_MIN = false;
			register_activation_hook( __FILE__, array ( $this, 'onActivate') );
			register_deactivation_hook( __FILE__, array ( $this, 'onDeactivate') );

			UT2_Helper::$_ = new UT2_Helper( __FILE__, $IS_DEBUG, $USE_MIN );

			$this->IS_ADMIN = is_admin();

			add_action('plugins_loaded', array($this, 'loadTweaks'), 0);

			if($this->IS_ADMIN) {
				$settings = get_option( UT2_OPTION );
				if ( $settings && isset( $settings['settings_enable_key'] ) && $settings['settings_enable_key'] ) {
					if (
						isset( $_REQUEST['ut'] ) ||
						(isset( $_REQUEST['action'] ) && strrpos($_REQUEST['action'], 'ut_', -strlen($_REQUEST['action'])) !== FALSE) ||
						(isset( $_REQUEST['page'] ) && $_REQUEST['page'] == UT2_SLUG) ) {
						add_action( 'plugins_loaded', array( $this, 'initializeAdmin' ), 0 );
					}
				} else {
					add_action( 'plugins_loaded', array( $this, 'initializeAdmin' ), 0 );
				}
			}

			isset($_REQUEST['ut_debug']) && $this->enableDebugMessaging();
		}

		function onActivate() {
			flush_rewrite_rules();
		}

		function onDeactivate() {
			flush_rewrite_rules();
		}

		function enableDebugMessaging() {
			$this->debugMessagesEnabled = true;
			$this->debugMessages = array();
			add_action('wp_head', array($this, 'outputDebugMessages'), 0);
			add_action('admin_head', array($this, 'outputDebugMessages'), 0);
		}

		function outputDebugMessages() {
			foreach($this->debugMessages as $data) {
//				$v = $data['value'];
//				if(is_array($v)) $v = json_encode($v);"
				//jQuery.parseJSON("'.esc_attr(json_encode($v)).')".replace(/&quot;/ig,\'"\')
				echo '<script>console.log("'.esc_attr($data['role']).'", "'.esc_attr($data['id']).'");</script>';
			}
		}

		function loadTweaks() {
			if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'ut_save') return;

			$this->runTweaks();
			is_user_logged_in() && $this->runTweaks(UT2_Helper::getUserRole());
			!is_user_logged_in() && $this->runTweaks('all_visitors');

			if($this->IS_ADMIN) {
				add_action( 'admin_enqueue_scripts', array( $this, 'tweakCommonScripts') );
			}
		}

		function tweakCommonScripts() {
			wp_register_script('mousetrap', plugins_url('assets/vendor/mousetrap-with-global.custom.min.js', __FILE__), array(), UT2_VERSION);
			wp_register_style('admin_appearance', plugins_url('assets/admin_appearance/style.css', __FILE__), array(), UT2_VERSION);
		}

		function runTweaks($role = null) {
			$settings       = get_option( UT2_OPTION . ($role ? '_' . $role : '') );

			if(!$settings || !is_array($settings)) return;
			$settingsStd    = new UT2_stdSettings($settings);
			$sections       = UT2_Data::getSections();

			if(!$role && $settingsStd->settings_ut_user && is_array($settingsStd->settings_ut_user) && is_user_logged_in()) {
				if(in_array(get_current_user_id(), $settingsStd->settings_ut_user)) {
					return;
				}
			}

			foreach($sections as $section_ID => $tweaks) {
				foreach($tweaks as $tweak_ID => $applyPlace) {
					if(!is_string($applyPlace)) continue;
					if(($applyPlace == 'front' && $this->IS_ADMIN)
					   || ($applyPlace == 'admin' && !$this->IS_ADMIN)
					   || !isset($settings[$tweak_ID])
					   || empty($settings[$tweak_ID])
					   || !$settings[$tweak_ID]) continue;

					// media fix
					if(is_array($settings[$tweak_ID]) && isset($settings[$tweak_ID]['id']) && isset($settings[$tweak_ID]['url']) && empty($settings[$tweak_ID]['id']) && empty($settings[$tweak_ID]['url'])) continue;
					// checkboxes fix
//					if(is_array($settings[$tweak_ID]) && !isset($settings[$tweak_ID]['id'])) {
//						$tmparr = array_unique(array_values($settings[$tweak_ID]));
//						if(!in_array(1 ,$tmparr)) continue;
//					}

					require_once( UT2_PLUGIN_PATH . "sections/{$section_ID}/{$tweak_ID}/tweak.php" );
					$tweakCls = "UT2_{$tweak_ID}_Tweak";
					$tweak = new $tweakCls();
					$tweak->options = &$settingsStd;
					$tweak->value = &$settings[$tweak_ID];

					if($this->debugMessagesEnabled) {
						$this->debugMessages[] = array( 'role'=> $role, 'id' => $tweak_ID, 'value' => $tweak->value );
					}

					$tweak->tweak();
				}
			}
		}

		function initializeAdmin() {
			require_once( UT2_PLUGIN_PATH . 'settings.php' );

//			add_action('admin_init', array($this, 'rewriteInit'));

			new UT2_Settings();
		}

//		function rewriteInit() {
//			$path = get_home_path();
//			$htaccess = $path . '.htaccess';
//			$htaccessBackup = $path . '.htaccess.' . substr(md5(AUTH_KEY), 0, 10) . '.ut_backup';
//			if ( !file_exists($htaccessBackup) && is_writable($path) && file_exists($htaccess) ){ // write backup
//				file_put_contents($htaccessBackup, file_get_contents($htaccess));
//			}

//			if ((!file_exists($htaccess) && is_writable($path)) || (file_exists($htaccess) && is_writable($htaccess))){
//				writable
//			} else {
//				 not writable
//			}


//		}
	}
}

new ultimate_tweaker2_Plugin_File();