<?php

class UT2_woocommerce_rename_tab_desc_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::switcher( 'woocommerce_rename_tab_desc', array(
			'title' => sprintf( __( 'Change "%s" tab text', UT2_SLUG ), __( 'Description', 'woocommerce' ) )
		) );

		$f[] = UT2_Helper::field( '_woocommerce_rename_tab_desc_message', 'text', array(
			'required'    => array( 'woocommerce_rename_tab_desc', '=', '1' ),
			'right_title' => __( 'Text:', UT2_SLUG ),
			'default'     => __( 'More info', UT2_SLUG )
		) );

		return $f;
	}

	function tweak() {
		add_filter( 'woocommerce_product_tabs', array( &$this, '_do' ), 97 );
	}

	function _do( $tabs ) {
		$tabs['description']['title'] = $this->options->_woocommerce_rename_tab_desc_message;

		return $tabs;
	}
}