<?php

class UT2_general_email_from_name_Tweak {
	function settings( ) {
		$f = array();

		$f[] = UT2_Helper::field( 'general_email_from_name', 'text', array(
			'title'    => __( 'Change from name', UT2_SLUG ),
			'desc'    => __( 'You can define any name, name will be used for all sent emails.<br/> Default name is "&#87;ordPress"', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( 'info', array(
			'desc'    => __( 'This address and name will be used for all sended emails.', UT2_SLUG )
		) );

		return $f;
	}

	function tweak() {
		add_filter('wp_mail_from_name', array($this, 'wp_mail_from_name'));
	}

	function wp_mail_from_name($old) {
		return $this->value;
	}
}