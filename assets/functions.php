<?php
/**
 * Functions.php
 *
 * @package  WooCommerceTounsi
 * @author   WooThemes
 * @since    1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * functions.php
 * Add PHP snippets here
 */

 add_filter( 'woocommerce_currencies', 'add_my_currency' );

 function add_my_currency( $currencies ) {
      $currencies['TND'] = __( 'Dinar tunisien', 'woocommerce' );
      return $currencies;
 }

 add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);

 function add_my_currency_symbol( $currency_symbol, $currency ) {
      switch( $currency ) {
           case 'TND': $currency_symbol = ' TND'; break;
      }
      return $currency_symbol;
 }
