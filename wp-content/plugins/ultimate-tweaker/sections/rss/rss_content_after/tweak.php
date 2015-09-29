<?php

class UT2_rss_content_after_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'rss_content_after', 'textarea', array(
			'title'       => __( 'Custom Footer for Rss', UT2_SLUG ),
			'placeholder' => __( 'Example: Ads', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'the_content', array($this, '_do') );
	}

	function _do($content) {
		if(is_feed()){
			$content .= $this->value;
		}
		return $content;
	}
}