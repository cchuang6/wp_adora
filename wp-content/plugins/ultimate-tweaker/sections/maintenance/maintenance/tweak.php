<?php

class UT2_maintenance_Tweak {
	function settings() {
		$f = array();

		$f[] = UT2_Helper::field( 'maintenance', 'radio', array(
			'title'    => __( 'Status', UT2_SLUG ),
			'options'  => array(
				'1' => 'Enabled',
				'' => 'Disabled'
			),
			'default'  => ''
		) );

		$f[] = UT2_Helper::switcher( '_maintenance_header', array(
			'title'    => __( 'Status code 503', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field('_maintenance_page_appearance', 'section', array(
			'title'    => __( 'Page Appearance', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( '_maintenance_title', 'text', array(
//			'required' => array( 'maintenance', '=', '1' ),
			'title'    => __( 'Title', UT2_SLUG ),
			'default'  => __( 'Maintenance', UT2_SLUG )
		) );
		$f[] = UT2_Helper::field( '_maintenance_message', 'text', array(
//			'required' => array( 'maintenance', '=', '1' ),
			'title'    => __( 'Message', UT2_SLUG ),
			'default'  => __( 'Maintenance...', UT2_SLUG )
		) );

		$f[] = UT2_Helper::field( '_maintenance_image', 'media', array(
			'title'    => __( 'Image', UT2_SLUG ),
			'desc'    => __( 'This image will be shown under form.', UT2_SLUG ),
		) );
		$f[] = UT2_Helper::field( '_maintenance_image_dims', 'dimensions', array(
			'title'    => __( 'Image Size', UT2_SLUG ),
			'desc'    => __( '', UT2_SLUG ),
			'units'          => 'px',
		) );



		$f[] = UT2_Helper::field( '_maintenance_bg_color', 'color', array(
			'title' => __( 'Background color', UT2_SLUG ),
		) );


		$f[] = UT2_Helper::field( '_maintenance_bg', 'media', array(
			'title'    => __( 'Background image', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( '_maintenance_bg_size', 'radio', array(
			'title'    => __( 'Background image size', UT2_SLUG ),
			'options'  => array(
				'' => 'Cover',
				'repeat' => 'Repeat'
			),
		) );

		return $f;
	}

	function tweak() {
		add_action( 'get_header', array( &$this, '_do' ));
	}

	function _do() {
		if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
			$add = '';
			$maintenance_bg = '';
			$logo = false;

			if(isset($this->options->_maintenance_bg_color) && $this->options->_maintenance_bg_color) {
				$maintenance_bg .= '<style type="text/css">html { background-color: ' . $this->options->_maintenance_bg_color . ' } </style>';
			}
			if(isset($this->options->_maintenance_bg) && $this->options->_maintenance_bg) {
				if( $this->options->_maintenance_bg_size == 'repeat') {
					$add = "background-size:initial;background-repeat: repeat;";
				}
				$maintenance_bg .= '<style type="text/css">html { background-image: url(' . $this->options->_maintenance_bg['url'] . ') !important;background-size:cover; ' . $add . ' } ' .
				        'body {background: transparent;}</style>';
			}
			if(isset($this->options->_maintenance_image) && $this->options->_maintenance_image) {
				$size = '';
				$dims = @$this->options->_maintenance_image_dims;
				if(isset($dims['width']) && $dims['width']) {
					$size .= 'width:'. $dims['width'] .';';
				}
				if(isset($dims['height']) && $dims['height']) {
					$size .= 'height:'. $dims['height'] .';';
				}

				$logo = '<img class="logo" src="'.$this->options->_maintenance_image['url'].'" style="'.$size.'" />';
//				$logo = '<style type="text/css">.logo { background-image: url('.$this->options->_maintenance_image['url'].') !important;background-size:cover; '.$size.' }</style>';
			}

			if($this->options->_maintenance_header) {
				status_header(503);
			}

			?><!doctype html>
			<html>
			<head>
				<meta charset="UTF-8">
				<title><?php echo ($this->options->_maintenance_title ? $this->options->_maintenance_title : __( 'Maintenance', UT2_SLUG )) ;?></title>
				<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
				<style>
					html, body, .message {height: 100%;}
					body { margin:0px;padding:0px; }
					.message {
						margin: auto;
						padding: 0px 50px;
						background: rgba(0,0,0,0.5);
						width: 500px;
						color: white;
						text-align: center;
						font-family: 'Open Sans', sans-serif;
						display: table;
					}
					.box {
						padding: 50px;
						display: table-cell;
						vertical-align: middle;
					}
					.logo {
						max-width: 500px;
						padding-bottom: 50px;
						margin-top: -50px;
					}
				</style>
			</head>
			<body>
			<?php echo $maintenance_bg; ?>
			<div class="message">
				<div class="box">
					<?php if($logo) { ?><?php echo $logo; ?><div class="logo"></div><?php } ?>
					<?php echo $this->options->_maintenance_message; ?>
				</div>
			</div>
			</body>
			</html><?php
			exit;
		}
	}
}