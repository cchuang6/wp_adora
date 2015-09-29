<?php

class UT2_woocommerce_remove_ordering_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'woocommerce_remove_ordering', array(
			'title'    => __( 'Remove ordering', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'init', array(&$this, '_do') );
	}

	function _do() {
		remove_all_actions( 'woocommerce_before_shop_loop');
	}
}