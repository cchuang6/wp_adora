<?php

class UT2_visual_composer_element_template_Tweak {
	function settings( ) {
		return UT2_Helper::switcher( 'visual_composer_element_template', array(
			'title'    => __( 'Element Template', UT2_SLUG )
		) );
	}

	function tweak() {
		if(!defined( 'WPB_VC_VERSION' )) return;

//		add_action('vc_frontend_editor_render', array($this, '_do'));
		add_action('vc_backend_editor_render', array($this, '_do'));

		add_action( 'wp_ajax_vc_et_save_template', array( $this, 'save_template' ) );
		add_action( 'wp_ajax_vc_et_remove_template', array( $this, 'remove_template' ) );
		add_action( 'wp_ajax_wpb_show_edit_form', array( &$this, 'show_edit_form' ), 1 );
		add_action( 'wp_ajax_vc_edit_form', array( &$this, 'show_edit_form' ), 1 );
	}

	function _do() {
		$data = get_option('vc-element-template-data');
		if(!is_array($data)) $data = array('_empty'=>true);

		$handler = UT2_Helper::$_->script('main', __FILE__, array( 'handler'=>'element-template'));
		UT2_Helper::$_->style('styles', __FILE__);

		wp_localize_script( $handler, 'VCElementTemplateData', $data );

		$settings = array(
			'ajaxurl'          => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'ElementTemplate-nonce' )
		);
		wp_localize_script( $handler, 'VCElementTemplateSettings', $settings );
	}


	public function save_template() {
		$nonce = $_POST['nonce'];

		if ( ! wp_verify_nonce( $nonce, 'ElementTemplate-nonce' ) )
			die ( 'Busted!');

		if ( current_user_can( 'edit_posts' ) ) {
			$element = $_POST['element'];
			$name = $_POST['name'];
			$values = $_POST['values'];

			$data = get_option('vc-element-template-data');
			if(!is_array($data) || !$data) $data = array();

			if(is_array($data)) {
				if ( ! array_key_exists( $element, $data ) || ! $data[ $element ] || ! is_array( $data[ $element ] ) ) {
					$data[ $element ] = array();
				}

				$data[ $element ][ $name ] = $values;

				update_option('vc-element-template-data', $data);
				$response = json_encode( array( 'success' => true, 'data' => $data ) );

				header( "Content-Type: application/json" );
				echo $response;
			}
		}

		exit;
	}

	public function remove_template() {
		$nonce = $_POST['nonce'];

		if ( ! wp_verify_nonce( $nonce, 'ElementTemplate-nonce' ) )
			die ( 'Busted!');

		if ( current_user_can( 'edit_posts' ) ) {
			$element = $_POST['element'];
			$name = $_POST['name'];

			$data = get_option('vc-element-template-data');
			if(!is_array($data)) $data = array();
			if(!is_array($data[$element])) $data[$element] = array();
			unset($data[$element][$name]);

			update_option('vc-element-template-data', $data);
			$response = json_encode( array( 'success' => true, 'data' => $data ) );

			header( "Content-Type: application/json" );
			echo $response;
		}

		exit;
	}

	public function show_edit_form() {
//		$element = vc_post_param( 'element' );
//		var_dump($element);
		//"'.esc_js($element).'"
		echo '<script>window.VCElementTemplateLoad();</script>';
	}
}