<?php

class UT2_login_transparent_style_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'login_transparent_style', array(
			'title'    => __( 'Transparent style', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('login_head', array($this, '_do'));
	}

	function _do() {
		echo '<style type="text/css">';
		echo '.login .message,#loginform {box-shadow:none; }';
		echo '#login {width: 350px; padding: 0px 50px;background: rgba(0,0,0,0.5);height: 100%; }';
		echo '#login h1 { padding-top: 50px; }';
		echo '.login .message { background-color: transparent; color:white;text-align: center; }';
		echo '.login form { margin-top:0px; }';
		echo '.register { border: none; }';
		echo '#nav { text-align: center; }';
		echo '.login form, .login form label { background-color: transparent; color:white; }';
		echo '.login #nav a, .login #backtoblog a { color:white; }';
		echo '.submit .button { color:white; border: none;border-radius: 0px; }';
		echo '</style>';
	}
}