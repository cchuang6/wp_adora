<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


if ( ! class_exists( 'UT2_stdSettings' ) ) {
	class UT2_stdSettings {
		function __construct($data) {
			$this->data = $data;
		}
		function __get($key) {
			return isset($this->data[$key]) ? $this->data[$key] : null;
		}
		function __isset($key) {
			return isset($this->data[$key]);
		}
	}
}

if ( ! class_exists( 'UT2_BlockUserCap' ) ) {
	class UT2_BlockUserCap {
		function __construct( $cap ) {
			$this->cap = $cap;
		}

		function _cap( $allcaps, $cap, $args ) {
			if ( $this->cap == $args[0] ) {
				$allcaps[ $this->cap ] = false;
			}

			return $allcaps;
		}
	}
}

if ( ! class_exists( 'UT2_Helper' ) ) {
	class UT2_Helper {
		/**
		 * @var UT2_Helper
		 */
		static $_;

		static function getCurrentOptName() {
			return UT2_SLUG . UT2_Helper::getRequestRole('_');
		}
//		static function resetAllSettings( $role = null ) {
//			$settings = $role ? array() : array(UT2_SLUG);
//			foreach(self::getRolesNames() as $roleName=>$s) {
//				if($role && $role != $roleName) continue;
//				$settings[] = UT2_SLUG . '_' . $roleName;
//			}
//
//			foreach($settings as $setting) {
//				delete_option( $setting );
//				delete_option( $setting . '-transients' );
//				unset( $_REQUEST[$setting] );
//				unset( $_POST[$setting] );
//			}
//		}
		static function id( $prefix = '_' ) {
			static $id;

			return $prefix . ++ $id;
		}

		static function blockUserCap( $cap ) {
			$blocker = new UT2_BlockUserCap($cap);
			add_filter( 'user_has_cap', array($blocker, '_cap'), 0, 3 );
		}

		static function getUserRole() {
			global $current_user;

			$user_roles = $current_user->roles;
			$user_role = array_shift($user_roles);

			return $user_role;
		}

		static function getRolesNames() {
			global $wp_roles;

			if ( ! isset( $wp_roles ) )
				$wp_roles = new WP_Roles();

			return $wp_roles->get_names();
		}

		static function getRequestRole( $suffix = '' ) {
			return ( isset( $_REQUEST['role'] ) && ! empty( $_REQUEST['role'] ) ) ? $suffix.$_REQUEST['role'] : '';
		}

		static function field($id, $type, $args = null) {
			if(!$args) {
				$args = $type;
				$type = $id;
				$id = rand();
			}
			$args['id'] = $id;
			$args['type'] = $type;
//			!isset($args['default']) && $args['default'] = '';

//			if(isset($args['right_title']) && !empty($args['right_title'])) {
//				$args['title'] = sprintf('<span style="float: right;">%s</span>', $args['right_title']);
//				unset($args['right_title']);
//			}

			if(empty($args['default'])) unset($args['default']);

			return $args;
		}

		static function switcher($key, $data) {
			return self::field( $key, 'switch', array_merge(array(
				'default'  => 0,
				'on'       => __( 'Yes', UT2_SLUG ),
				'off'      => __( 'No', UT2_SLUG )
			), $data) );
		}

		var $__FILE__;
		var $USE_MIN;

		function __construct( $__FILE__, $IS_DEBUG, $USE_MIN ) {
			$this->__FILE__     = $__FILE__;
			$this->IS_DEBUG     = $IS_DEBUG;
			$this->USE_MIN      = $USE_MIN;

			$this->addAction( array( 'wp_enqueue_scripts', 'admin_enqueue_scripts' ),
				array( $this, 'enqueueScriptsOn' ) );
		}

		/**
		 * @param     $tag
		 * @param     $function_to_add
		 * @param int $priority
		 * @param int $accepted_args
		 *
		 * @return bool|null
		 *
		 * Alias for array support
		 */
		function addAction( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
			if ( is_array( $tag ) ) {
				$l = null;
				foreach ( $tag as $t ) {
					$l = add_action( $t, $function_to_add, $priority, $accepted_args );
				}

				return $l;
			}

			return add_action( $tag, $function_to_add, $priority, $accepted_args );
		}

		var $_enqueueOn = false;
		var $_enqueueStyleQueue = array();
		var $_enqueueScriptQueue = array();
		var $_enqueueInlineStyleQueue = array();
		var $_enqueueLocalizeScriptQueue = array();

		function enqueueScriptsOn() {
			$this->_enqueueOn = true;

			if ( count( $this->_enqueueStyleQueue ) ) {
				foreach ( $this->_enqueueStyleQueue as $params ) {
					call_user_func_array( array( $this, 'proxyWpEnqueueStyle' ), $params );
				}
				$this->_enqueueStyleQueue = array();
			}
			if ( count( $this->_enqueueInlineStyleQueue ) ) {
				foreach ( $this->_enqueueInlineStyleQueue as $params ) {
					call_user_func_array( array( $this, 'proxyWpAddInlineStyle' ), $params );
				}
				$this->_enqueueInlineStyleQueue = array();
			}
			if ( count( $this->_enqueueScriptQueue ) ) {
				foreach ( $this->_enqueueScriptQueue as $params ) {
					call_user_func_array( array( $this, 'proxyWpEnqueueScript' ), $params );
				}
				$this->_enqueueScriptQueue = array();
			}
			if ( count( $this->_enqueueLocalizeScriptQueue ) ) {
				foreach ( $this->_enqueueLocalizeScriptQueue as $params ) {
					call_user_func_array( array( $this, 'proxyWpLocalizeScript' ), $params );
				}
				$this->_enqueueLocalizeScriptQueue = array();
			}
		}

		function proxyWpEnqueueStyle( $handle, $src = false, $deps = array(), $ver = false, $media = 'all' ) {
			if ( ! $this->_enqueueOn ) {
				$this->_enqueueStyleQueue[] = func_get_args();

				return;
			}

			wp_enqueue_style( $handle, $src, $deps, $ver, $media );
		}

		function proxyWpEnqueueScript( $handle, $src = false, $deps = array(), $ver = false, $in_footer = false ) {
			if ( ! $this->_enqueueOn ) {
				$this->_enqueueScriptQueue[] = func_get_args();

				return;
			}

			wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
		}

		function proxyWpLocalizeScript( $handle, $object_name, $l10n ) {
			if ( ! $this->_enqueueOn ) {
				$this->_enqueueLocalizeScriptQueue[] = func_get_args();

				return;
			}

			wp_localize_script( $handle, $object_name, $l10n );
		}

		function proxyWpAddInlineStyle( $handle, $data ) {
			if ( ! $this->_enqueueOn ) {
				$this->_enqueueInlineStyleQueue[] = func_get_args();

				return;
			}

			wp_add_inline_style( $handle, $data );
		}

		function style( $file, $__FILE__ = null, $options = array() ) {
			if ( $__FILE__ === null ) {
				$__FILE__ = $this->__FILE__;
			}

			$deps     = isset( $options['deps'] ) ? $options['deps'] : array();
			$min      = isset( $options['force_min'] ) ? $options['force_min'] : $this->USE_MIN;
			$handle   = isset( $options['handle'] ) ? $options['handle'] : md5($file . $__FILE__);
			$fileName = $file . ( $min ? '.min' : '' ) . '.css';
			//http://stackoverflow.com/questions/959957/php-short-hash-like-url-shortening-websites

			$this->proxyWpEnqueueStyle( $handle, plugins_url( $fileName, $__FILE__ ), $deps, UT2_VERSION );

			return $handle;
		}

		function script( $file, $__FILE__ = null, $options = array() ) {
			if ( $__FILE__ === null ) {
				$__FILE__ = $this->__FILE__;
			}

			$deps      = isset( $options['deps'] ) ? $options['deps'] : array();
			$in_footer = isset( $options['in_footer'] ) ? $options['in_footer'] : false;
			$handle    = isset( $options['handle'] ) ? $options['handle'] : md5($file . $__FILE__);
			$min       = isset( $options['force_min'] ) ? $options['force_min'] : $this->USE_MIN;

			$fileName = $file . ( $min ? '.min' : '' ) . '.js';

			$this->proxyWpEnqueueScript( $handle, plugins_url( $fileName, $__FILE__ ), $deps, UT2_VERSION, $in_footer );

			return $handle;
		}

		function localize_script( $handle, $object_name, $l10n ) {
			$this->proxyWpLocalizeScript( $handle, $object_name, $l10n );
		}

		function inlineStyle( $rule, $styles, $handle = 'root' ) {
//			$st = $this->getDom()->__arrayToHTMLStyles( $styles );
//			if ( ! $st ) {
//				return '';
//			}
//
			$css = sprintf( '%s { %s }', $rule, $styles );
//
			$this->proxyWpAddInlineStyle( $handle, $css );

//			return $css;
		}

		function styles( $files, $__FILE__, $options = array() ) {
			$hls = array();

			foreach ( $files as $file ) {
				$hls[] = $this->style( $file, $__FILE__, $options );
			}

			return $hls;
		}

		function scripts( $files, $__FILE__, $options = array() ) {
			$hls = array();

			foreach ( $files as $file ) {
				$hls[] = $this->script( $file, $__FILE__, $options );
			}

			return $hls;
		}
	}
}