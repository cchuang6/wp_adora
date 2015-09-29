<?php

class UT2_security_meta_no_generator_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'security_meta_no_generator', array(
			'title'    => __( 'Remove &#87;ordPress generator tag', UT2_SLUG ),
			'desc'    => __( 'Contains information about &#87;ordPress and version,<br/> can used for attacks.', UT2_SLUG ),
			'on_desc'    => __( '<strike>&lt;meta name="generator" content="WordPress 4.x" /></strike> in &lt;head>.', UT2_SLUG ),
			'off_desc'    => htmlentities(__( '<meta name="generator" content="WordPress 4.x" /> in <head>.', UT2_SLUG )),
		) );
	}

	function tweak() {
		if(@$this->options->custom_generator) return;

		$filters = array(
			'get_the_generator_html',
			'get_the_generator_xhtml',
			'get_the_generator_rss2',
			'get_the_generator_atom',
			'get_the_generator_rdf',
			'get_the_generator_export',
			'get_the_generator_comment',
		);

		foreach ( $filters as $filter ) {
			add_filter( $filter, array( &$this, "_do" ), 0 );
		}
//			remove_action('wp_head', 'wp_generator');

//			add_filter("the_generator", array($this, '_do'));
	}

	function _do() {
		return "";
	}
}