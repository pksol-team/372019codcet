<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>

<li>
	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

	<div class="thumb-wrapper">
		<a href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr( $product->get_name() ); ?>">
			<?php echo wp_kses_post($product->get_image()); ?>
		</a>
	</div>

	<a class="product-title" href="<?php echo esc_url( $product->get_permalink() ); ?>" title="<?php echo esc_attr( $product->get_name() ); ?>">
		<?php echo esc_html($product->get_name()); ?>
	</a>

	<?php if ( ! empty( $show_rating ) ) : ?>
		<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
	<?php endif; ?>

	<?php if (false == get_theme_mod( 'catalog_mode', false )) : ?>
		<span class="price">
			<?php echo wp_kses_post($product->get_price_html()); ?>
		</span>
		<?php $regular_price = $product->get_regular_price();
		$sale_price    = $product->get_sale_price();
		if( !empty($sale_price) ) {
			// Percentage calculation
			echo '<span class="save-percent">-' . round( ( ( $regular_price -  $sale_price ) / $regular_price ) * 100 ) . '%</span>';
		} ?>
	<?php endif; ?>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
