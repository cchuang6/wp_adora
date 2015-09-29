<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Header Template
 *
 * Here we setup all logic and XHTML that is required for the header section of all screens.
 *
 * @package WooFramework
 * @subpackage Template
 */
 
 global $woo_options, $woocommerce;

 $settings = array(
	'header_content' => ''
 );
	
 $settings = woo_get_dynamic_values( $settings );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>" />
<?php
wp_head();
woo_head();
?>
</head>
<body <?php body_class(); ?>>
<?php woo_top(); ?>
<div id="wrapper">
	<div style="background: #000; overflow:hidden;" >
    <div class="col-full" style="margin-top:10px">
    	<a href="/"><img src="http://getadora.com/wp-content/uploads/2014/12/home_logo.png" /></a>
    	<ul style="float: right; list-style: none; margin-bottom: 5px;">
    		<li style="display: inline-block; margin: 5px;"><a style="color: #fff;" href="/about">About</a></li>
    		<li style="display: inline-block; margin: 5px;"><a style="color: #fff;" href="/blog">Blog</a></li>
    		<li style="display: inline-block; margin: 5px;"><a style="color: #fff;" href="/partners">Partners</a></li>
    		<li style="display: inline-block; margin: 5px;"><a style="color: #fff;" href="#"><img src="http://getadora.com/wp-content/uploads/2014/12/user_icon.png"></a></li>
    	</ul>
    </div>
	</div>
    <?php woo_header_before(); ?>

	<header id="header">
		<div class="col-full">
		
			<?php woo_header_inside(); ?>
	    	
	    	<div id="hgroup">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			</div>
			
			<?php if ( $settings['header_content'] != '' ) { ?>
				<p><?php echo do_shortcode( stripslashes( $settings['header_content'] ) ); ?></p>
			<?php } ?>
			
			<?php if ( is_woocommerce_activated() && isset( $woo_options['woocommerce_header_cart_link'] ) && 'true' == $woo_options['woocommerce_header_cart_link'] ) { ?>
		    	<ul class="nav cart fr">
		    		<li>		<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo $woocommerce->cart->get_cart_total(); ?> <span class="count"><?php echo sprintf( _n('%d item', '%d items', $woocommerce->cart->get_cart_contents_count(), 'woothemes' ), $woocommerce->cart->get_cart_contents_count() );?></span></a>
				</li>
		   		</ul>
	    	<?php } ?>
	    	<div>
	    		<a href="http://getadora.com/download/"><span class="down_free">Download for Free</span></a><br/><br/>
	    		<a href="https://itunes.apple.com/us/app/adora-charity/id930725815?mt=8#"><img src="http://getadora.com/wp-content/uploads/2014/10/AppStore.png" alt="Adora App on the Apple App Store" style="width:135px;height:40px"></a></br><br/>
				<a href="https://play.google.com/store/apps/details?id=com.adoracharity&hl=en"><img src="http://getadora.com/wp-content/uploads/2014/10/PlayStore.png" alt="Adora App on the Google Play Store" style="width:135px;height:40px"></a>
	    	</div>
		</div>
	</header><!-- /#header -->

	<?php woo_content_before(); ?>
