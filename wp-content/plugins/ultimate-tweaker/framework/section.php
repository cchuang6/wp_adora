<?php
/**
 * Created by Amino-Studio.
 * Url: http://amino-studio.com/
 * License: http://amino-studio.com/license/
 */

if ( ! class_exists( 'UT2_Framework_Section' ) ) {
	class UT2_Framework_Section {
		public $slug;
		public $title = '';
//		public $capability = 'manage_options'; // check it
		public $iconURL = null;

		public function __construct( $slug ) {
			$this->slug = $slug;
			$this->title = $slug;
		}

		/**
		 * @var stdClass[]
		 */
		public $tweaks = array();
		public function addTweak( $tweakID ) {
			$this->tweaks[] = $tweakID;
		}
	}
}