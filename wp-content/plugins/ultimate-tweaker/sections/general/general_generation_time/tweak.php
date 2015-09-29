<?php

class UT2_general_generation_time_Tweak {
	function settings( ) {
		$f = array();


		$f[] = UT2_Helper::switcher( 'general_generation_time', array(
			'title'    => __( 'Show generation time', UT2_SLUG ),
			'desc'    =>
				__( 'Only admins can see this information.', UT2_SLUG )
				. '<br/>'
				. __( 'Number of SQL requests, generation time and memory consumption will be shown for all pages.', UT2_SLUG )
		) );

		return $f;
	}

	function tweak() {
		add_action( 'init', array( $this, '_init' ) );
	}

	function _init(){
//		if(!current_user_can('manage_options')) return;
//		SQL requests:62. Generation time:1.248 sec. Memory consumption:45.31 mb
		add_filter( 'wp_footer', array($this, '_do') );
	}

	function _do(){
		printf( __('SQL requests:%d. Generation time:%s sec. Memory consumption:', UT2_SLUG), get_num_queries(), timer_stop(0, 3) );
		if ( function_exists('memory_get_usage') ) echo round( memory_get_usage()/1024/1024, 2 ) . ' mb ';
	}
}