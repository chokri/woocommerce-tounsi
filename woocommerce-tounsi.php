<?php
/**
 * Plugin Name:       Woocommerce Tounsi
 * Description:       Because in Tunisia we write TND not د.ت so I made this plugin :)
 * Plugin URI:        http://github.com/chokri/woocommerce-tounsi
 * Version:           1.0.0
 * Author:            C. Khalifa
 * Author URI:        http://khalifa.tn/
 *
 * @package WooCommerceTounsi
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main WooCommerceTounsi Class
 *
 * @class WooCommerceTounsi
 * @version	1.0.0
 * @since 1.0.0
 * @package	WooCommerceTounsi
 */
final class WooCommerceTounsi {

	/**
	 * Set up the plugin
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'WooCommerceTounsi_setup' ), -1 );
		require_once( 'assets/functions.php' );
	}



	/**
	 * Setup all the things
	 */
	public function WooCommerceTounsi_setup() {
		add_action( 'wp_enqueue_scripts', array( $this, 'WooCommerceTounsi_css' ), 999 );
		add_action( 'wp_enqueue_scripts', array( $this, 'WooCommerceTounsi_js' ) );
		add_filter( 'template_include',   array( $this, 'WooCommerceTounsi_template' ), 11 );
		add_filter( 'wc_get_template',    array( $this, 'WooCommerceTounsi_wc_get_template' ), 11, 5 );
	}

	/**
	 * Enqueue the CSS
	 *
	 * @return void
	 */
	public function WooCommerceTounsi_css() {
		wp_enqueue_style( 'custom-css', plugins_url( '/assets/style.css', __FILE__ ) );
	}

	/**
	 * Enqueue the Javascript
	 *
	 * @return void
	 */
	public function WooCommerceTounsi_js() {
		wp_enqueue_script( 'custom-js', plugins_url( '/assets/custom.js', __FILE__ ), array( 'jquery' ) );
		if(is_front_page()){
			// Scripts only on Front page
		}
	}

	/**
	 * Look in this plugin for template files first.
	 * This works for the top level templates (IE single.php, page.php etc). However, it doesn't work for
	 * template parts yet (content.php, header.php etc).
	 *
	 * Relevant trac ticket; https://core.trac.wordpress.org/ticket/13239
	 *
	 * @param  string $template template string.
	 * @return string $template new template string.
	 */
	public function WooCommerceTounsi_template( $template ) {
		if ( file_exists( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/assets/templates/' . basename( $template ) ) ) {
			$template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/assets/templates/' . basename( $template );
		}

		return $template;
	}

	/**
	 * Look in this plugin for WooCommerce template overrides.
	 *
	 * For example, if you want to override woocommerce/templates/cart/cart.php, you
	 * can place the modified template in <plugindir>/assets/templates/woocommerce/cart/cart.php
	 *
	 * @param string $located is the currently located template, if any was found so far.
	 * @param string $template_name is the name of the template (ex: cart/cart.php).
	 * @return string $located is the newly located template if one was found, otherwise
	 *                         it is the previously found template.
	 */
	public function WooCommerceTounsi_wc_get_template( $located, $template_name, $args, $template_path, $default_path ) {
		$plugin_template_path = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/assets/templates/woocommerce/' . $template_name;

		if ( file_exists( $plugin_template_path ) ) {
			$located = $plugin_template_path;
		}

		return $located;
	}
} // End Class

/**
 * The 'main' function
 *
 * @return void
 */
function WooCommerceTounsi_main() {
	new WooCommerceTounsi();
}

/**
 * Initialise the plugin
 */
add_action( 'plugins_loaded', 'WooCommerceTounsi_main' );
