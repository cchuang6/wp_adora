<?php

class UT2_woocommerce_remove_generator_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'woocommerce_remove_generator', array(
			'title'    => __( 'Remove WooCommerce generator tag', UT2_SLUG ),
			'on_desc'    => __( '<strike>&lt;meta name="generator" content="WooCommerce 2.x" /></strike> in &lt;head>.', UT2_SLUG ),
			'off_desc'    => htmlentities(__( '<meta name="generator" content="WooCommerce 2.x" /> in <head>.', UT2_SLUG )),
		) );
	}

	function tweak() {
		if(@$this->options->custom_generator) return;

		$filters = array(
			'get_the_generator_html',
			'get_the_generator_xhtml'
		);

		foreach ( $filters as $filter ) {
			remove_filter( $filter, 'wc_generator_tag' );
		}
	}
}