<?php

class UT2_admin_metabox_hide_Tweak {
	function settings( ) {
		add_action( 'admin_init', array( &$this, '_init' ), 999 );
		add_action( 'load-post-new.php', array( &$this, '_get_data' ) );
		add_action( 'load-post.php', array( &$this, '_get_data' ) );
	}

	protected function get_post_types($output='names') {
		if (! is_array($post_types = get_post_types(array( 'show_ui' => true ), $output)))
			return array();

		unset($post_types['attachment']);
		return $post_types;
	}

	function _init( ) {
		$post_url = admin_url('post-new.php', 'relative');

		$this->fields = array();
		$this->fields[] = UT2_Helper::field( 'admin_metabox_hide', 'switch', array(
			'title'    => __( 'Enabled' )
		) );

		foreach( $this->get_post_types() as $type=>$data) {
			$postTypeObject = get_post_type_object($type);

			$this->fields[] = UT2_Helper::field( '_admin_metabox_hide_' . $type, 'metabox_hide', array(
				'title'    => __( $postTypeObject->labels->name ),
				'post_type' => $type,
				'post_url' => $post_url,
				'nonce' => wp_create_nonce( UT2_SLUG . 'mh' )
			) );
		}

		add_filter( "ut/options/tweaks", array($this, '_insertFields') );
	}

	function _get_data() {
		if(!isset($_REQUEST['action']) || $_REQUEST['action'] !== 'ut_metabox_hide_get') return;

		add_action('do_meta_boxes', array($this, '_get_meta_boxes'), PHP_INT_MAX);
	}

	function _get_meta_boxes( $post_type ) {
		if ( ! count( $post_types = $this->get_post_types() )
		     && ! in_array( $post_type, $post_types )
		) {
			return;
		}

		check_ajax_referer( UT2_SLUG . 'mh' );

		global $wp_meta_boxes;
		$meta_boxes = isset( $wp_meta_boxes[ $post_type ] ) ? $wp_meta_boxes[ $post_type ] : array();

		$resultMetaBoxes = array();

		if ( ! empty( $meta_boxes ) ) {
			foreach ( $meta_boxes as $context ) {
				foreach ( $context as $priority ) {
					foreach ( $priority as $box ) {
						if ( isset( $box['id'] ) && isset( $box['title'] ) ) {
							$resultMetaBoxes[] = array(
								'key'=>$box['id'],
								'label'=>$box['title']
							);
						}
					}
				}
			}
		}

		if ( post_type_supports( $post_type, 'revisions' ) ) {
			$resultMetaBoxes[] = array( 'key'=>'revisionsdiv', 'label'=>__( 'Revisions' ) );
		}

		if ( post_type_supports( $post_type, 'comments' ) ) {
			$resultMetaBoxes[] = array( 'key'=>'commentsdiv', 'label'=>__( 'Comments' ) );
		}

		wp_send_json( array(
			'meta_boxes' => $resultMetaBoxes,
			'post_type'  => $post_type,
		) );

		exit;
	}

	function _insertFields($s) {
		$s['admin_metabox_hide']['fields'] = $this->fields;
		return $s;
	}

	function tweak() {
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ut_metabox_hide_get') return;

		add_action('do_meta_boxes', array($this, '_remove'), PHP_INT_MAX);
	}

	function _remove() {
		global $post_type;

		$type = $post_type?$post_type:'post';
//		foreach( $this->get_post_types() as $type=>$data) {
		$value = $this->options->{'_admin_metabox_hide_' . $type}; //$type == 'post' ? $this->value :
		$this->_removeBoxes( $type, $value );
//		}
	}

	function _removeBoxes( $post_type, $boxes ) {
		if(!$boxes || !is_array($boxes)) return;

		foreach($boxes as $id=>$v) {
			if ( ! $v ) { continue; }
			foreach ( array('normal', 'advanced', 'side') as $context )
				remove_meta_box($id, $post_type, $context);
		}
	}
}