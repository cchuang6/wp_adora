<?php

class UT2_admin_status_color_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'admin_status_color', array(
			'title'   => __( 'Different status colors', UT2_SLUG ),
			'desc'   => __( 'Pages will be highlighted in list by different colors.', UT2_SLUG )
		) );
	}

	function tweak() {
		add_action( 'admin_footer', array($this, '_do') );
	}

	function _do() {
		?>
		<style>
			.status-draft{background: #FCE3F2 !important;}
			.status-pending{background: #87C5D6 !important;}
			.status-publish{/* no background keep wp alternating colors */}
			.status-future{background: #C6EBF5 !important;}
			.status-private{background:#F2D46F;}
		</style>
	<?php
	}
}