<?php

class UT2_content_code_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'content_code', 'textarea', array(
			'title'       => __( 'Custom After Post code', UT2_SLUG ),
//			'subtitle'       => __( 'Code will be added to the and of each post and page', UT2_SLUG ),
			'desc'       => __( 'Code will be added to the and of each post and page', UT2_SLUG )
							. '<br/>'
							. __( 'Shortcodes are supported', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'the_content', array($this, '_do') );
	}

	function _do($content) {
		if(!is_feed() && !is_home()) {
			$content.= $this->value;
		}
		return $content;
	}
}