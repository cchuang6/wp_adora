<?php

class UT2_media_sharpen_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'media_sharpen', array(
			'title' => __( 'Sharpen resized images', UT2_SLUG ),
			'desc'  => __( 'Available only for jpg images', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_filter( 'image_make_intermediate_size', array( $this, '_do' ), 999 );
	}

	function _do( $resized_file ) {
		if ( ! function_exists( 'imagecreatefromstring' ) ) {
			new WP_Error( __( 'The GD image library is not installed.' ) );
		}

		// Set artificially high because GD uses uncompressed images in memory
		@ini_set( 'memory_limit', apply_filters( 'image_memory_limit', WP_MAX_MEMORY_LIMIT ) );
		$image = imagecreatefromstring( file_get_contents( $resized_file ) );

		if ( ! is_resource( $image ) ) {
			return $resized_file;
		}//new WP_Error( 'error_loading_image', $image );

		$size = @getimagesize( $resized_file );
		if ( ! $size ) {
			return new WP_Error( 'invalid_image', __( 'Could not read image size', UT2_SLUG ) );
		}

		if ( $size[2] == IMAGETYPE_JPEG ) {
			$matrix  = array( array( - 1, - 1, - 1 ), array( - 1, 16, - 1 ), array( - 1, - 1, - 1 ) );
			$map     = array_map( 'array_sum', $matrix );
			$divisor = array_sum( $map );
			$offset  = 0;
			imageconvolution( $image, $matrix, $divisor, $offset );
			$jpeg_quality = apply_filters( 'jpeg_quality', 90, 'edit_image' );
			imagejpeg( $image, $resized_file, $jpeg_quality );
		}

		return $resized_file;
	}
}