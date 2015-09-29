<?php

class UT2_woocommerce_autocomplete_order_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'woocommerce_autocomplete_order', array(
			'title'    => __( 'Automatically complete orders', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'woocommerce_thankyou', array(&$this, '_do') );
	}

	function _do( $order_id ) {
		global $woocommerce;

		if ( !$order_id )
			return;
		$order = new WC_Order( $order_id );
		$order->update_status( 'completed' );
	}
}