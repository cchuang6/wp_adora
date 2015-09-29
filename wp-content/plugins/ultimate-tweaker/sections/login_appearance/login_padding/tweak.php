<?php

class UT2_login_padding_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'login_padding', 'spacing', array(
			'title'    => __( 'Login Form Paddings', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'mode'     => 'padding',
//			'all'      => true,
		) );
	}

	function tweak() {
		add_action('login_head', array($this, '_do'));
	}

	function _do() {
		$css = '';
		$dims = $this->value;
		if(isset($dims['padding-top']) && $dims['padding-top']) {
			if(($dims['padding-top'])) $dims['padding-top'] .= 'px';
			$css .= 'padding-top:'. $dims['padding-top'] .';';
		}
		if(isset($dims['padding-right']) && $dims['padding-right']) {
			if(($dims['padding-right'])) $dims['padding-right'] .= 'px';
			$css .= 'padding-right:'. $dims['padding-right'] .';';
		}
		if(isset($dims['padding-bottom']) && $dims['padding-bottom']) {
			if(($dims['padding-bottom'])) $dims['padding-bottom'] .= 'px';
			$css .= 'padding-bottom:'. $dims['padding-bottom'] .';';
		}
		if(isset($dims['padding-left']) && $dims['padding-left']) {
			if(($dims['padding-left'])) $dims['padding-left'] .= 'px';
			$css .= 'padding-left:'. $dims['padding-left'] .';';
		}

		echo '<style type="text/css">#login { '.$css.' }</style>';
	}
}