<?php

class UT2_media_svg_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'media_svg', array(
			'title'   => __( 'Enable SVG support', UT2_SLUG ),
		) );
	}

	function tweak() {
		if(is_admin()) {
			add_action( 'upload_mimes', array( $this, 'upload_mimes' ) );
			add_filter( 'wp_prepare_attachment_for_js', array( $this, '_wp_prepare_attachment_for_js' ), 1, 3 );
		}

		add_filter( 'wp_get_attachment_metadata', array( $this, '_wp_get_attachment_metadata' ), 1, 2 );
	}

	function upload_mimes( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}

	function _wp_prepare_attachment_for_js( $response, $attachment, $meta ) {
		if ( $response['mime'] == 'image/svg+xml' ) {
			$response['type'] = 'svg';
			$response['icon'] = $response['url'];
		}

		return $response;
	}

	function _wp_get_attachment_metadata($data, $id) {
		if(get_post_mime_type($id) == 'image/svg+xml') {
			$data['width']  = 3000;
			$data['height'] = 3000;
		}
		return $data;
	}
}