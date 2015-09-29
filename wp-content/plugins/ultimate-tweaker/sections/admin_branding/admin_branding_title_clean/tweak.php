<?php

class UT2_admin_branding_title_clean_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_branding_title_clean', array(
			'title' => __( 'Remove "&#8212; &#87;ordPress" from title', UT2_SLUG ),
			'desc' => __( '&#87;ordPress suffix will be deleted from title.', UT2_SLUG )
		) );

	}

	function tweak() {
		add_filter( 'admin_title', array( $this, '_do' ), 1 );
	}

	function _do($title) {
		return str_replace('&#8212; WordPress', '', $title);
	}
}