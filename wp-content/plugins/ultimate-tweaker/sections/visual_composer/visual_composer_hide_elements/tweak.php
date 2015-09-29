<?php

class UT2_visual_composer_hide_elements_Tweak {
	function settings( ) {
		add_action( 'admin_init', array( $this, '_init' ), 0 );
	}

	function _init( ) {
		if(!defined( 'WPB_VC_VERSION' )) return;

		$vc_els = WPBMap::getShortCodes();

		$els = array();

//		var_dump($vc_els);
		foreach($vc_els as $tag=>$meta) {
			if(in_array($tag, array('vc_row', 'vc_row_inner', 'vc_column', 'vc_column_inner'))) continue;
			$els[$tag] = $meta['name'];
		}

		$this->fields = UT2_Helper::field( 'visual_composer_hide_elements', 'checkbox', array(
			'title'    => __( 'Hide elements', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'options'  => $els,
			'default'  => ''
		) );

		add_filter( "ut/options/tweaks", array($this, '_insertFields') );
//		add_filter( "redux/options/".UT2_Helper::getCurrentOptName()."/section/".'visual_composer', array($this, '_insertFields') );
	}

	function _insertFields($s) {
		$s['visual_composer_hide_elements']['fields'][] = $this->fields;
		return $s;
	}

	function tweak() {
		if(function_exists('vc_remove_element'))
			add_action('admin_init', array($this, '_do'), 50);
	}

	function _do() {
		if(!$this->value || !is_array($this->value)) return;

		foreach($this->value as $id=>$v) {
			if(!$v) continue;
			vc_remove_element( $id );
		}
	}
}