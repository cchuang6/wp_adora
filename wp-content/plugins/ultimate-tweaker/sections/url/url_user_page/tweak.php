<?php

class UT2_url_user_page_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'url_user_page', 'select', array(
			'title'       => __( 'Author Link', UT2_SLUG ),
			'desc'       => __( 'By default, link goes to author posts, you can define your own page.', UT2_SLUG ),
			'data'     => 'pages',
		) );
	}

	function tweak() {
		add_action( 'author_link', array($this, '_do') );
	}

	function _do() {
//		var_dump($this->value);
		return get_page_link($this->value);
	}
}