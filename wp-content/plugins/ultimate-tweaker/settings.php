<?php
/**
 * Created by Amino-Studio.
 * Url: http://amino-studio.com/
 * License: http://amino-studio.com/license/
 */

if ( ! class_exists( 'UT2_Settings' ) ) {
	class UT2_Settings {
		public $capability = 'manage_options';

		public function __construct() {
			require_once( UT2_PLUGIN_PATH . 'framework/section.php' );
			require_once( UT2_PLUGIN_PATH . 'framework/menu_page.php' );

			require_once( UT2_PLUGIN_PATH . 'role_manager/role_manager.php' );
			$rm = new UT2_Role_Manager('manage_options');

			$menu = new UT2_Framework_MenuPage(UT2_SLUG);
			$menu->menuTitle = UT2_NAME;
			$menu->pageTitle = UT2_NAME;
			$menu->iconURL = plugins_url('assets/icon-20.png', __FILE__);

			$menu->headerLogo = plugins_url( 'assets/logo.png', __FILE__ );
			$menu->headerBackground = plugins_url( 'assets/bg5.jpg', __FILE__ );

			$this->menu = $menu;

			add_action( 'wp_ajax_ut_save', array($this, 'save') );
			add_action( 'admin_menu', array( $this, 'register') );
//			add_action( "load-{$menuHookname}", array( $this->, 'doLoad' ) );

			if( UT2_UPDATER_ID > 0 && !UT2_Helper::$_->IS_DEBUG ) {
				$settings = get_option( UT2_SLUG );
				if ( @$settings['auto_updates_key'] && @$settings['auto_updates_enable'] ) {
					require_once( UT2_PLUGIN_PATH . 'framework/wp-updates-plugin.php' );
					new WPUpdatesPluginUpdater( UT2_UPDATER_ID, 'http://wp-updates.com/api/2/plugin',
						plugin_basename( UT2_Helper::$_->__FILE__ ), @$settings['auto_updates_key'] );
				} else {
					add_action( 'admin_notices', array( $this, 'noticeLicenseActivation' ) );
				}
			}
		}


		public function register() {
			$menu = $this->menu;
			$slug = $menu->getSlug();
			if(!$slug) return;
			if($this->capability && !current_user_can($this->capability)) return;

			$menuHookname = add_menu_page(
				$menu->pageTitle,
				$menu->getTitle(),
				$this->capability,
				$slug,
				array( $this, 'output'),
				$menu->iconURL,
				$menu->position );
//			var_dump($menuHookname);
//			$menuPage->menuHookname = $menuHookname;

			if(
				(isset($_REQUEST['page']) && $_REQUEST['page'] == UT2_SLUG) ||
				(isset($_REQUEST['action']) && strrpos($_REQUEST['action'], 'ut_', -strlen($_REQUEST['action'])) !== false)
			) {
				$this->prepareData();
			}

			add_action( "load-{$menuHookname}", array( $this, 'doLoad' ) );
			return $menuHookname;
		}

		function save() {
			if ( !isset($_POST['_wpnonce']) || !wp_verify_nonce( $_POST['_wpnonce'], UT2_SLUG . UT2_VERSION ) ) wp_die('No access');
			if ( !current_user_can( 'manage_options' ) ) wp_die('No access');

			$data = json_decode(stripslashes($_POST['data']), true);

			foreach($data as $role_ID=>$value) {
				update_option( UT2_OPTION . ($role_ID? '_' . $role_ID : ''), $value);
			}
			//update_option(UT2_SLUG, $data);

			echo json_encode($data);
			exit;
		}

		public function doLoad() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueueCssScripts' ) );
			add_filter( 'admin_body_class', array( $this, 'addBodyClass' ) );
			remove_all_filters('admin_footer_text');
			add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ) );
		}


		public function enqueueCssScripts() {
			wp_enqueue_media();
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'underscore' );
			wp_enqueue_script( 'backbone' );
			wp_enqueue_style( 'wp-color-picker' );

			UT2_Helper::$_->script( 'framework/assets/select2/select2', __FILE__ );
			UT2_Helper::$_->style( 'framework/assets/select2/select2', __FILE__ );//-352

			$googleFontsUrl = 'http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic';
			wp_enqueue_style( 'wpas_googlefont', $googleFontsUrl, array(), UT2_VERSION );
			wp_enqueue_style( UT2_SLUG, UT2_PLUGIN_URL . 'framework/assets/app.css', array(), UT2_VERSION );
		}

		public function enqueueScripts() {
			UT2_Helper::$_->script( 'framework/assets/app', __FILE__, array(
				'handle' => UT2_SLUG,
				'deps' => array(
					'jquery',
					'underscore',
					'backbone',
					'wp-color-picker'
				)
			) );
		}

		function prepareData() {
			$menu = $this->menu;

			require_once( UT2_PLUGIN_PATH . 'meta.php' );

			$sections = UT2_Data::getSections();
			$i = 0;
			foreach($sections as $section_ID => $tweaks) {
				$sectionMeta = UT2_Meta::getSectionMeta($section_ID);
				$tweakMeta = UT2_Meta::getTweaksMeta();
				if(!$sectionMeta) continue;
//				if($role && @$sectionMeta->visibility != 'all_roles') continue;

				$section = $menu->addSection( $section_ID );
				$section->visibility = isset($sectionMeta->visibility) ? $sectionMeta->visibility : null;
				$section->icon = isset($sectionMeta->icon) ? $sectionMeta->icon : null;
				$section->icon_type = isset($sectionMeta->icon_type)? $sectionMeta->icon_type : null;
				$section->title = $sectionMeta->title;
				$section->id = isset($sectionMeta->id) ? $sectionMeta->id : null;
				$section->parent_id =  isset($sectionMeta->parent_id) ? $sectionMeta->parent_id : 0;

				foreach($tweaks as $tweak_ID => $applyPlace) {
					if(is_array($applyPlace)) {
						continue;
					}
					require_once( UT2_PLUGIN_PATH . "sections/{$section_ID}/{$tweak_ID}/tweak.php" );
					$tweakCls = "UT2_{$tweak_ID}_Tweak";
					$tweak = new $tweakCls();
					$i++;
					if(method_exists($tweak, 'isVisible') && !$tweak->isVisible()) continue;

					$section->addTweak($tweak_ID);

					$tweakFields = $tweak->settings();
					if($tweakFields == null) {
					} else if( isset($tweakFields['id']) ) {
						$tweakFields = $this->prepareField($tweakFields);
						$menu->addTweakFields( $tweak_ID, array($tweakFields) );
					} else {
						foreach($tweakFields as &$tweakField) {
							$tweakField = $this->prepareField($tweakField);
						}
						$menu->addTweakFields( $tweak_ID, $tweakFields );
					}

					if(isset($tweakMeta[$tweak_ID])) {//
						if(!isset($menu->_tweak_fields[ $tweak_ID ])) $menu->_tweak_fields[ $tweak_ID ] = array();
						$menu->_tweak_fields[ $tweak_ID ] = array_merge($menu->_tweak_fields[ $tweak_ID ], $tweakMeta[$tweak_ID]);
					}

				}
			}
		}

		function doData() {
			$this->menu->_tweak_fields = apply_filters("ut/options/tweaks", $this->menu->_tweak_fields);
//
			$data = array(
				'debug'        => WP_DEBUG,
				'nonce'        => wp_create_nonce( UT2_SLUG . UT2_VERSION ),
				'roles'        => $this->getAvailableRoles(),
				'sections'     => $this->menu->_sections,
				'values'       => $this->readValues(),
				'tweaks'       => $this->menu->_tweak_fields,
				'tweak_groups' => UT2_Meta::getTweakGroupsMeta(),
			);

			wp_localize_script( UT2_SLUG, 'UT', $data);
		}

		function prepareField($field) {
			if( $field['type'] == 'select' ) {
				if(isset($field['data'])) {
					$data  = array();
					if($field['data'] == 'pages') {
						$pages = get_pages();

						if ( ! empty( $pages ) ) {
							foreach ( $pages as $page ) {
								$data[ $page->ID ] = $page->post_title;
							}
						}
						$field['default'] = '6';
					} else if($field['data'] == 'menus') {
						$menus = wp_get_nav_menus();
						if ( ! empty( $menus ) ) {
							foreach ( $menus as $item ) {
								$data[ $item->term_id ] = $item->name;
							}
						}
					} else if($field['data'] == 'categories') {
						$cats = get_categories();
						if ( ! empty( $cats ) ) {
							foreach ( $cats as $cat ) {
								$data[ $cat->term_id ] = $cat->name;
							}
						}
					} else if($field['data'] == 'tags') {
						$tags = get_tags();
						if ( ! empty( $tags ) ) {
							foreach ( $tags as $tag ) {
								$data[ $tag->term_id ] = $tag->name;
							}
						}
					} else {
//						var_dump( $field );
					}
					$field['options'] = $data;
				}
			}
			return $field;
		}

		public function readValues() {
			$values = array();
			foreach($this->getAvailableRoles() as $data) {
				$role = $data['id'];
				$values[$role] = get_option( UT2_OPTION . ($role ? '_'.$role:'') );
			}
			return $values;
//			return get_option( UT2_SLUG );
		}

		public function getAvailableRoles() {
			$roles = array(
				array( 'id' => '', 'name' => __('All roles and visitors', UT2_SLUG)),
				array( 'id' => 'all_visitors', 'name' => __('All visitors', UT2_SLUG))
			);

			global $wp_roles;
			if ( ! isset( $wp_roles ) ) {
				$wp_roles = new WP_Roles();
			}

			foreach($wp_roles->get_names() as $role=>$role_name) {
				$roles[] = array(
					'id' => $role,
					'name' => sprintf( __("Only for %ss", UT2_SLUG), $role_name)
				);
			}

			return $roles;
		}

		public function addBodyClass( $classes ) {
			return $classes . ' wpas wpas-' . $this->menu->getSlug() .' ';
		}

		public function admin_footer_text() {
			return 'Made with love' . '<div style="display: inline-block;margin: 0px 7px;color:#e74c3c;">♥</div>' .
			       ' by Amino-Studio. Version is '
			       . UT2_VERSION . '.';
		}

		public function output() {
			$this->enqueueScripts();
			$this->doData();

			$headerBody = $headerStyles = '';
			$this->menu->headerLogo && $headerBody .= sprintf('<img src="%s" />', $this->menu->headerLogo);
			$this->menu->headerBackground && $headerStyles .= sprintf('background-image:url(%s);', $this->menu->headerBackground);
			?>
			<div id="wpas_panel">
			<noscript><div class="no-js"><?php echo __( 'Warning: This options panel will not work properly without JavaScript, please enable it.', UT2_SLUG ); ?></div></noscript>
			<div class="wpas_header" style="<?php echo $headerStyles; ?>">
				<?php echo $headerBody; ?>
				<div class="wpas_toolbar">
					<a class="wpas_button ut_button_importexport">Import/Export</a>
					<a class="wpas_button ut_button_support">Support</a>
					<!--					<a class="wpas_button">Settings</a>-->
					<!--					<a class="wpas_button">Activate your copy</a>-->
				</div>
			</div>
			<div class="wpas_top">
				<select class="ut_role_selection"></select>
				<a class="ut_role_manager_a" href="javascript:void(0)" style="margin-left: 10px;vertical-align: middle;">Role Manager</a>
			</div>
			<div class="wpas_container">
				<div class="wpas_aside">
					<div class="wpas_sections">
						<!--						<a class="wpas_section" href="#general">Dashboard</a>-->
						<!--						<h5>TOOLS</h5>-->
						<!--						<a class="wpas_section" href="#general">General</a>-->
						<!--						<a class="wpas_section" href="#general">General</a>-->
						<h5>TWEAKS</h5>
						<ul></ul>
					</div>
				</div>
				<div class="wpas_body">
				</div>
			</div>
			<div class="wpas_bottom">
				<a class="wpas_button wpas_button_resetall">Reset All</a>
				<a class="wpas_button wpas_button_reset">Reset Section</a>
				<a class="wpas_button wpas_button_primary wpas_button_save"><span class="save_changes">Save Changes</span><span class="saving">Saving...</span></a>
				<div class="wpas_autosave"><label for="autosave_on"><input id="autosave_on" type="checkbox"> Auto Save (NEW)</label></div>
			</div>
			</div><?php
		}

		public function noticeLicenseActivation() {
			echo '<div class="updated activation-notice"><p>' .
			     sprintf( __( 'Please <a href="%s">activate your copy</a> of %s to receive automatic updates.', UT2_SLUG ),
				     admin_url( 'admin.php?page=' . UT2_SLUG . '#activation' ), UT2_NAME ) . '</p></div>';
		}
	}
}