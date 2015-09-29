<?php

class UT2_security_recaptcha_Tweak {
	function settings( ) {
		$f = array();

		$f[] = UT2_Helper::field( 'security_recaptcha', 'text', array(
			'title'       => __( 'Site key', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::field( '_security_recaptcha_secret', 'text', array(
			'title'       => __( 'Secret key', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::switcher( '_security_recaptcha_login', array(
			'title'       => __( 'Protect Login page', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::switcher( '_security_recaptcha_register', array(
			'title'       => __( 'Protect Registration page', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::switcher( '_security_recaptcha_comment', array(
			'title'       => __( 'Protect commenting form', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( '_security_recaptcha_style', 'radio', array(
			'title'    => __( 'Theme', UT2_SLUG ),
			'options'  => array(
				'' => 'Light',
				'dark' => 'Dark'
			),
		) );

		return $f;
	}

	function tweak() {
		if($this->value && $this->options->_security_recaptcha_secret) {
			global $pagenow;

			if($pagenow == 'wp-login.php') {
				add_action( 'login_enqueue_scripts', array( $this, '_enqueue_scripts' ) );

				if($this->options->_security_recaptcha_login) {
					add_action( 'login_form', array( $this, '_show_captcha' ) );
					add_action( 'wp_authenticate_user', array( $this, '_wp_authenticate_user' ), 10, 2 );
				}
				if($this->options->_security_recaptcha_register) {
					add_action( 'register_form', array( $this, '_show_captcha' ) );
					add_action( 'registration_errors', array( $this, '_registration_errors' ), 10, 3 );
				}
			}

			if($this->options->_security_recaptcha_comment) {
				add_action( 'comment_form', array( $this, '_comment_form' ) );
				add_filter( 'preprocess_comment', array( $this, '_preprocess_comment' ) );
				add_filter( 'comment_post_redirect', array( $this, '_comment_post_redirect' ), 10, 2 );
			}
		}
	}

	function _enqueue_scripts() {
		wp_enqueue_script( 'recaptcha-2', 'https://www.google.com/recaptcha/api.js', array(), null, true );
//		echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
	}

	function _comment_form() {
		$this->_enqueue_scripts();
//		add_action( 'wp_head', array( $this, '_enqueue_scripts' ) );
		$this->_show_captcha();
	}

	function _show_captcha() {
		echo '<style>.g-recaptcha {margin-bottom: 25px;}</style>';

		$theme = $this->options->_security_recaptcha_style !== 'dark' ? 'light' : 'dark';
		echo '<div class="g-recaptcha" data-sitekey="' . $this->value . '" data-theme="'. $theme .'"></div>';
	}

	function _wp_authenticate_user( $user, $password ) {
		if ( isset( $_POST['g-recaptcha-response'] ) && !$this->verify() ) {
			return new WP_Error( 'captcha_error', 'reCaptcha error' );
		}

		return $user;
	}

	function _registration_errors( $errors, $sanitized_user_login, $user_email ) {
		if ( isset( $_POST['g-recaptcha-response'] ) && !$this->verify() ) {
			$errors->add( 'captcha_error', 'reCaptcha error' );
		}

		return $errors;
	}

	function _preprocess_comment( $commentdata ) {
		if ( isset( $_POST['g-recaptcha-response'] ) && !$this->verify() ) {
//			$commentdata['comment_content'] = '';
//			$commentdata['comment_post_ID'] = 0;
			$this->error = 'failed';
		}

		return $commentdata;
	}

	function _comment_post_redirect( $location, $comment ) {
		if ( ! empty( $this->error ) && $this->error == 'failed' ) {
			wp_delete_comment( (int) $comment->comment_ID );
			$location = add_query_arg( 'reCaptcha', 'failed', $location );
			$location = str_replace( strstr( $location, '#' ), '#comments', $location );
		}

		return $location;
	}

	function verify() {
		$response = isset( $_POST['g-recaptcha-response'] ) ? esc_attr( $_POST['g-recaptcha-response'] ) : '';

		$remote_ip = $_SERVER["REMOTE_ADDR"];

		$google_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $this->options->_security_recaptcha_secret
		              . '&response=' . $response . '&remoteip=' . $remote_ip;

		$request = wp_remote_get($google_url);

		$result = json_decode(wp_remote_retrieve_body( $request ), true);

		return isset($result['success']) && $result['success'];
	}
}