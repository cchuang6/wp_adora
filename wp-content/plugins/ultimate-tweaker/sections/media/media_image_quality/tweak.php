<?php
class UT2_media_image_quality_Tweak {
	function isVisible() {
		return UT2_Helper::getRequestRole() == '';
	}

	function settings() {
		return UT2_Helper::field('media_image_quality', 'slider', array(
			'title'       => __( 'JPEG Quality', UT2_SLUG ),
			'default'       => 90,
			'min'           => 0,
			'step'          => 1,
			'max'           => 100,
			'display_value' => 'text'
		));
	}

	function tweak() {
		add_filter( 'jpeg_quality', array( &$this, 'jpeg_quality_return' ) );
	}

	public function jpeg_quality_return() {
		return absint( $this->value );
	}
}