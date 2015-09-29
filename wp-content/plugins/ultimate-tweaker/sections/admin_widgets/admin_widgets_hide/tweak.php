<?php

class UT2_admin_widgets_hide_Tweak {
	function settings() {
		if(did_action('widgets_init')) {
			$this->_init();
		} else {
			add_action( 'widgets_init', array( $this, '_init' ), 49 );
		}
	}

	function readWidgets() {
		static $widgetsCache;
		if($widgetsCache) return $widgetsCache;

		$els = array();

		global $wp_widget_factory;

		foreach($wp_widget_factory->widgets as $name=>$cls) {
			$els[$name] = $cls->name;
		}

		$widgetsCache = $els;

		return $els;
	}

	function _init() {
		$els = $this->readWidgets();

		$this->fields = UT2_Helper::field( 'admin_widgets_hide', 'checkbox', array(
			'title'    => __( 'Hide widgets', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'options'  => $els,
			'default'  => ''
		) );

		add_filter( "ut/options/tweaks", array($this, '_insertFields') );
	}

	function _insertFields($s) {
		$s['admin_widgets_hide']['fields'][] = $this->fields;
		return $s;
	}

	function tweak() {
		add_action( 'widgets_init', array( $this, '_hide' ), 50 );
//			add_action( 'init', array( $this, '_hide' ),0 );
//			add_action( 'admin_init', array( $this, '_hide' ), 0 );
	}


	function _hide(  ) {
		$this->readWidgets();

//		var_dump($this->value);
		if(!$this->value || !is_array($this->value)) return;
		foreach($this->value as $name=>$hidden) {
			if($hidden == 1) {
				unregister_widget($name);
			}
		}
	}
}