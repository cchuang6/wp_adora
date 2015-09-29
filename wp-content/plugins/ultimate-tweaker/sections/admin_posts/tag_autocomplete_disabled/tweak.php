<?php

class UT2_tag_autocomplete_disabled_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'tag_autocomplete_disabled', array(
			'title'    => __( 'Disable tag Autocomplete in Posts', UT2_SLUG )
		) );
	}

	function tweak() {
		UT2_Helper::$_->script('tag-autocomplete-disabled', __FILE__, array('deps' => array( 'jquery', 'post' )));
	}
}