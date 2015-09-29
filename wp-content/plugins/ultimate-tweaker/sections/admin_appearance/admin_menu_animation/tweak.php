<?php

class UT2_admin_menu_animation_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::field( 'admin_menu_animation', 'radio',  array(
			'title' => __( 'Menu Animation', UT2_SLUG ),
			'options' => array(
				'' => 'None',
				'slide' => 'Slide Left',
				'opacity' => 'Opacity',
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
		$classes .= " ut-admin-menu-anim-{$this->value} ";
		return $classes;
	}
}