<?php

class UT2_admin_branding_adminbar_logo_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::field( 'admin_branding_adminbar_logo', 'media', array(
			'url'   => true,
			'title' => __( 'Logo', UT2_SLUG ),
			'desc'  => __( 'Add button with logo to start of admin bar.', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( '_admin_branding_adminbar_logo_href', 'radio', array(
			'right_title' => __( 'Click action:', UT2_SLUG ),
			'options'     => array(
				''       => 'Home url',
				'none'   => 'None',
				'custom' => 'Custom url',
			)
		) );

		$f[] = UT2_Helper::field( '_admin_branding_adminbar_logo_href_custom', 'text', array(
			'right_title' => __( 'Link:', UT2_SLUG ),
			'required'    => array( '_admin_branding_adminbar_logo_href', '=', 'custom' ),
		) );

		$f[] = UT2_Helper::field( '_admin_branding_adminbar_logo_menu', 'select', array(
			'right_title' => __( 'Sub-menu:', UT2_SLUG ),
			'desc'        => sprintf( __( 'You can create or edit menus here: %s', UT2_SLUG ),
				'<a target="_blank" href="' . admin_url( 'nav-menus.php' ) . '">' . __( 'Edit Menus', UT2_SLUG ) . '</a>' ),
			'data'        => 'menus',
		) );

		return $f;
	}

	function tweak() {
		add_action( 'admin_bar_menu', array( $this, '_do' ), 1 );
	}

	function _do() {
		if ( !is_user_logged_in() ) { return; }
		if ( !is_admin_bar_showing() ) { return; }//!is_super_admin() ||

		global $wp_admin_bar;

		$hrefType = @$this->options->_admin_branding_adminbar_logo_href;
		if($hrefType == 'none') {
			$url = '';
		} else if($hrefType == 'custom') {
			$url = @$this->options->_admin_branding_adminbar_logo_href_custom;
		} else {
			$url = home_url();
		}

		$wp_admin_bar->add_menu( array(
				'id' => 'UT2_logo',
				'title' => '<img src="'.$this->options->admin_branding_adminbar_logo['url'].'" style="height: 26px;padding: 3px;" />',
				'href' => $url,
				'meta'  => array( 'target' => '_blank' ) )
		);


		$menuName = @$this->options->_admin_branding_adminbar_logo_menu;
		if($menuName) {
			$menu_object = wp_get_nav_menu_object( $menuName );
			$menu = wp_get_nav_menu_items( $menuName );
			if(!$menu_object || !$menu || !is_array($menu)) return;
			global $wp_admin_bar;

			foreach($menu as $menu_item) {
				$wp_admin_bar->add_menu( array(
					'id' => 'UT2_logo-' . $menu_item->ID,
					'parent' => 'UT2_logo',
					'title' => $menu_item->title,
					'href' => $menu_item->url
				) );
			}
		}
	}
}