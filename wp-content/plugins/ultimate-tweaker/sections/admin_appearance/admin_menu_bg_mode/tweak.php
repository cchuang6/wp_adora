<?php

class UT2_admin_menu_bg_mode_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::field( 'admin_menu_bg_mode', 'radio',  array(
			'title' => __( 'Menu background stretch', UT2_SLUG ),
			'options' => array(
				'' => 'Full-Height',
				'only_menu' => 'Only menu'
			)
		) );

		return $f;
	}

	function tweak() {
		add_action('admin_body_class', array($this, 'bodyClass'));
		add_action( 'admin_print_styles', array($this, 'style') );
	}

	function style() {
		wp_enqueue_style('admin_appearance');
	}

	function bodyClass( $classes ) {
		$classes .= " ut-admin-menu-bg-mode-{$this->value} ";
		return $classes;
	}
}