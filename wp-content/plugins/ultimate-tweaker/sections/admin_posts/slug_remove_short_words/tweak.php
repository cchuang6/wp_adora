<?php

class UT2_slug_remove_short_words_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'slug_remove_short_words', array(
			'title'    => __( 'Remove short words from slug', UT2_SLUG ),
			'desc'    => __( 'Words less 3 chars will be removed from url slug.', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter('sanitize_title', array($this, '_do'));
	}

	function _do($slug) {
		if (!is_admin()) return $slug;

		$slug = explode('-', $slug);
		foreach ($slug as $k => $word) {
			if (strlen($word) < 3) {
				unset($slug[$k]);
			}
		}
		return implode('-', $slug);
	}
}