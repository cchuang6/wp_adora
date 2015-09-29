<?php

if ( !class_exists( 'UT2_Meta' ) ) {
	class UT2_Meta {
		static function getTweakGroupsMeta() {
			return array(
				'diagnostics' => array(
					'title' => __('Diagnostics', UT2_SLUG)
				),
				'email' => array(
					'title' => __('Email', UT2_SLUG)
				),

				'appearance' => array(
					'title' => __('Appearance', UT2_SLUG)
				),
				'admin_bar' => array(
					'title' => __('Admin Bar', UT2_SLUG)
				),
				'custom_widget_with_text' => array(
					'title' => __('Custom Widget with text', UT2_SLUG)
				),

				'apple_devices_logos' => array(
					'title' => __('Apple Devices Logos', UT2_SLUG)
				),
				'windows_pinned_site' => array(
					'title' => __('Windows Pinned site', UT2_SLUG)
				),
				'public_attachment_page' => array(
					'title' => __('Public Attachment Page', UT2_SLUG)
				),

				'remove_buttons' => array(
					'title' => __('Remove Buttons', UT2_SLUG)
				),
				'additional' => array(
					'title' => __('Additional', UT2_SLUG)
				),
				'registration' => array(
					'title' => __('Registration', UT2_SLUG)
				),
				'deactivation_hook' => array(
					'title' => __('Deactivation Hook', UT2_SLUG)
				),
				'hide_metaboxes' => array(
					'title' => __('Hide Meta Boxes', UT2_SLUG)
				),
				'heartbeat' => array(
					'title' => __('Heartbeat', UT2_SLUG)
				),
				'colors' => array(
					'title' => __('Colors', UT2_SLUG)
				),
				'background' => array(
					'title' => __('Background', UT2_SLUG)
				),
				'default' => array(
					'title' => __('Defaults', UT2_SLUG)
				),
				'ultimate_tweaker_administrator' => array(
					'title' => __('Ultimate Tweaker Administrator', UT2_SLUG)
				),
			);
		}

		static function getTweaksMeta() {
			return array(
				'general_generation_time' => array(
					'group' => 'diagnostics'
				),
				'admin_appearance_bg_color' => array(
					'group' => 'background'
				),
				'admin_appearance_bg' => array(
					'group' => 'background'
				),
				'general_email_from' => array(
					'group' => 'email'
				),
				'general_email_from_name' => array(
					'group' => 'email'
				),

				'admin_branding_menulogo' => array(
					'group' => 'appearance'
				),
				'admin_branding_favicon' => array(
					'group' => 'appearance'
				),
				'admin_branding_iconcolor' => array(
					'group' => 'colors'
				),
				'admin_branding_linkcolor' => array(
					'group' => 'colors'
				),
				'admin_branding_hovercolor' => array(
					'group' => 'colors'
				),

				'admin_dashboard_custom_widget' => array(
					'group' => 'custom_widget_with_text'
				),

				'admin_branding_adminbar_logo' => array(
					'group' => 'admin_bar'
				),

				'admin_bar_remove_wp_links' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_remove_mysites' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_remove_sitename' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_remove_updates' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_remove_comments' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_remove_newcontent' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_remove_edit' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_remove_myaccount' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_remove_search' => array(
					'group' => 'remove_buttons'
				),
				'admin_bar_add_logout' => array(
					'group' => 'additional'
				),
				'admin_bar_replace_howdy' => array(
					'group' => 'additional'
				),
				'admin_bar_custom_menu' => array(
					'group' => 'additional'
				),

				'theme_apple_icon_60' => array(
					'group' => 'apple_devices_logos'
				),
				'theme_apple_icon_120' => array(
					'group' => 'apple_devices_logos'
				),
				'theme_apple_icon_76' => array(
					'group' => 'apple_devices_logos'
				),
				'theme_apple_icon_152' => array(
					'group' => 'apple_devices_logos'
				),
				'theme_apple_icon_180' => array(
					'group' => 'apple_devices_logos'
				),
				'theme_ms_name' => array(
					'group' => 'windows_pinned_site'
				),
				'theme_ms_tilecolor' => array(
					'group' => 'windows_pinned_site'
				),
				'theme_ms_tileimage' => array(
					'group' => 'windows_pinned_site'
				),
				'theme_ms_navbuttoncolor' => array(
					'group' => 'windows_pinned_site'
				),
				'theme_ms_70x70' => array(
					'group' => 'windows_pinned_site'
				),
				'theme_ms_150x150' => array(
					'group' => 'windows_pinned_site'
				),
				'theme_ms_310x150' => array(
					'group' => 'windows_pinned_site'
				),
				'theme_ms_310x310' => array(
					'group' => 'windows_pinned_site'
				),
				'media_turnoff_attachment_page' => array(
					'group' => 'public_attachment_page'
				),
				'media_attachment_comments_no' => array(
					'group' => 'public_attachment_page'
				),
				'registration_noemail_admin' => array(
					'group' => 'registration'
				),
				'registration_noemail_passchange' => array(
					'group' => 'registration'
				),
				'registration_auto_login' => array(
					'group' => 'registration'
				),
				'registration_redirect' => array(
					'group' => 'registration'
				),
				'login_default_login' => array(
					'group' => 'default'
				),
				'login_default_pass' => array(
					'group' => 'default'
				),
				'login_remember_checked' => array(
					'group' => 'default'
				),
				'settings_deactivation_hook' => array(
					'group' => 'deactivation_hook'
				),

				'admin_metabox_hide' => array(
					'group' => 'hide_metaboxes'
				),
				'admin_heartbeat' => array(
					'group' => 'heartbeat'
				),
				'admin_heartbeat_freq' => array(
					'group' => 'heartbeat'
				),
				'settings_ut_admin_role' => array(
					'group' => 'ultimate_tweaker_administrator'
				)
			);
		}

		static function getSectionMeta($section_ID) {
			$meta = array(
				'general' => array(
					'title' => __('General', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-home'
				),
				'admin' => array(
					'id' => 2,
					'title' => __('Admin Area', UT2_SLUG),
					'icon' => 'dashicons dashicons-admin-network',
					'visibility' => 'all_roles',
				),
				'admin_appearance' => array(
					'title' => __('Appearance', UT2_SLUG),
					'parent_id' => 2,
					'visibility' => 'all_roles',
				),
				'admin_branding' => array(
					'title' => __('Branding', UT2_SLUG),
					'parent_id' => 2,
					'visibility' => 'all_roles',
				),
				'admin_dashboard' => array(
					'title' => __('Dashboard', UT2_SLUG),
					'parent_id' => 2,
					'visibility' => 'all_roles',
				),
				'admin_posts' => array(
					'title' => __('Posts', UT2_SLUG),
					'parent_id' => 2,
					'visibility' => 'all_roles',
				),
				'admin_metabox' => array(
					'title' => __('Meta Boxes', UT2_SLUG),
					'parent_id' => 2,
					'visibility' => 'all_roles',
				),
				'admin_menu' => array(
					'title' => __('Admin Menu', UT2_SLUG),
					'parent_id' => 2,
					'visibility' => 'all_roles',
				),
				'admin_nav_menu' => array(
					'title' => __('Menus', UT2_SLUG),
					'parent_id' => 2,
					'visibility' => 'all_roles',
				),
				'admin_themes' => array(
					'title' => __('Themes', UT2_SLUG),
					'parent_id' => 2,
				),
				'admin_plugins' => array(
					'title' => __('Plugins', UT2_SLUG),
					'parent_id' => 2,
				),
				'admin_users' => array(
					'title' => __('Users', UT2_SLUG),
					'parent_id' => 2,
				),
				'admin_widgets' => array(
					'title' => __('Widgets', UT2_SLUG),
					'parent_id' => 2,
				),
				'admin_bar' => array(
					'title' => __('Admin Bar', UT2_SLUG),
					'parent_id' => 2,
					'visibility' => 'all_roles',
				),
				'media' => array(
					'title' => __('Media', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-media',
					'visibility' => 'all_roles',
				),
				'theme' => array(
					'id' => 3,
					'title' => __('Theme', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-appearance',
				),
				'theme_minify' => array(
					'title' => __('Minifier', UT2_SLUG),
					'parent_id' => 3,
				),
				'theme_header_cleanup' => array(
					'title' => __('&ltHEAD> Cleanup', UT2_SLUG),
					'parent_id' => 3,
				),
				'theme_favicon_logos' => array(
					'title' => __('Favicon & Logos', UT2_SLUG),
					'parent_id' => 3,
				),
				'search' => array(
					'title' => __('Search', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-search'
				),
				'blog' => array(
					'title' => __('Blog', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-post'
				),
				'content' => array(
					'title' => __('Content', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-page'
				),
				'content_protection' => array(
					'title' => __('Protection', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/checkered7.svg', __FILE__),
					'visibility' => 'all_roles',
				),
				'security' => array(
					'id' => 4,
					'title' => __('Security', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/padlock46.svg', __FILE__)
				),
				'security_recaptcha' => array(
					'title' => __('reCaptcha 2', UT2_SLUG),
					'parent_id' => 4,
				),
				'comment' => array(
					'title' => __('Comments', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-comments'
				),
				'login' => array(
					'id' => 5,
					'title' => __('Login & Registration', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-id'
				),
				'login_appearance' => array(
					'title' => __('Page Appearance', UT2_SLUG),
					'parent_id' => 5,
				),
				'url' => array(
					'title' => __('Urls', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/link23.svg', __FILE__)
				),
				'updates' => array(
					'title' => __('Updates', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-update',
					'visibility' => 'all_roles',
				),
				'seo' => array(
					'title' => __('SEO', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-chart-line'
				),
				'rss' => array(
					'title' => __('RSS & Feeds', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-rss'
				),
				'custom_code' => array(
					'title' => __('Custom Code', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/code26.svg', __FILE__)
				),
				defined( 'WPB_VC_VERSION' ) ? 'visual_composer' : false => array(
					'title' => __('Visual Composer', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/vc_logo.png', __FILE__),
					'visibility' => 'all_roles',
				),
				in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
					? 'woocommerce' : false => array(
					'title' => __('WooCommerce', UT2_SLUG),
					'icon' => 'el-icon-woo',
				),
				'maintenance' => array(
					'title' => __('Maintenance Mode', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/under3.svg', __FILE__)
				),
				'keyboard' => array(
					'title' => __('Keyboard Shortcuts', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/computer207.svg', __FILE__),
					'visibility' => 'all_roles',
				),
				'tools' => array(
					'id' => 6,
					'title' => __('Tools', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-tools',
					'visibility' => 'all_roles',
				),
				'tools_duplicator' => array(
					'title' => __('Duplicator', UT2_SLUG),
					'parent_id' => 6,
					'visibility' => 'all_roles',
				),
				'tools_translate' => array(
					'title' => __('Fast Translate', UT2_SLUG),
					'parent_id' => 6,
					'visibility' => 'all_roles',
				),
				'settings' => array(
					'title' => __('Settings', UT2_SLUG),
					'icon' => 'dashicons dashicons-admin-settings'
				),
				'activation' => array(
					'title' => __('Activation', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/done.svg', __FILE__),
				),
			);

			return isset($meta[$section_ID]) ? (object) $meta[$section_ID] : null;
		}
	}
}