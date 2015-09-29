<?php

class UT2_keyaboard_hotkeys_Tweak {
	function settings( ) {
		$f = array();
		$f[] = UT2_Helper::switcher( 'keyaboard_hotkeys', array(
			'title'    => __( 'Enabled', UT2_SLUG )
		) );

		$keys = array(
			'<kbd>Ctrl</kbd>+<kbd>.</kbd>, <kbd>L</kbd>' => __( 'Pages list', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>.</kbd>, <kbd>N</kbd>' => __( 'New page', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>,</kbd>, <kbd>L</kbd>' => __( 'Posts list', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>,</kbd>, <kbd>N</kbd>' => __( 'New post', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>,</kbd>, <kbd>C</kbd>' => __( 'Post categories list', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>,</kbd>, <kbd>T</kbd>' => __( 'Post tags list', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>S</kbd>' => __( 'Publish action', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>S</kbd>' => __( 'Save action', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>Q</kbd>' => __( 'Preview action', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>M</kbd>' => __( 'Menus', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>M</kbd>' => __( 'Menus on new window', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>Y</kbd> <kbd>L</kbd>' => __( 'Users', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>Y</kbd> <kbd>N</kbd>' => __( 'New user', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>B</kbd>' => __( 'Comments', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>i</kbd>, <kbd>P</kbd>' => __( 'Plugin install page', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>i</kbd>, <kbd>T</kbd>' => __( 'Theme install page', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>i</kbd>, <kbd>U</kbd>' => __( 'Plugin upload page', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>i</kbd>, <kbd>Y</kbd>' => __( 'Theme upload page', UT2_SLUG ),
			'<kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>L</kbd>' => __( 'Logout', UT2_SLUG ),
			'<kbd>Ctrl</kbd>, <kbd>U</kbd>, <kbd>T</kbd>' => __( 'Open Ultimate Tweaker Settings', UT2_SLUG ),
//			'' => __( 'Pages', UT2_SLUG ),
		);
		$html = '<style>.wpas_field_raw kbd {' .
		        'border: 1px solid rgb(182, 182, 182);font-style: normal;  padding: 7px;  border-radius: 5px;  margin: 5px;  display: inline-block;' .
		        'background: rgb(250, 250, 250);
background: -moz-linear-gradient(top, rgb(210, 210, 210), rgb(255, 255, 255));
background: -webkit-gradient(linear, left top, left bottom, from(rgb(210, 210, 210)), to(rgb(255, 255, 255)));
color: rgb(50, 50, 50);
text-shadow: 0 0 2px rgb(255, 255, 255);
-moz-box-shadow: inset 0 0 1px rgb(255, 255, 255), inset 0 0 .4em rgb(200, 200, 200), 0 .1em 0 rgb(130, 130, 130), 0 .11em 0 rgba(0, 0, 0, .4), 0 .1em .11em rgba(0, 0, 0, .9);
-webkit-box-shadow: inset 0 0 1px rgb(255, 255, 255), inset 0 0 .4em rgb(200, 200, 200), 0 .1em 0 rgb(130, 130, 130), 0 .11em 0 rgba(0, 0, 0, .4), 0 .1em .11em rgba(0, 0, 0, .9);
box-shadow: inset 0 0 1px rgb(255, 255, 255), inset 0 0 .4em rgb(200, 200, 200), 0 .1em 0 rgb(130, 130, 130), 0 .11em 0 rgba(0, 0, 0, .4), 0 .1em .11em rgba(0, 0, 0, .9); */' .
		        '}</style>';
		$html .= '<table style="padding: 0px;">';
		$html .= '<tr><td style="width: 200px;">Combination</td><td>Action</td></tr>';
		foreach($keys as $key=>$action) {
			$html .= "<tr><td style='vertical-align: middle;border-bottom: 1px solid lightgray'>{$key}</td>" .
			         "<td style='vertical-align: middle;border-bottom: 1px solid lightgray'>{$action}</td></tr>";
		}
		$html .= '</table>';

		$f[] = UT2_Helper::field('_keyaboard_hotkeys_content', 'raw', array(
			'content'       => $html
		));// Windows and Linux use Ctrl + letter. Macintosh uses Command + letter.

		return $f;
	}

	function tweak() {
//		UT2_Helper::$_->script('mousetrap', __FILE__);
//		UT2_Helper::$_->script('mousetrap-global-bind', __FILE__);
		UT2_Helper::$_->script('keys', __FILE__, array( 'deps' => array('mousetrap')));
	}
}