<?php

class UT2_woocommerce_already_in_cart_Tweak {
	function settings() {
		$f   = array();
		$f[] = UT2_Helper::switcher( 'woocommerce_already_in_cart', array(
			'title' => __( 'Enable "Already in cart" button text', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( '_woocommerce_already_in_cart_message', 'text', array(
			'required'    => array( 'woocommerce_already_in_cart', '=', '1' ),
			'right_title' => __( 'Message:', UT2_SLUG ),
			'default'     => __( 'Already in cart', UT2_SLUG )
		) );

		return $f;
	}

	function tweak() {
		add_filter( 'woocommerce_product_single_add_to_cart_text', array( &$this, '_do' ) );
		add_filter( 'add_to_cart_text', array( &$this, '_add_to_cart_text' ) );
	}

	function _do() {
		global $woocommerce;

		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];

			if ( get_the_ID() == $_product->id ) {
				return $this->options->_woocommerce_already_in_cart_message;
			}
		}

		return __( 'Add to cart', 'woocommerce' );
	}

	function _add_to_cart_text() {
		global $woocommerce;

		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];

			if ( get_the_ID() == $_product->id ) {
				return $this->options->_woocommerce_already_in_cart_message;
			}
		}

		return __( 'Add to cart', 'woocommerce' );
	}
}