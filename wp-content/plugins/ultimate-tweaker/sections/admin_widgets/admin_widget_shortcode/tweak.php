<?php

class UT2_admin_widget_shortcode_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_widget_shortcode', array(
			'title' => __( 'Enable shortcodes in Text Widgets', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'widget_text', 'do_shortcode' );
	}
}