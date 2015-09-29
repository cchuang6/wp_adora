<?php

class UT2_admin_menu_meta_hide_Tweak {
	function settings( ) {
		$els = array(
			'add-page' => __('Pages'),
			'add-post' => __('Posts'),
			'add-custom-links' => __('Links'),
			'add-category' => __('Categories'),
			'add-post_tag' => __('Tags'),
			'add-post_format' => __('Format'),
		);



		if(in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) {
			$els['add-product'] = __( 'Products', 'woocommerce' );
			$els['add-product_cat'] = __( 'Product Categories', 'woocommerce' );
			$els['add-product_tag'] = __( 'Product Tags', 'woocommerce' );
		}

//		$this->tweak();

		return UT2_Helper::field( 'admin_menu_meta_hide', 'checkbox', array(
			'title'    => __( 'Hide menu widgets', UT2_SLUG ),
			'options'  => $els,
		) );
	}

	function tweak() {
		add_action('admin_head-nav-menus.php', array($this, '_do'), 50);
	}

	function _do() {
		if(!is_array($this->value)) return;

		foreach($this->value as $id=>$v) {
			if(!$v) continue;

			remove_meta_box($id, 'nav-menus', 'side');
		}
	}
}