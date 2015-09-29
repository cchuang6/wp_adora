<?php

class UT2_show_empty_category_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'show_empty_category',  array(
			'title'    => __( 'Show empty categories', UT2_SLUG ),
			'desc'    => __( 'Need this if you wanna group by empty category.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter( 'widget_categories_args', array( $this, '_do' ) );
	}

	function _do($cat_args) {
		$cat_args['hide_empty'] = 0;
		return $cat_args;
	}
}