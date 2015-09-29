<?php

class UT2_woocommerce_hide_tabs_Tweak {
	function settings() {
		return $this->_init();
//		add_action( 'admin_init', array( $this, '_init' ), 49 );
	}

	function _init() {
		$els = array();

//		$tabs = do_action('woocommerce_product_tabs');
		$tabs = array(
			'description'            => array( 'title' => __( 'Description', 'woocommerce' ) ),
			'additional_information' => array( 'title' => __( 'Additional Information', 'woocommerce' ) ),
			'reviews'                => array( 'title' => __( 'Reviews (%d)', 'woocommerce' ) ),
		);

		foreach ( $tabs as $tag => $meta ) {
			$els[ $tag ] = $meta['title'];
		}

		return UT2_Helper::field( 'woocommerce_hide_tabs', 'checkbox', array(
			'title'   => __( 'Hide tabs on product page', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'options' => $els,
			'default' => ''
		) );
	}

	function tweak() {
		add_action( 'woocommerce_product_tabs', array( $this, '_do' ), 95 );
	}

	function _do( $tabs ) {
		if ( ! $this->value || ! is_array( $this->value ) ) {
			return $tabs;
		}

		foreach ( $this->value as $id => $v ) {
			if ( ! $v ) {
				continue;
			}
			unset( $tabs[$id] );
		}

		return $tabs;
	}
}