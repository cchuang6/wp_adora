<?php

class UT2_tools_translate_front_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'tools_translate_front', 'translate_text', array(
			'title'    =>  __( 'Translate front', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter('gettext', array( $this, '_do' ));
		add_filter('gettext_with_context', array( $this, '_do' ));
		add_filter('ngettext', array( $this, '_do' ));
	}

	function _do($str) {
		$s = array();
		$r = array();
		foreach($this->value as $tr) {
			if(!$tr['b'] && !$tr['a']) continue;
			if($tr['b'] == $str) return $tr['a'];
			$s[] = $tr['b'];
			$r[] = $tr['a'];
		}

		return str_ireplace($s, $r, $str);
	}
}