<?php

class UT2_url_change_user_slug_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'url_change_user_slug', array(
			'title'   => __( 'Change url of author to user', UT2_SLUG ),
			'on_desc'   => __( 'http://wp/user/username/', UT2_SLUG ),
			'off_desc'   => __( 'http://wp/author/username/', UT2_SLUG )
		) );
	}

	function tweak() {
//		$this->_do();
			add_action( 'init', array($this, '_do') );
	}

	function _do() {
		global $wp_rewrite;
		$author_slug = 'user';
		$wp_rewrite->author_base = $author_slug;
		/** TODO: chache */
		if(method_exists($wp_rewrite, 'flush_rules'))
			$wp_rewrite->flush_rules();
	}
}