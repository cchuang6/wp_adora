<?php

class UT2_admin_appearance_bar_slide_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'admin_appearance_bar_slide', array(
			'title' => __( 'Show Admin Bar on hover', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'admin_head', array( $this, '_do' ), 1 );
	}

	function _do() {
		global $wp_admin_bar;
		if ( ! is_admin_bar_showing() || ! is_object( $wp_admin_bar ) ) return;

		?>
		<style>#wpadminbar {display: none}</style>
		<script>
			var html = document.getElementsByTagName("html");
			if(html) html = html[0];
			if(html) {html.className = html.className.replace('wp-toolbar','');}
		</script><?php

		add_filter( 'admin_body_class', array( $this, 'body_class' ), 1000 );

		UT2_Helper::$_->style('style', __FILE__);
		UT2_Helper::$_->script('script', __FILE__);
		echo '<div id="wpadminbar_hover"></div>';
	}

	function body_class($classes) {
		$classes = str_ireplace('admin-bar', '', $classes);

		return $classes;
	}
}