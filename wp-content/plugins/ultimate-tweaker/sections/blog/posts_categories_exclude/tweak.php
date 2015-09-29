<?php

class UT2_posts_categories_exclude_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'posts_categories_exclude', 'select', array(
			'title'    => __( 'Categories exclude', UT2_SLUG ),
			'data'     => 'categories',
			'multi'    => true,
		) );
	}

	function tweak() {
		add_filter('pre_get_posts', array($this, 'exclude_category'));
	}

	function exclude_category($query) {
		if ( $query->is_home ) {
			$query->set('category__not_in', $this->value);}
		return $query;
	}
}