<?php
    /**
     * The template for displaying product category thumbnails within loops.
     * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
     *
     * @author        WooThemes
     * @package       WooCommerce/Templates
     * @version       2.4.0
     */

    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    } // Exit if accessed directly

    global $woocommerce_loop, $sf_options;

    // Store loop count we're currently on
    if ( empty( $woocommerce_loop['loop'] ) ) {
        $woocommerce_loop['loop'] = 0;
    }

    // Store column count for displaying the grid
    if ( empty( $woocommerce_loop['columns'] ) ) {
        $product_display_columns     = $sf_options['product_display_columns'];
        $woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $product_display_columns );
    }
    
    $width = "";

    if ( $woocommerce_loop['columns'] == 4 ) {
        $classes[] = 'col-sm-3';
        $width     = 'col-sm-3';
    } else if ( $woocommerce_loop['columns'] == 5 ) {
        $classes[] = 'col-sm-sf-5';
        $width     = 'col-sm-sf-5';
    } else if ( $woocommerce_loop['columns'] == 3 ) {
        $classes[] = 'col-sm-4';
        $width     = 'col-sm-4';
    } else if ( $woocommerce_loop['columns'] == 2 ) {
        $classes[] = 'col-sm-6';
        $width     = 'col-sm-6';
    } else if ( $woocommerce_loop['columns'] == 1 ) {
        $classes[] = 'col-sm-12';
        $width     = 'col-sm-12';
    } else if ( $woocommerce_loop['columns'] == 6 ) {
        $classes[] = 'col-sm-2';
        $width     = 'col-sm-2';
    } else {
    	$classes[] = 'col-sm-3';
    	$width     = 'col-sm-3';
    }

    // Increase loop count
    $woocommerce_loop['loop'] ++;
	
	// Classes
    $classes[] = 'product-category product';
    $classes[] = esc_attr($width);
    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 ) {
        $classes[] = 'first';
    }
    if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 ) {
        $classes[] =  'last';
    }
    
?>
<div <?php wc_product_cat_class($classes); ?> data-width="<?php echo esc_attr($width); ?>">

    <?php do_action( 'woocommerce_before_subcategory', $category ); ?>

    <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

        <?php
            /**
             * woocommerce_before_subcategory_title hook
             *
             * @hooked woocommerce_subcategory_thumbnail - 10
             */
            do_action( 'woocommerce_before_subcategory_title', $category );
        ?>

        <div class="product-cat-info">

            <h3><?php echo $category->name; ?></h3>

            <?php if ( $category->count > 0 ) {
                echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">' . $category->count . ' ' . __( "items", "swiftframework" ) . '</span>', $category );
            }
            ?>

        </div>

        <?php
            /**
             * woocommerce_after_subcategory_title hook
             */
            do_action( 'woocommerce_after_subcategory_title', $category );
        ?>

    </a>

    <?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</div>