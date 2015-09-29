<?php

class UT2_admin_post_author_to_publish_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_post_author_to_publish', array(
			'title' => __( 'Add Author combo box in Publish', UT2_SLUG )
		) );
	}

	function tweak() {
		global $pagenow;
		if(in_array($pagenow, array('post-new.php', 'post.php'))) {
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'post_submitbox_misc_actions', array( $this, 'post_submitbox_misc_actions' ) );
		}
	}

	function admin_menu() {
		remove_meta_box( 'authordiv', 'post', 'normal' );
	}

	function post_submitbox_misc_actions() {
		global $post_ID;
		$post = get_post( $post_ID );
		echo '<div id="author" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-top-color:#EEEEEE; border-bottom-width:0px;">Author: ';
		post_author_meta_box( $post );
		echo '</div>';
	}
}