<?php

class UT2_settings_enable_key_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'settings_enable_key', array(
			'title' => __( 'Load admin interface url', UT2_SLUG ),
			'desc'  => __( 'Do not load and show admin panel by default, only with this url:<br/>', UT2_SLUG )  . admin_url('admin.php?page=ultimate-tweaker?ut'),
		) );
	}

	function tweak() {}
}