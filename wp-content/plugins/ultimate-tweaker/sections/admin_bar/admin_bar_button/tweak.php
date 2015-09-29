<?php

class UT2_admin_bar_button_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_bar_button', array(
			'title' => __( 'Show on hover', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'wp_head', array( $this, '_do' ), 1 );
	}

	function _do() {
		global $wp_admin_bar;
		if ( ! is_admin_bar_showing() || ! is_object( $wp_admin_bar ) ) return;

		add_filter( 'body_class', array( $this, 'body_class' ), 1000 );

		UT2_Helper::$_->style('style', __FILE__);
		UT2_Helper::$_->script('script', __FILE__);
		echo '<div id="wpadminbar_hover"></div>';
	}

	function body_class($classes) {
		foreach($classes as $i=>$cls) {
			if($cls == 'admin-bar') {
				unset($classes[$i]);
			}
		}

		return $classes;
	}
}