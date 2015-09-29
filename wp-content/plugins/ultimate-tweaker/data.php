<?php

if ( !class_exists( 'UT2_Data' ) ) {
	class UT2_Data {
		static function getSections() {
			return array(
				'general' => array(
					'general_page404_redirect'      => 'front',
					'general_title_wptexturize_no'  => 'front',
					'general_generation_time'       => 'front',
					'general_email_from'            => 'both',
					'general_email_from_name'       => 'both',
				),
				'admin' => array(
					'admin_block'          => 'admin',
					'admin_no_notice'      => 'admin',
					'admin_default_editor' => 'admin',
					'admin_mce_3line'      => 'admin',
					'admin_status_color'   => 'admin',
					'admin_import_disable' => 'admin',
					'admin_export_disable' => 'admin',
					'admin_link_manager'   => 'admin',
					'admin_heartbeat'   => 'admin',
					'admin_heartbeat_freq'   => 'admin',
				),
				'admin_appearance' => array(
					'admin_template'       => 'admin',
					'admin_layout'       => 'admin',
					'admin_menu_bg_mode'       => 'admin',
//					'admin_menu_animation'       => 'admin',
					'admin_appearance_bg_color'          => 'admin',
					'admin_appearance_bg'          => 'admin',

					'admin_branding_iconcolor'      => 'both',
					'admin_branding_linkcolor'      => 'both',
					'admin_branding_hovercolor'     => 'both',

					'admin_appearance_bar_slide'          => 'admin',
					'admin_scale'          => 'admin',
					'admin_smooth_scroll'  => 'admin',
				),
				'admin_branding' => array(
					'admin_branding_title_clean'    => 'admin',
					'admin_branding_wp_rename'      => 'admin',
					'admin_branding_footercopyright'=> 'admin',
					'admin_branding_screenoptions_no'=> 'admin',
					'admin_branding_help_no'        => 'admin',

					'admin_branding_menulogo'       => 'admin',
					'admin_branding_favicon'        => 'admin',

					'admin_branding_adminbar_logo'  => 'both'
				),
				'admin_dashboard' => array(
					'admin_dashboard_menu_hidden'   => 'admin',
					'admin_dashboard_widgets_hide'  => 'admin',
					'admin_dashboard_hide_welcome'  => 'admin',
					'admin_dashboard_one_column'    => 'admin',
					'admin_dashboard_dragging_no'    => 'admin',
					'admin_dashboard_collapse_no'    => 'admin',
					'admin_dashboard_widget_open'    => 'admin',

					'admin_dashboard_custom_widget' => 'admin',
				),
				'admin_menu' => array(
					'admin_no_icons'    => 'admin',
					'admin_no_collapse' => 'admin',
					'admin_menu_hide'   => 'admin',
					'admin_menu_add_all_settings'   => 'admin',
					'admin_no_menu'   => 'admin',
				),
				'admin_nav_menu'  => array(
					'admin_menu_add_menus' => 'admin',
					'admin_menu_meta_hide'      => 'admin',
				),
				'admin_metabox' => array(
					'admin_posts_dragging_no'      => 'admin',
					'admin_posts_collapse_no'      => 'admin',
					'admin_posts_widget_open'      => 'admin',
					'admin_metabox_hide'      => 'admin',
				),
				'admin_posts' => array(
					'admin_post_author_to_publish' => 'admin',
					'admin_post_norevision'        => 'admin',
					'post_min_word_count'          => 'admin',
					'admin_posts_thumb_column'     => 'admin',
					'slug_remove_short_words'      => 'admin',
					'edit_page_text'               => 'admin',
					'post_autosave_off'            => 'admin',
					'admin_disable_tmce'           => 'admin',
					'tag_autocomplete_disabled'    => 'admin',
				),
				'admin_themes' => array(
					'admin_themes_disable_install'    => 'admin',
					'admin_themes_disable_switch'     => 'admin',
					'admin_themes_disable_delete'     => 'admin',
					'admin_themes_disable_customizer' => 'admin',
					'admin_themes_disable_editor'     => 'admin',
				),
				'admin_plugins' => array(
					'admin_plugins_active_first'    => 'admin',
					'admin_plugins_disable_install'    => 'admin',
					'admin_plugins_disable_activation' => 'admin',
					'admin_plugins_disable_delete'     => 'admin',
					'admin_plugins_disable_editor'     => 'admin',
					'admin_plugins_menu_upload'        => 'admin',
					'admin_plugins_hide'               => 'admin',
				),
				'admin_users' => array(
					'admin_users_hide'                => 'admin',
					'admin_users_filter_hide'         => 'admin',
					'admin_users_disable_list'        => 'admin',
					'admin_users_disable_create'      => 'admin',
					'admin_users_remove_color_picker' => 'admin',
				),
				'admin_widgets' => array(
					'admin_widget_shortcode' => 'admin',
					'admin_widgets_hide'     => 'admin',
				),
				'admin_bar' => array(
					'admin_bar_button'            => 'front',
					'admin_bar_no_front'          => 'front',
					//'admin_bar_subscriber_no',

					'admin_bar_remove_wp_links'   => 'both',
					'admin_bar_remove_mysites'    => 'both',
					'admin_bar_remove_sitename'   => 'both',
					'admin_bar_remove_updates'    => 'both',
					'admin_bar_remove_comments'   => 'both',
					'admin_bar_remove_newcontent' => 'both',
					'admin_bar_remove_edit'       => 'both',
					'admin_bar_remove_myaccount'  => 'both',
					'admin_bar_remove_search'     => 'both',

					'admin_bar_add_logout'        => 'both',
					'admin_bar_replace_howdy'     => 'both',
					'admin_bar_custom_menu'       => 'both',
				),
				'media'                => array(
					'media_md5_name'                => 'front',
					'media_sharpen'           => 'admin',
					'media_image_quality'           => 'admin',
					'media_svg'                     => 'both',
					'media_contributor_upload'      => 'admin',
					'media_post_no_img_a'           => 'front',
					'media_post_no_img_p'           => 'front',
					'media_image_no_width_height'   => 'front',

					'media_turnoff_attachment_page' => 'front',
					'media_attachment_comments_no'  => 'front',
				),
				'theme'                => array(
					'theme_smooth_scroll'    => 'front',
					'theme_fast_click'       => 'front',
					'theme_jquery_cdn'       => 'front',
				),
				'theme_minify'                => array(
					'theme_minify_html'    => 'front',
					'theme_remove_ver_cssjs' => 'front',
//					'theme_relative_urls'             => 'front',
					'theme_clean_style'             => 'front',
					'theme_clean_script'            => 'front',
				),
				'theme_header_cleanup' => array(
					'theme_meta_no_wlwmanifest'     => 'front',
					'theme_meta_no_prev_next'       => 'front',
					'theme_meta_no_shortlink'       => 'front',
					'theme_meta_no_canonical'       => 'front',
					'theme_no_recent_comment_style' => 'front',
					'theme_move_js_footer'          => 'front',
				),
				'theme_favicon_logos'  => array(
					'theme_favicon'           => 'front',

					'theme_apple_icon_60'     => 'front',
					'theme_apple_icon_120'    => 'front',
					'theme_apple_icon_76'     => 'front',
					'theme_apple_icon_152'    => 'front',
					'theme_apple_icon_180'    => 'front',

					'theme_ms_name'           => 'front',
					'theme_ms_tilecolor'      => 'front',
					'theme_ms_tileimage'      => 'front',
					'theme_ms_navbuttoncolor' => 'front',
					'theme_ms_70x70'          => 'front',
					'theme_ms_150x150'        => 'front',
					'theme_ms_310x150'        => 'front',
					'theme_ms_310x310'        => 'front',
				),
				'search' => array(
					'search_off'                => 'front',
					'search_redirect_to_single' => 'front',
					'search_pretty_url'         => 'front',
					'search_by_title'           => 'front',
					'search_per_page'           => 'front',
				),
				'blog'   => array(
					'post_author_notification' => 'admin',
					'show_empty_category'      => 'front',
					'posts_categories_include' => 'front',
					'posts_categories_exclude' => 'front',
					'posts_tags_include'       => 'front',
					'posts_tags_exclude'       => 'front',
				),
				'content'            => array(
					'content_link_target_blank' => 'front',
					'content_wpautop_no'        => 'front',
					'content_wptexturize_no'    => 'front',
					'content_make_clickable'    => 'front',
					'content_code'              => 'front',
					'content_twitter_name_link' => 'front',
				),
				'content_protection' => array(
					'protection_obfuscate_email' => 'front',
					'protection_selection_no'    => 'front',
					'protection_right_click_no'  => 'front',
					'protection_img_drag_no'     => 'front',
					'protection_prtscr_no'       => 'front',
				),
				'security' => array(
					'security_meta_custom_generator'   => 'front',
					'security_meta_no_generator'       => 'front',
					'security_nosniff'                 => 'front',
					'security_xss_protection'          => 'front',
					'security_iframe_block'            => 'front',
					'security_protected_cookie_expire' => 'front',
					'security_disable_editor'          => 'admin',
					'security_meta_no_rsd'             => 'front',
					'security_pingback_disable'        => 'both',
					'security_self_pinging_disable'    => 'front',
				),
				'security_recaptcha' => array(
					'security_recaptcha' => 'front',
				),
				'comment'            => array(
					'comment_front_spam_links'       => 'front',
					'comment_striptags'              => 'front',
					'comment_remove_all_urls'        => 'front',
					'comment_disable_make_clickable' => 'front',
					'comment_wptexturize_no'         => 'front',
					'comment_min_length'             => 'front',
					'comment_close_days'             => 'front',
					'comment_link_target_blank'      => 'front',
					'comment_remove_url_field'       => 'front',
					'comment_anonymous'              => 'front',
					'comment_twitter_name_link'      => 'front',
					'comment_no_capital_p_dangit'      => 'front'
				),
				'login' => array(
					'login_extend_auto_logout_period' => 'front',
					'login_with_email_also'           => 'front',
					'login_error_message'             => 'front',
					'login_message'                   => 'front',
					'login_required'                  => 'front',
					'login_subscriber_redirect'       => 'front',

					'registration_noemail_admin'      => 'front',
					'registration_noemail_passchange' => 'front',
					'registration_auto_login'         => 'front',
					'registration_redirect'           => 'front',

					'login_remember_checked'          => 'front',
					'login_default_login'           => 'front',
					'login_default_pass'           => 'front',
				),
				'login_appearance' => array(
					'login_image'             => 'front',
					'login_padding'           => 'front',
					'login_no_shake'          => 'front',
					'login_main_color'        => 'front',
					'login_bg_color'                => 'front',
					'login_bg'                => 'front',
					'login_transparent_style' => 'front',
					'login_hide_backtosite'   => 'front',
				),
				'url' => array(
					'url_change_user_slug' => 'front',
					'url_user_page'        => 'front',
				),
				'updates' => array(
					'updates_wp_disable'      => 'admin',
					'updates_footer_nag_hide' => 'admin',
					'updates_dash_menu_hide'  => 'admin',
					'updates_wp_auto_install' => 'admin',
					'updates_theme_disable'   => 'admin',
					'updates_plugin_disable'  => 'admin',
				),
				'seo' => array(
					'seo_meta_copyright'      => 'front',
					'seo_google_analytics_id' => 'front',
				),
				'rss' => array(
					'rss_turnoff'            => 'front',
					'rss_remove_meta'        => 'front',
					'rss_remove_meta_extra'  => 'front',
					'rss_add_featured_image' => 'front',
					'rss_content_before'     => 'front',
					'rss_content_after'      => 'front',
				),
				'custom_code' => array(
					'custom_code_header' => 'front',
					'custom_code_footer' => 'front',
				),
				'visual_composer' => array(
					'visual_composer_element_template'         => 'admin',
					'visual_composer_remove_meta'         => 'front',
					'visual_composer_disable_frontend'    => 'admin',
					'visual_composer_close_esc'           => 'admin',
					'visual_composer_save_hotkey'         => 'admin',
					'visual_composer_icon_click'          => 'admin',
					'visual_composer_hide_teaser_metabox' => 'admin',
					'visual_composer_hide_elements'       => 'admin',
				),
				'woocommerce' => array(
					'woocommerce_redirect_checkout'  => 'front',
					'woocommerce_remove_generator'   => 'front',
					'woocommerce_remove_feed'        => 'front',
					'woocommerce_remove_ordering'    => 'front',
					'woocommerce_sold_text'          => 'front',
					'woocommerce_already_in_cart'    => 'front',
					'woocommerce_rename_tab_desc'    => 'front',
					'woocommerce_change_shop_title'  => 'front',
					'woocommerce_hide_tabs'          => 'front',
					'woocommerce_product_per_page'   => 'front',
					'woocommerce_autocomplete_order' => 'front',
//				'woocommerce_categories_exclude', //OFFED
				),
				'maintenance' => array(
					'maintenance_button' => 'admin',
					'maintenance' => 'front',
				),
				'keyboard' => array(
					'keyaboard_hotkeys' => 'admin',
				),
				'tools' => array(),
				'tools_duplicator' => array(
					'tool_duplicate' => 'both',
				),
				'tools_translate' => array(
					array( 'title' => __( 'Admin Area', UT2_SLUG ) ),
					'tools_translate_admin_area' => 'admin',

					array( 'title' => __( 'Site', UT2_SLUG ) ),
					'tools_translate_front'      => 'front',
				),
				'settings' => array(
					'settings_enable_key' => 'admin',
					'settings_ut_user' => 'admin',

					'settings_deactivation_hook' => 'both',

					'settings_ut_admin_role' => 'admin'
				),
				'activation' => array(
					'auto_updates_enable' => 'admin',
				),
			);
		}

		static function getSectionMeta($section_ID) {
			$meta = array(
				'general' => array(
					'title' => __('General', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-home'
				),
				'admin' => array(
					'title' => __('Admin Area', UT2_SLUG),
					'icon' => 'dashicons dashicons-admin-network'
				),
				'admin_branding' => array(
					'title' => __('Branding', UT2_SLUG),
					'subsection' => true
				),
				'admin_dashboard' => array(
					'title' => __('Dashboard', UT2_SLUG),
					'subsection' => true
				),
				'admin_posts' => array(
					'title' => __('Posts', UT2_SLUG),
					'subsection' => true
				),
				'admin_menu' => array(
					'title' => __('Menu', UT2_SLUG),
					'subsection' => true
				),
				'admin_themes' => array(
					'title' => __('Themes', UT2_SLUG),
					'subsection' => true
				),
				'admin_plugins' => array(
					'title' => __('Plugins', UT2_SLUG),
					'subsection' => true
				),
				'admin_users' => array(
					'title' => __('Users', UT2_SLUG),
					'subsection' => true
				),
				'admin_widgets' => array(
					'title' => __('Widgets', UT2_SLUG),
					'subsection' => true
				),
				'admin_bar' => array(
					'title' => __('Admin Bar', UT2_SLUG),
					'subsection' => true
				),
				'media' => array(
					'title' => __('Media', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-media'
				),
				'theme' => array(
					'title' => __('Theme', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-appearance'
				),
				'theme_header_cleanup' => array(
					'title' => __('&ltHEAD> Cleanup', UT2_SLUG),
					'subsection' => true
				),
				'theme_favicon_logos' => array(
					'title' => __('Favicon & Logos', UT2_SLUG),
					'subsection' => true
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
//					'icon' => 'dashicons-before dashicons-admin-page'
				),
				'security' => array(
					'title' => __('Security', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/padlock46.svg', __FILE__)
				),
				'security_recaptcha' => array(
					'title' => __('reCaptcha 2', UT2_SLUG),
					'subsection' => true
				),
				'comment' => array(
					'title' => __('Comments', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-comments'
				),
				'login' => array(
					'title' => __('Login & Registration', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-id'
				),
				'login_appearance' => array(
					'title' => __('Page Appearance', UT2_SLUG),
					'subsection' => true
				),
				'url' => array(
					'title' => __('Urls', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/link23.svg', __FILE__)
				),
				'updates' => array(
					'title' => __('Updates', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-update'
				),
				'seo' => array(
					'title' => __('SEO', UT2_SLUG),
					'icon' => 'dashicons-chart-line'
				),
				'rss' => array(
					'title' => __('RSS & Feeds', UT2_SLUG),
					'icon' => 'dashicons-rss'
				),
				'custom_code' => array(
					'title' => __('Custom Code', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/code26.svg', __FILE__)
				),
				defined( 'WPB_VC_VERSION' ) ? 'visual_composer' : false => array(
					'title' => __('Visual Composer', UT2_SLUG),
					'icon_type' => 'image',
					'icon' => plugins_url('assets/vc_logo.png', __FILE__)
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
					'icon' => plugins_url('assets/computer207.svg', __FILE__)
				),
				'tools' => array(
					'title' => __('Tools', UT2_SLUG),
					'icon' => 'dashicons-before dashicons-admin-tools'
				),
				'tools_duplicator' => array(
					'title' => __('Duplicator', UT2_SLUG),
					'subsection' => true
				),
				'tools_translate' => array(
					'title' => __('Fast Translate', UT2_SLUG),
					'subsection' => true
				),
				'settings' => array(
					'title' => __('Settings', UT2_SLUG),
					'icon' => 'dashicons dashicons-admin-settings'
				),
			);

			return isset($meta[$section_ID]) ? (object) $meta[$section_ID] : null;
		}
	}
}