<?php

class UT2_admin_posts_thumb_column_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_posts_thumb_column', array(
			'title' => __( 'Thumbnail column in list', UT2_SLUG )
		) );
	}

	function tweak() {
		add_filter( 'manage_posts_columns', array( $this, '_addThumbColumn' ) );
		add_action( 'manage_posts_custom_column', array( $this, '_addThumbValue' ), 10, 2 );
		add_filter( 'manage_pages_columns', array( $this, '_addThumbColumn' ) );
		add_action( 'manage_pages_custom_column', array( $this, '_addThumbValue' ), 10, 2 );
	}

	function _addThumbColumn( $cols ) {
		$cols['thumbnail'] = __( 'Thumbnail', UT2_SLUG );

		return $cols;
	}

	function _addThumbValue( $column_name, $post_id ) {
		$width  = (int) 35;
		$height = (int) 35;

		if ( 'thumbnail' == $column_name ) {
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
			$attachments  = get_children( array( 'post_parent'    => $post_id,
			                                     'post_type'      => 'attachment',
			                                     'post_mime_type' => 'image'
			) );

			if ( $thumbnail_id ) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array( $width, $height ), true );
			} elseif ( $attachments ) {
				foreach ( $attachments as $attachment_id => $attachment ) {
					$thumb = wp_get_attachment_image( $attachment_id, array( $width, $height ), true );
				}
			}
			if ( isset( $thumb ) && $thumb ) {
				echo $thumb;
			} else {
				echo __( 'None' );
			}
		}
	}
}