<?php

class UT2_admin_bar_custom_menu_Tweak {
	function settings() {
		return UT2_Helper::field( 'admin_bar_custom_menu', 'select', array(
			'title' => __( 'Add Custom Menu', UT2_SLUG ),
			'desc' => sprintf( __( 'You can create or edit menus here: %s', UT2_SLUG ),
				'<a target="_blank" href="'. admin_url('nav-menus.php') .'">' . __('Edit Menus', UT2_SLUG) . '</a>'),
			'data'     => 'menus',
		) );
	}

	function tweak() {
		add_action( 'admin_bar_menu', array( $this, '_do' ), 99999 );
	}

	function _do() {
		$menu_object = wp_get_nav_menu_object( $this->value );
		$menu = wp_get_nav_menu_items( $this->value );
		if(!$menu_object || !$menu || !is_array($menu)) return;
		global $wp_admin_bar;

		$wp_admin_bar->add_menu( array(
			'id' => 'ut-menu-' . $menu_object->slug,
			'title' => $menu_object->name
		) );

		foreach($menu as $menu_item) {
			$wp_admin_bar->add_menu( array(
				'id' => 'ut-menu-' . $menu_item->ID,
				'parent' => 'ut-menu-' . $menu_object->slug,
				'title' => $menu_item->title,
				'href' => $menu_item->url
			) );
		}
	}
}