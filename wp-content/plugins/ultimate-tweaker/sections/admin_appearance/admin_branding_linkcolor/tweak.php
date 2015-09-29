<?php

class UT2_admin_branding_linkcolor_Tweak {
	function settings( ) {
		return UT2_Helper::field( 'admin_branding_linkcolor', 'color', array(
			'title'    => __( 'Link color', UT2_SLUG ),
			'desc'    => __( 'Color of all link in admin area.', UT2_SLUG ),
			'transparent'  => false
		) );
	}

	function tweak() {
		add_action('admin_head', array($this, '_do'));
	}

	function _do() {
		$color = $this->value;
		echo '<style type="text/css">';
		echo 'a { color: '.$color.'; }';
		echo '#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu { background: '.$color.'; }';
		echo 'input[type=radio]:checked:before { background-color: '.$color.'; }';
		echo 'input[type=checkbox]:checked:before { color: '.$color.'; }';
		echo '.wp-core-ui .button-primary { background: '.$color.';border:none;box-shadow:none; }';
		echo 'strong .post-com-count span { background-color: '.$color.'; }';
		echo 'strong .post-com-count:after { border-top-color: '.$color.'; }';
		echo '.view-switch a.current:before { color: '.$color.'; }';
		echo '.wrap .add-new-h2:hover { background: '.$color.'; }';
		echo '.tablenav .tablenav-pages a:focus, .tablenav .tablenav-pages a:hover { background: '.$color.'; }';
		echo '</style>';
	}
}