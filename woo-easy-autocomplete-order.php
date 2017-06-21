<?php
/*
Plugin Name: WooCommerce Easy Autocomplete Orders
Plugin URI: http://wordpress.org/plugins/woo-easy-autocomplete-order
Description: Autocomplete order for the type of payment "Check payments(cheque)", "Cash on delivery(cod)"  or "Direct bank transfer(bacs)"
Version: 1.1
Author: Team EasyErp
Author URI: https://easyerp.com
License: “GPLv2 or later”
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! function_exists( 'init_wc_easy_autocomplete_order' ) ) {
	/**
	 * Init plugin
	 *
	 * @since 1.0
	 *
	 * @package woo-easy-autocomplete-order
	 */
	function init_wc_easy_autocomplete_order() {
		if ( class_exists( 'woocommerce' ) ) {
			if ( ! function_exists( 'easy_autocomplete_order' ) ) {
				/**
				 * Autocomplete order for the type of payment
				 * "Check payments(cheque)", "Cash on delivery(cod)"
				 * or "Direct bank transfer(bacs)"
				 *
				 * @param $order_id
				 *
				 * @since 1.0
				 */
				function easy_autocomplete_order( $order_id ) {
					if ( ! $order_id ) {
						return;
					}

					$payment_method = get_post_meta( $order_id, '_payment_method', true );

					if ( $payment_method == 'cheque' || $payment_method == 'bacs' || $payment_method == 'cod' ) {
						$order = wc_get_order( $order_id );

						$order->payment_complete( bin2hex( random_bytes( 12 ) ) );
					}
				}
			}
			add_action( 'woocommerce_thankyou', 'easy_autocomplete_order', 10, 1 );
		}
	}
}
add_action( 'plugins_loaded', 'init_wc_easy_autocomplete_order' );