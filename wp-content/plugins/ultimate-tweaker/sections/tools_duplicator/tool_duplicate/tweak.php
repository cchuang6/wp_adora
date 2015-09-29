<?php

class UT2_tool_duplicate_Tweak {
	function settings() {
		$f = array();
		$f[] = UT2_Helper::switcher( 'tool_duplicate', array(
			'title' => __( 'Enabled', UT2_SLUG )
		) );

		$f[] = UT2_Helper::switcher( '_tool_duplicate_metabox', array(
			'required' => array( 'tool_duplicate', '=', '1' ),
			'title' => __( 'Hide metabox', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::switcher( '_tool_duplicate_adminbar', array(
			'required' => array( 'tool_duplicate', '=', '1' ),
			'title' => __( 'Hide in Admin bar', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::switcher( '_tool_duplicate_copytax', array(
			'required' => array( 'tool_duplicate', '=', '1' ),
			'title' => __( 'Disable copy taxonomies on duplicate', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::switcher( '_tool_duplicate_copymeta', array(
			'required' => array( 'tool_duplicate', '=', '1' ),
			'title' => __( 'Disable copy meta on duplicate', UT2_SLUG ),
		) );

		return $f;
	}

	function tweak() {
		add_action( 'init', array( &$this, '_init' ) );
	}

	function _init() {
		if(is_admin()) {
			add_filter( 'post_row_actions', array( $this, '_doLink' ), 10, 2 );
			add_filter( 'page_row_actions', array( $this, '_doLink' ), 10, 2 );

			if(!$this->options->_tool_duplicate_metabox)
				add_action( 'add_meta_boxes', array( $this, '_addMetaBoxes' ) );


			add_action( 'admin_action_tool_duplicate', array( $this, '_runDuplicate' ) );

			if(!$this->options->_tool_duplicate_copytax)
				add_action( 'tool_duplicate_after_copy', array( $this, 'duplicateCopyTaxonomies' ), 10, 2 );

			if(!$this->options->_tool_duplicate_copymeta)
				add_action( 'tool_duplicate_after_copy', array( $this, 'duplicateCopyMeta' ), 10, 2 );
		} else {
			if(!$this->options->_tool_duplicate_adminbar && is_user_logged_in()) {
				add_action( 'wp_before_admin_bar_render', array( $this, '_addAdminBar' ) );
			}
		}
	}

	function _addAdminBar() {
		global $wp_admin_bar;

		$post = get_queried_object();

		if ( empty($post) )
			return;
		if ( ! empty( $post->post_type ) ) {
			if($post->post_type != 'post' && $post->post_type != 'page') return;
			if($post->post_type == 'post' && !current_user_can('edit_posts')) return;
			if($post->post_type == 'page' && !current_user_can('edit_pages')) return;

			$wp_admin_bar->add_menu( array(
				'parent' => 'edit',
				'id' => 'tool_duplicate',
				'title' => __("Duplicate and Edit", UT2_SLUG),
				'href' => $this->doLink( $post->ID, true )
			) );
		}
	}

	function _addMetaBoxes() {
		$screens = array( 'post', 'page' );

		foreach ( $screens as $screen ) {
			add_meta_box( 'sdsd', __('Ultimate Tweaker Duplicator', UT2_SLUG), array( $this, '_doLinkMetaBox' ), $screen, 'side',
				'default' );
		}
	}

	function _doLinkMetaBox() {
		if(!isset($_GET['post']) || !$_GET['post']) return;

		$postId = $_GET['post'];
		echo '<div style="text-align: right;">'.
		     '<a href="'.$this->doLink( $postId, true ).'" title="'.esc_attr( __( "Duplicate and Edit", UT2_SLUG ) ).'" class="button">' .
		     __( 'Duplicate this page', UT2_SLUG ) .
		     '</a></div>';
	}

	function _doLink( $actions, $post ) {
		if($post->post_type == 'post' && !current_user_can('edit_posts')) return $actions;
		if($post->post_type == 'page' && !current_user_can('edit_pages')) return $actions;

		$actions['tool_duplicate'] = '<a href="'.$this->doLink( $post->ID ).'" title="'.esc_attr( __( "Duplicate this item", UT2_SLUG ) ).'">' .
		                             __( 'Duplicate', UT2_SLUG ) .
		                             '</a>';

		$actions['tool_duplicate_edit'] = '<a href="'.$this->doLink( $post->ID, true ).'" title="'.esc_attr( __( "Duplicate this item and go to edit page", UT2_SLUG ) ).'">' .
		                                  __( 'Duplicate & Edit', UT2_SLUG ) .
		                                  '</a>';

		return $actions;
	}

	function doLink( $postID, $isEdit = false ) {
		$action_name = 'tool_duplicate';

		return wp_nonce_url(admin_url( "admin.php" . '?action=' . $action_name . '&id=' . $postID . '&edit=' . ( $isEdit ? '1' : '0' ) ), 'tool_duplicate_nonce');
	}

	function _runDuplicate() {
		if ( ! check_admin_referer( 'tool_duplicate_nonce' ) ) {
			wp_die( __( 'Not possible!', UT2_SLUG ) );
		}

		if ( ! ( isset( $_GET['id'] ) || isset( $_POST['id'] ) || ( isset( $_REQUEST['action'] ) && 'tool_duplicate' == $_REQUEST['action'] ) ) ) {
			wp_die( __( 'Not possible!', UT2_SLUG ) );
		}

		$id        = $_GET['id'];
		$editAfter = isset( $_GET['edit'] ) ? $_GET['edit'] > 0 : false;
		$post      = get_post( $id );

		if($post->post_type == 'post' && !current_user_can('edit_posts')) return;
		if($post->post_type == 'page' && !current_user_can('edit_pages')) return;

		if ( ! $post ) {
			wp_die( __( 'Data not Found!', UT2_SLUG ) );
		} else {
			$newId = $this->duplicate( $post );

			if ( !$editAfter ) {
				wp_redirect( admin_url( 'edit.php?post_type=' . $post->post_type ) );
			} else {
				wp_redirect( admin_url( 'post.php?action=edit&post=' . $newId ) );
			}
		}

	}

	private function duplicate( $post ) {

		$newPost = array(
			'menu_order'     => $post->menu_order,
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => get_current_user_id(),
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_mime_type' => $post->post_mime_type,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
		);

		$id = wp_insert_post( $newPost );

		do_action( 'tool_duplicate_after_copy', $id, $post );

		return $id;
	}

	function duplicateCopyTaxonomies( $newId, $post ) {
		global $wpdb;
		if ( isset( $wpdb->terms ) ) {
			wp_set_object_terms( $newId, null, 'category' );

			$postTaxonomies = get_object_taxonomies( $post->post_type );
			foreach ( $postTaxonomies as $postTaxonomy ) {
				$postTerms = wp_get_object_terms( $post->ID, $postTaxonomy, array( 'orderby' => 'term_order' ) );
				$terms     = array();

				for ( $i = 0, $cT = count( $postTerms ); $i < $cT; $i ++ ) {
					$terms[] = $postTerms[ $i ]->slug;
				}
				wp_set_object_terms( $newId, $terms, $postTaxonomy );
			}
		}
	}

	function duplicateCopyMeta( $newId, $post ) {
		$post_custom_keys = get_post_custom_keys( $post->ID );
		if ( empty( $post_custom_keys ) ) {
			return;
		}

		foreach ( $post_custom_keys as $post_custom_key ) {
			$meta_custom_values = get_post_custom_values( $post_custom_key, $post->ID );
			foreach ( $meta_custom_values as $meta_custom_value ) {
				$meta_custom_value = maybe_unserialize( $meta_custom_value );
				add_post_meta( $newId, $post_custom_key, $meta_custom_value );
			}
		}
	}
}