<?php

class UT2_media_contributor_upload_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'media_contributor_upload', 'radio', array(
			'title'   => __( 'Contributor upload files', UT2_SLUG ),
			'options'  => array(
				'yes' => 'Yes',
				'no' => 'No'
			),
			'default'  => 'no'
		) );
	}

	function tweak() {
		if($this->value == 'yes' || $this->value == 'no') {
			add_action( 'init', array( &$this, '_init' ) );
		}
	}

	function _init() {
		$value = $this->value;
		if($value == 'yes') {
			if ( current_user_can('contributor') && !current_user_can('upload_files') ) {
				add_action( 'admin_init', array( $this, '_do' ) );
			}
		} else if($value == 'no') {
			if ( current_user_can('contributor') && current_user_can('upload_files') ) {
				add_action( 'admin_init', array( $this, '_doOff' ) );
			}
		}
	}

	function _do() {
		$contributor = get_role('contributor');
		if($contributor) $contributor->add_cap('upload_files');
	}

	function _doOff() {
		$contributor = get_role('contributor');
		if($contributor) $contributor->remove_cap('upload_files');
	}
}