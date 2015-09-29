<?php

class UT2_login_default_pass_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'login_default_pass', 'text', array(
			'title'    => __( 'Password', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('login_footer', array($this, '_do'));
	}

	function _do() {
		echo "<script>document.getElementById('user_pass').value = \"".addslashes($this->value)."\";</script>";
	}
}