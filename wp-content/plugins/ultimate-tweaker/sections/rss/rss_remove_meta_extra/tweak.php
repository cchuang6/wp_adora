<?php

class UT2_rss_remove_meta_extra_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'rss_remove_meta_extra', array(
			'title'    => __( 'Extra feeds such as category feeds', UT2_SLUG ),
			'on_desc'    => __( '<strike>&lt;link rel="alternate" type="application/rss+xml" title="Category Feed" href="http://wp/?feed=rss2&#038;cat=1" /></strike> in &lt;head>.', UT2_SLUG ),
			'off_desc'    => __( '&lt;link rel="alternate" type="application/rss+xml" title="Category Feed" href="http://wp/?feed=rss2&#038;cat=1" /> in &lt;head>.', UT2_SLUG ),
		) );
	}

	function tweak() {
		remove_action( 'wp_head', 'feed_links_extra', 3 );
	}
}