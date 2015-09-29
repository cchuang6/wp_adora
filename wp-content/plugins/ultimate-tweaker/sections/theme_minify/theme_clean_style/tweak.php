<?php

class UT2_theme_clean_style_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'theme_clean_style', array(
			'title'    => __( 'Clean style tags', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('style_loader_tag', array($this, 'style_loader_tag'));
	}

	function style_loader_tag($input) {
		preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
		$media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
		return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n"; //TODO: remove new line option
	}
}