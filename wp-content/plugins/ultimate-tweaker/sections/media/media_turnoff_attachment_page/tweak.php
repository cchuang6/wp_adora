<?php

class UT2_media_turnoff_attachment_page_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'media_turnoff_attachment_page', array(
			'title'    => __( 'Disable attachment pages', UT2_SLUG ),
			'desc'  => 'Any visitor can see all your attachments, because he can sort out id in the url, also not used on site.',
			'off_desc'  => 'Content of http://your-site.com/?attachment_id=ID is available.',
			'on_desc' => 'Attachment content by http://your-site.com/?attachment_id=ID is not available.',
		) );
	}

	function tweak() {
		unset( $_GET['attachment_id'] );
		unset( $_POST['attachment_id'] );
		unset( $_REQUEST['attachment_id'] );

		add_action( 'parse_query', array($this, '_do') );
	}

	function _do( $query, $error = true ) {
		if ( is_attachment() ) {
			$query->is_attachment = false;
			$query->attachment_id = false;

			if ( $error == true )
				$query->is_404 = false;
		}
	}
}