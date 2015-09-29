<?php

class UT2_registration_noemail_admin_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'registration_noemail_admin', array(
			'title' => __( 'No new user email to admin', UT2_SLUG )
		) );
	}

	function tweak() {
		if(!function_exists('wp_new_user_notification')) {
			function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {
				$user = get_userdata( $user_id );

				// The blogname option is escaped with esc_html on the way into the database in sanitize_option
				// we want to reverse this for the plain text arena of emails.
				$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

				if ( empty( $plaintext_pass ) ) {
					return;
				}

				$message = sprintf( __( 'Username: %s' ), $user->user_login ) . "\r\n";
				$message .= sprintf( __( 'Password: %s' ), $plaintext_pass ) . "\r\n";
				$message .= wp_login_url() . "\r\n";

				wp_mail( $user->user_email, sprintf( __( '[%s] Your username and password' ), $blogname ), $message );
			}
		}
	}
}