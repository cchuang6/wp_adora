<?php

class UT2_protection_obfuscate_email_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'protection_obfuscate_email', array(
			'title' => __( 'Obfuscate Email', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'the_content', array( $this, '_do' ), 20 );
		add_filter( 'the_excerpt', array( $this, '_do' ), 20 );
		add_filter( 'widget_text', array( $this, '_do' ), 20 );
	}

	function _do( $text ) {
		return preg_replace_callback('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4})/i', array( $this, '_obfuscate' ), $text);
	}

	function _obfuscate( $result ) {
		return antispambot($result[1]);
	}
}