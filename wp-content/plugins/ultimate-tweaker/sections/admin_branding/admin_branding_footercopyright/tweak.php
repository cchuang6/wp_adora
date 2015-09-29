<?php

class UT2_admin_branding_footercopyright_Tweak {
	function settings( ) {
		$f = array();

		$f[] = UT2_Helper::field( 'admin_branding_footercopyright', 'radio', array(
			'title'    => __( 'Admin footer message', UT2_SLUG ),
			'desc'    => __( 'Change "Thank you for creating with &#87;ordPress" message in the admin footer.', UT2_SLUG ),
			'options'  => array(
				'' => 'Default',
				'none' => 'None',
				'logo' => 'Logo & link',
				'custom' => 'Custom HTML',
			)
		) );

		$f[] = UT2_Helper::field( '_admin_branding_footercopyright_custom_text', 'text', array(
			'required' => array( 'admin_branding_footercopyright', '=', 'custom' ),
			'right_title'    => __( 'HTML:', UT2_SLUG ),
			'default'  => 'Custom Text'
		) );

		//LOGO
		$f[] = UT2_Helper::field( '_admin_branding_footercopyright_logo', 'media', array(
			'required' => array( 'admin_branding_footercopyright', '=', 'logo' ),
			'url'      => true,
			'right_title'    => __( 'HTML:', UT2_SLUG ),
			'default'  => 'Custom Text'
		) );

		$f[] = UT2_Helper::field( '_admin_branding_footercopyright_link', 'text', array(
			'required' => array( 'admin_branding_footercopyright', '=', 'logo' ),
			'right_title'    => __( 'Link:', UT2_SLUG )
		) );


		$f[] = UT2_Helper::field( '_admin_branding_footercopyright_link_text', 'text', array(
			'required' => array( 'admin_branding_footercopyright', '=', 'logo' ),
			'right_title'    => __( 'Link text:', UT2_SLUG ),
			'default'  => 'Link'
		) );

		return $f;
	}

	function tweak() {
		remove_all_filters( 'admin_footer_text' );

		if ( $this->value == 'none' ) {
			add_filter( 'admin_footer_text', '__return_false' );
		} else if ( $this->value == 'custom' ) {
			add_filter( 'admin_footer_text', array( &$this, '_admin_branding_footercopyright_custom_text_return' ), 1, 1 );
		} else if ( $this->value == 'logo' ) {
			add_filter( 'admin_footer_text', array( &$this, '_admin_branding_footercopyright_logo' ), 1, 1 );
		}
	}

	function _admin_branding_footercopyright_custom_text_return( $text ) {
		return $this->options->_admin_branding_footercopyright_custom_text;
	}

	function _admin_branding_footercopyright_logo( $text ) {
		$logo = @$this->options->_admin_branding_footercopyright_logo['url'];
		$url = @$this->options->_admin_branding_footercopyright_link;
		$text = @$this->options->_admin_branding_footercopyright_link_text;
		if($logo) {
			$text = '<img src="'.$logo.'" style="max-height: 40px;vertical-align: middle;margin-right: 10px;"/>' . $text;
		}
		if($url) {
			$text = '<a href="'.$url.'">' . $text . '</a>';
		}
		return $text;
	}
}