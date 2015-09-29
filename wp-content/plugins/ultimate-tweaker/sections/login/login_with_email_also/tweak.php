<?php

class UT2_login_with_email_also_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'login_with_email_also', array(
			'title'    => __( 'Enable login with Email', UT2_SLUG ),
			'on_desc'    => __( 'Users can login by login & email', UT2_SLUG ),
			'off_desc'    => __( 'Users can login by login only', UT2_SLUG )
		) );

	}

	function tweak() {
		if($this->value && (@$_REQUEST['action'] !== 'register')) {
			add_filter('gettext', array($this, '_do'));
			add_action('wp_authenticate', array($this, '_doLogin'));
		}
	}

	function _do($text){
		if(in_array($GLOBALS['pagenow'], array('wp-login.php'))){
			if ($text == 'Username'){
				$text = __('Username / Email', UT2_SLUG);
			}
		}
		return $text;
	}

	function _doLogin($username) {
		$user = get_user_by('email', $username);
		if(!empty($user->user_login))
			$username = $user->user_login;

		return $username;
	}
}