<?php

class UT2_admin_bar_replace_howdy_Tweak {
	function settings( ) {
		$f = array();

		$f[] = UT2_Helper::switcher( 'admin_bar_replace_howdy', array(
			'title'   => __( 'Replace Howdy text', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( '_admin_bar_replace_howdy_text', 'text', array(
			'required' => array( 'admin_bar_replace_howdy', '=', '1' ),
//			'title'    => __( '', UT2_SLUG ),
			'desc'    => __( 'Define text. Default text: `Logged in as %s`.', UT2_SLUG ),
			'default'  => __( 'Howdy, %s', UT2_SLUG )
		) );
		return $f;
	}

	function tweak() {
		add_action( 'admin_bar_menu', array($this, '_do'), 24 );
	}

	function _do( $wp_admin_bar ) {
		$user_id      = get_current_user_id();
		$current_user = wp_get_current_user();

		if ( ! $user_id )
			return;

		$text = isset($this->options->_admin_bar_replace_howdy_text) ? $this->options->_admin_bar_replace_howdy_text :
			__( 'Logged in as %s', UT2_SLUG );

		$avatar = get_avatar( $user_id, 26 );
		$howdy  = sprintf( $text, $current_user->display_name );

		$my_account = $wp_admin_bar->get_node('my-account');
		$wp_admin_bar->add_node( array(
			'id' => 'my-account',
			'title' => $howdy . $avatar,
		) );
	}
}