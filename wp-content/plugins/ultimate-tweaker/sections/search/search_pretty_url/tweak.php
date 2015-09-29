<?php

class UT2_search_pretty_url_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'search_pretty_url', array(
			'title'    => __( 'Pretty url', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action('template_redirect', array($this, 'search_redirect'));
		add_filter('wpseo_json_ld_search_url', array($this, 'wpseo_json_ld_search_url')); //Yoast support
	}

	function search_redirect() {
		global $wp_rewrite;
		if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
			return;
		}

		$search_base = $wp_rewrite->search_base;
		if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
			wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s'))));
			exit();
		}
	}


	function wpseo_json_ld_search_url($url) {
		return str_replace('/?s=', '/search/', $url);
	}
}