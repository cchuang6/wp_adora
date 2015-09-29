<?php

class UT2_woocommerce_remove_feed_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'woocommerce_remove_feed', array(
			'title'    => __( 'Remove feed', UT2_SLUG ),
		) );
	}

	function tweak() {
		remove_action( 'wp_head', 'wc_products_rss_feed' );
	}
}