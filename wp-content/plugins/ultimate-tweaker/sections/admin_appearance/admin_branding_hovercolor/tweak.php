<?php

class UT2_admin_branding_hovercolor_Tweak {
	function settings() {
		return UT2_Helper::field( 'admin_branding_hovercolor', 'color', array(
			'title'       => __( 'Hover color', UT2_SLUG ),
			'desc'        => __( 'Color for hover state links and icons.', UT2_SLUG ),
			'transparent' => false
		) );
	}

	function tweak() {
		add_action('admin_head', array($this, '_do'));
	}

	function _do() {
		$color = $this->value;
		echo '<style type="text/css">';
		echo 'a:active, a:hover { color: '.$color.'; }';
		echo '#adminmenu li:hover div.wp-menu-image:before { color: '.$color.'; }';
		echo 'input[type=checkbox]:focus, input[type=color]:focus, input[type=date]:focus, input[type=datetime-local]:focus, input[type=datetime]:focus, input[type=email]:focus, input[type=month]:focus, input[type=number]:focus, input[type=password]:focus, input[type=radio]:focus, input[type=search]:focus, input[type=tel]:focus, input[type=text]:focus, input[type=time]:focus, input[type=url]:focus, input[type=week]:focus, select:focus, textarea:focus { border-color: '.$color.';box-shadow:none;}';
		echo '.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover { background: '.$color.';border:none;box-shadow:none;}';
		echo '.post-com-count:hover span { background-color: '.$color.'; }';
		echo '.post-com-count:hover:after { border-top-color: '.$color.'; }';
		echo '#wpadminbar>#wp-toolbar a:focus span.ab-label, #wpadminbar>#wp-toolbar li.hover span.ab-label, #wpadminbar>#wp-toolbar li:hover span.ab-label { color: '.$color.'; }';
		echo '#wpadminbar .quicklinks .menupop ul li a:focus, #wpadminbar .quicklinks .menupop ul li a:focus strong, #wpadminbar .quicklinks .menupop ul li a:hover, #wpadminbar .quicklinks .menupop ul li a:hover strong, #wpadminbar .quicklinks .menupop.hover ul li a:focus, #wpadminbar .quicklinks .menupop.hover ul li a:hover, #wpadminbar li .ab-item:focus:before, #wpadminbar li a:focus .ab-icon:before, #wpadminbar li.hover .ab-icon:before, #wpadminbar li.hover .ab-item:before, #wpadminbar li:hover #adminbarsearch:before, #wpadminbar li:hover .ab-icon:before, #wpadminbar li:hover .ab-item:before, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover { color: '.$color.'; }';
		echo '#collapse-menu:hover, #collapse-menu:hover #collapse-button div:after { color: '.$color.'; }';
		echo '#adminmenu .wp-submenu a:focus, #adminmenu .wp-submenu a:hover, #adminmenu a:hover, #adminmenu li.menu-top>a:focus { color: '.$color.'; }';
		echo '#wpadminbar .ab-top-menu>li.hover>.ab-item, #wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li>.ab-item:focus, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus { color: '.$color.'; }';
		echo '</style>';
	}
}