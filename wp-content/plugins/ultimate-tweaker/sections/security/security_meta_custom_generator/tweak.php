<?php

class UT2_security_meta_custom_generator_Tweak {
	function settings() {
		$f = array();

		// WARNING: Related with UT2_remove_meta_generator_Tweak rename there also!
		$f[] = UT2_Helper::switcher( 'security_meta_custom_generator', array(
			'title' => __( 'Custom "generator" META-tag', UT2_SLUG ),
		) );

		$f[] = UT2_Helper::field( '_security_meta_custom_generator_text', 'text', array(
			'required'    => array( 'security_meta_custom_generator', '=', '1' ),
			'right_title' => __( 'Your custom CMS name:', UT2_SLUG ),
			'default'     => 'CustomCMS'
		) );

		return $f;
	}

	function tweak() {
		$filters = array(
			'get_the_generator_html',
			'get_the_generator_xhtml',
			'get_the_generator_rss2',
			'get_the_generator_atom',
			'get_the_generator_rdf',
			'get_the_generator_export',
			'get_the_generator_comment',
		);

		foreach ( $filters as $filter ) {
			add_filter( $filter, array( &$this, "_do" ), 199, 2 );
		}
	}

	function _do( $tag, $type ) {
		$url         = site_url();
		$custom_text = $this->options->_security_meta_custom_generator_text;

		switch ( $type ) {
			case 'html':
			case 'xhtml':
				$tag = sprintf( '<meta name="generator" content="%s">', $custom_text );
				break;
			case 'rss2':
				$tag = sprintf( '<generator>%s?v=%s</generator>', $url, get_bloginfo_rss( 'version' ) );
				break;
			case 'atom':
				$tag = sprintf( '<generator uri="%s" version="%s">%s</generator>', $url, get_bloginfo_rss( 'version' ), $custom_text );
				break;
			case 'rdf':
				$tag = sprintf( '<admin:generatorAgent rdf:resource="%s?v=%s" />', $url, get_bloginfo_rss( 'version' ) );
				break;
			case 'export':
				$tag = sprintf( '<!-- generator="%s/%s" created="%s" -->', $custom_text, get_bloginfo_rss( 'version' ), date( 'Y-m-d H:i' ) );
				break;
			case 'comment':
				$tag = sprintf( '<!-- generator="%s/%s" -->', $custom_text, get_bloginfo( 'version' ) );
				break;
		}

		return $tag;
	}
}