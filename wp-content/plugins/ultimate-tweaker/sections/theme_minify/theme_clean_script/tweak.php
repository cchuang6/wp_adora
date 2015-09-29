<?php

class UT2_theme_clean_script_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'theme_clean_script', array(
			'title'    => __( 'Clean script tags', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('script_loader_tag', array($this, 'script_loader_tag'));
	}

	function script_loader_tag($input) {
		$input = str_replace("type='text/javascript' ", '', $input);
		return str_replace("'", '"', $input);
	}
}