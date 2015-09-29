<?php

class UT2_rss_turnoff_Tweak {
	function settings() {
		return UT2_Helper::switcher( 'rss_turnoff', array(
			'title'    => __( 'Turn off feeds', UT2_SLUG ),
			'on_desc'  => 'Feeds are not available',
			'off_desc' => 'Feeds are available',
		) );
	}

	function tweak() {
		add_action( 'do_feed', array( $this, 'fb_disable_feed' ), 1 );
		add_action( 'do_feed_rdf', array( $this, 'fb_disable_feed' ), 1 );
		add_action( 'do_feed_rss', array( $this, 'fb_disable_feed' ), 1 );
		add_action( 'do_feed_rss2', array( $this, 'fb_disable_feed' ), 1 );
		add_action( 'do_feed_atom', array( $this, 'fb_disable_feed' ), 1 );
	}

	function fb_disable_feed() {
		wp_die( sprintf( __( 'No feed available, please visit our <a href="%s">homepage</a>!', UT2_SLUG ), get_bloginfo( 'url' ) ) );
	}
}