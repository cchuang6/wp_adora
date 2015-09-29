<?php

class UT2_admin_branding_menulogo_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'admin_branding_menulogo', 'media', array(
			'url'      => true,
			'title'    => __( 'Menu logo', UT2_SLUG ),
			'desc'    => __( 'Add big logo on top of side menu.', UT2_SLUG ),
		) );
	}

	function tweak() {
		add_action('adminmenu', array($this, '_do'));
//			add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
	}

	function _do() {
		$css = '#UT2_menulogo { padding: 10px;display:block; } ' .
		       '#UT2_menulogo:focus { box-shadow:none; } ' .
		       '#UT2_menulogo img { display: block; max-height: 100%; max-width: 100%; margin-left: auto; margin-right: auto; vertical-align: middle;user-gra }';
		//			jQuery( document ).ready( function() {});
		?><script type="text/javascript">jQuery( '#UT2_menulogo').remove();jQuery( '#adminmenuwrap' ).prepend( '<a id="UT2_menulogo" href="<?php echo home_url(); ?>" target="_blank"><img draggable="false" src="<?php echo $this->value['url']; ?>"</a>');</script>
		<style type="text/css"><?php echo $css; ?></style><?php
	}

//	function admin_enqueue_scripts() {
//		$css = '#UT2_menulogo { padding: 10px; } ' .
//		       '#UT2_menulogo img { display: block; max-height: 100%; max-width: 100%; margin-left: auto; margin-right: auto; vertical-align: middle; }';
//		wp_add_inline_style( 'custom-style', $css );
//	}
}