<?php

class UT2_admin_posts_widget_open_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_posts_widget_open', array(
			'title'    => __( 'Open all widgets', UT2_SLUG )
		) );
	}

	function tweak() {
		global $pagenow;
		if(in_array($pagenow, array('post-new.php', 'post.php'))) {
			$this->_do();
		}
	}

	function _do() {
		UT2_Helper::$_->script('script', __FILE__, array('deps' => array( 'jquery' )));
	}
}