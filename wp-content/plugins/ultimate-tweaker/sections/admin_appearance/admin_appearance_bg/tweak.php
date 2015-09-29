<?php

class UT2_admin_appearance_bg_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::field( 'admin_appearance_bg', 'media', array(
			'url'   => true,
			'title' => __( 'Background image', UT2_SLUG ),
		) );


		$f[] = UT2_Helper::field( '_admin_appearance_bg_size', 'radio', array(
			'right_title'    => __( 'Size:', UT2_SLUG ),
			'options'  => array(
				'' => 'Cover',
				'repeat' => 'Repeat'
			),
		) );

		$f[] = UT2_Helper::field( '_admin_appearance_bg_attachment', 'radio', array(
			'right_title'    => __( 'Attachment:', UT2_SLUG ),
			'options'  => array(
				'' => 'Scroll',
				'fixed' => 'Fixed'
			),
		) );

		return $f;
	}

	function tweak() {
		add_action( 'admin_head', array( $this, '_do' ), 1 );
	}

	function _do() {
		$add = '';
		if( $this->options->_admin_appearance_bg_size == 'repeat') {
			$add = "background-size:initial;background-repeat: repeat;";
		}
		if( $this->options->_admin_appearance_bg_attachment == 'fixed') {
			$add = "background-attachment:fixed;";
		}
		//.wrap h2{background: #f1f1f1;}
		echo '<style type="text/css">' .
		     'html { background-image: url('.$this->value['url'].') !important;background-size:cover; '.$add.' }' .
		     'html .wrap {   background: #F4F4F4; padding: 5px 15px; }' .
//		     'body {background: transparent !important;}' .
//		     'html .wrap .subsubsub {  background: white;padding: 0 5px;}' .
//		     'html .wrap form {  background: white;padding: 10px 20px;}' .
//		     'html .wrap > h2 {  color: white; }' .
//		     'html .wrap > h3 {  color: white; }' .
//		     'html .wrap > p {  background:white; padding: 5px 10px; }' .
//		     'html .wrap .core-updates {  background:white; padding: 5px 10px; }' .
//		     'html #wp-content-editor-tools { background: transparent;}' .
		     '</style>';
	}
}