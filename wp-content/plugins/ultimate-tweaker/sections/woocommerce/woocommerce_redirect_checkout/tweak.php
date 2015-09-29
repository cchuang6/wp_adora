<?php

class UT2_woocommerce_redirect_checkout_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'woocommerce_redirect_checkout', array(
			'title'    => __( 'Redirect to checkout after adding to cart', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter( 'add_to_cart_redirect', array(&$this, '_do'),0 );
	}

	function _do($checkoUT2_url) {
		global $woocommerce;
		$checkoUT2_url = $woocommerce->cart->get_checkout_url();
		return $checkoUT2_url;
	}
}