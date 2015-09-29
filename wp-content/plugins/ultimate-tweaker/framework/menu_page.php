<?php
/**
 * Created by Amino-Studio.
 * Url: http://amino-studio.com/
 * License: http://amino-studio.com/license/
 */

if ( ! class_exists( 'UT2_Framework_MenuPage' ) ) {
	class UT2_Framework_MenuPage {
		public $menuSlug;
		public $menuTitle;
		public $pageTitle = '';
		public $position = null;
		public $iconURL = null;

		//header
		public $headerLogo = null;
		public $headerBackground = null;

		//available after resister
		public $menuHookname = null;

		public function __construct( $menu_slug ) {
			$this->menuSlug = $menu_slug;
		}

		public function getTitle() {
			return $this->menuTitle ? $this->menuTitle : $this->menuSlug;
		}

		public function getSlug() {
			return $this->menuSlug;
		}

		/**
		 * @var UT2_Framework_Section[]
		 */
		public $_sections = array();
		public function addSection( $section_slug ) {
			$section = new UT2_Framework_Section($section_slug);
			$this->_sections[] = $section;
			return $section;
		}

		/**
		 * @var []
		 */
		public $_tweak_fields = array();
		public function addTweakFields( $tweakID,  $fields ) {
			if(!isset($this->_tweak_fields[$tweakID])) $this->_tweak_fields[$tweakID] = array();
			if(!isset($this->_tweak_fields[$tweakID]['fields'])) $this->_tweak_fields[$tweakID]['fields'] = array();

			$this->_tweak_fields[$tweakID]['fields'] = array_merge($this->_tweak_fields[$tweakID]['fields'], $fields);
		}
	}
}