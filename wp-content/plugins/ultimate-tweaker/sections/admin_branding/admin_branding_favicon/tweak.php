<?php

class UT2_admin_branding_favicon_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'admin_branding_favicon', 'media', array(
			'url'      => true,
			'title'    => __( 'Favicon', UT2_SLUG ),
			'desc'    => __( 'Add favicon for admin area.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action('admin_head', array($this, '_do'));
	}

	function _do() {
		?><link rel="shortcut icon" href="<?php echo $this->value['url']; ?>" /><?php
	}
}