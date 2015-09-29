<?php

class UT2_posts_tags_exclude_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'posts_tags_exclude', 'select', array(
			'title'    => __( 'Tags exclude', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'data'     => 'tags',
			'multi'    => true
		) );
	}

	function tweak() {
		add_filter('pre_get_posts', array($this, 'exclude'));
	}

	function exclude($query) {
		if ( $query->is_home ) {
			$query->set('tag__not_in', $this->value);}
		return $query;
	}
}