<?php

class UT2_login_image_Tweak {
	function settings() {
		$f   = array();
		$f[] = UT2_Helper::field( 'login_image', 'media', array(
			'title' => __( 'Login Form Image', UT2_SLUG ),
			'desc'  => __( 'This image will be shown under form.', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::field( '_login_image_dims', 'dimensions', array(
			'title' => __( 'Login Form Image Size', UT2_SLUG ),
			'desc'  => __( '', UT2_SLUG ),
//			'required' => array( 'login_image', '>', '0' ),
			'units' => 'px',
		) );

		return $f;
	}

	function tweak() {
		add_action( 'login_head', array( $this, '_logo' ) );
		add_filter( 'login_headerurl', create_function( '', 'return get_home_url();' ) );
		add_filter( 'login_headertitle', create_function( '', 'return "";' ) );
	}

	function _logo() {
		$size = '';
		$dims = $this->options->_login_image_dims;
		if ( isset( $dims['width'] ) && $dims['width'] ) {
			$size .= 'width:' . $dims['width'] . ';';
		}
		if ( isset( $dims['height'] ) && $dims['height'] ) {
			$size .= 'height:' . $dims['height'] . ';';
		}

//		$this->_->inlineStyle('#login h1 a', array(
//			'background-image' => 'url('.$this->value['url'].') !important'
//		));
		echo '<style type="text/css">#login h1 a { background-image: url(' . $this->value['url'] . ') !important;background-size:contain; ' . $size . ' }</style>';
	}
}