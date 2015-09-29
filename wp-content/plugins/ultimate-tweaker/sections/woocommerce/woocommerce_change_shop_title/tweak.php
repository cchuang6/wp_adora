<?php

class UT2_woocommerce_change_shop_title_Tweak {
	function settings() {
		$f = array();
		$f[] = UT2_Helper::switcher( 'woocommerce_change_shop_title', array(
			'title' => sprintf(__( 'Change "%s" title', UT2_SLUG ), 'Shop')// __( 'Shop', 'woocommerce' ))
		) );

		$f[] = UT2_Helper::field( '_woocommerce_change_shop_title_message', 'text', array(
			'required' => array( 'woocommerce_change_shop_title', '=', '1' ),
			'right_title'    => __( 'Title:', UT2_SLUG ),
			'default'  => __( 'My Shop', UT2_SLUG )
		) );
		return $f;
	}

	function tweak() {
		add_filter( 'woocommerce_page_title', array( &$this, '_do' ));
	}

	function _do( $page_title ) {
		if( 'Shop' == $page_title ) {
			return $this->options->_woocommerce_change_shop_title_message;
		}
	}
}