<?php

class UT2_search_by_title_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'search_by_title', array(
			'title'    => __( 'Search by title only', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action( 'posts_search', array( $this, '_do' ), 500, 2 );
	}

	function _do( $search, &$wp_query ) {
		global $wpdb;
		if ( empty( $search ) ) {
			return $search;
		}
		$q      = $wp_query->query_vars;
		$n      = ! empty( $q['exact'] ) ? '' : '%';
		$search =
		$searchand = '';
		foreach ( (array) $q['search_terms'] as $term ) {
			$term = esc_sql( $wpdb->esc_like( $term ) );
			$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
			$searchand = ' AND ';
		}
		if ( ! empty( $search ) ) {
			$search = " AND ({$search}) ";
			if ( ! is_user_logged_in() ) {
				$search .= " AND ($wpdb->posts.post_password = '') ";
			}
		}

		return $search;
	}
}