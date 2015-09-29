<?php

class UT2_posts_categories_include_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'posts_categories_include', 'select', array(
			'title'    => __( 'Categories include', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'data'     => 'categories',
			'multi'    => true,
		) );
	}

	function tweak() {
		add_filter('pre_get_posts', array($this, 'in_category'));
	}

	function in_category($query) {
		if ( $query->is_home ) {
			$query->set('category__in', $this->value);}
		return $query;
	}
}