<?php

class UT2_content_wpautop_no_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'content_wpautop_no', array(
			'title'    => __( 'Disable content wpautop', UT2_SLUG ),
		) );
	}

	function tweak() {
		remove_filter( "the_content", "wpautop" );
		remove_filter( "the_excerpt", "wpautop" );
	}
}