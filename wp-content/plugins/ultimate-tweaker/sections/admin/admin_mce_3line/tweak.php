<?php

class UT2_admin_mce_3line_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_mce_3line', array(
			'title'   => __( 'Additional TinyMCE buttons', UT2_SLUG ),
			'desc'   => __( 'Additional buttons font select, size, style, del, subscript, superscript cleanup will be shown.', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'mce_buttons_3', array($this, '_do') );
	}

	function _do($buttons) {
		$buttons[] = 'fontselect';
		$buttons[] = 'fontsizeselect';
		$buttons[] = 'styleselect';
		$buttons[] = 'del';
		$buttons[] = 'subscript';
		$buttons[] = 'superscript';
		$buttons[] = 'cleanup';
		return $buttons;
	}
}