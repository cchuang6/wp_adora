<?php

class UT2_edit_page_text_Tweak {
	function settings() {
		$f   = array();
		$f[] = UT2_Helper::switcher( 'edit_page_text', array(
			'title' => __( 'Custom notice in editing page', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::field( '_edit_page_text_title', 'text', array(
			'required'    => array( 'edit_page_text', '=', '1' ),
			'right_title' => __( 'Title:', UT2_SLUG )
		) );
		$f[] = UT2_Helper::field( '_edit_page_text_text', 'textarea', array(
			'required'    => array( 'edit_page_text', '=', '1' ),
			'right_title' => __( 'Text:', UT2_SLUG ),
			'default'     => 'Text'
		) );

		return $f;
	}

	function tweak() {
		add_action( 'edit_form_after_title', array( $this, '_do' ) );
	}

	function _do( $post_type ) { ?>
		<div class="after-title-help postbox">
			<?php if ( $this->options->_edit_page_text_title ): ?>
				<h3><?php echo $this->options->_edit_page_text_title; ?></h3><?php endif; ?>
			<div class="inside">
				<p><?php echo $this->options->_edit_page_text_text; ?></p>
			</div>
		</div>
	<?php }
}