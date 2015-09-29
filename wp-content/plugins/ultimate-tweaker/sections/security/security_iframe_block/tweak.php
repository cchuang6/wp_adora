<?php

class UT2_security_iframe_block_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'security_iframe_block', array(
			'title'   => __( 'Prevent embedding inside an iframe', UT2_SLUG )
		) );
	}

	function tweak() {
		header('X-Frame-Options: SAMEORIGIN');
//			add_action('wp_head', array($this, 'oldMethod'));
	}

	function oldMethod() {
		if (!is_preview()) {
			echo "\n<script type=\"text/javascript\">";
			echo "\n<!--";
			echo "\nif (parent.frames.length > 0) { parent.location.href = location.href; }";
			echo "\n-->";
			echo "\n</script>\n\n";
		}
	}
}