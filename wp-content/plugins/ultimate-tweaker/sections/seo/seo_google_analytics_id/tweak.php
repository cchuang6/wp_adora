<?php

class UT2_seo_google_analytics_id_Tweak {
	function settings() {
		$f   = array();
		$f[] = UT2_Helper::field( 'seo_google_analytics_id', 'text', array(
			'title'       => __( 'Google Analytics ID', UT2_SLUG ),
			'placeholder' => __( 'Example: UA-XXXX-Y', UT2_SLUG ),
			'desc'        => __( 'Enter your Google Analytics ID here to track your site with Google Analytics.', UT2_SLUG ),
		) );


		$f[] = UT2_Helper::field( '_seo_google_analytics_id_mode', 'radio', array(
			'title'   => __( 'Usage Mode', UT2_SLUG ),
			'options' => array(
				''            => 'Always',
				'hide_logged' => 'Hide for all logged',
				'subscriber'  => 'Hide for all logged except Subscribers'
			),
		) );

		return $f;
	}

	function tweak() {
		add_action( 'wp_footer', array( $this, '_do' ) );
	}

	function _do() {
		if ( $this->options->_seo_google_analytics_id_mode == 'hide_logged' && is_user_logged_in() ) {
			return;
		}
		if ( $this->options->_seo_google_analytics_id_mode == 'subscriber' && is_user_logged_in() && ! current_user_can( 'subscriber' ) ) {
			return;
		}
		?>
		<!-- Google Analytics -->
		<script>
			(function (i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function () {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

			ga('create', '<?php echo $this->value;?>', 'auto');
			ga('send', 'pageview');
		</script>
		<!-- End Google Analytics -->
	<?php
	}
}