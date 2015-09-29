<?php

class UT2_admin_default_editor_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'admin_default_editor', 'radio', array(
			'title'    => __( 'Default editor', UT2_SLUG ),
			'options'  => array(
				'' => 'Last active',
				'tinymce' => 'Visual',
				'html' => 'Text'
			),
			'desc'    => __( 'Select which editor will be loaded on edit page by default.', UT2_SLUG )
		) );
	}

	function tweak() {
		if($this->value == 'html') {
			add_filter( 'wp_default_editor', create_function('', 'return "html";') );
		} elseif($this->value == 'tinymce') {
			add_filter( 'wp_default_editor', create_function('', 'return "tinymce";') );
		}
	}
}