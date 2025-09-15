<?php
/**
 * Plugin Name: Custom Service Performance
 * Description: A plugin that lets users creates Services post type and display it to clients in the front-end using shortcode.
 * Version: 1.0.0
 * Plugin URI: https://github.com/dilipraghavan/custom-service-performance.git
 * Author: Dilip Raghavan 
 * Author URI: https://wpshiftstudio.com
 * Text Domain: custom-service-performance
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

// Define a constant for the main plugin file path.
if ( ! defined( 'CSP_PLUGIN_FILE' ) ) {
    define( 'CSP_PLUGIN_FILE', __FILE__ );
    define( 'CSP_PLUGIN_DIR', plugin_dir_path( CSP_PLUGIN_FILE ) );
    define( 'CSP_PLUGIN_URL', plugin_dir_url( CSP_PLUGIN_FILE ) );
}

use WPSHIFTSTUDIO\CustomServicePerformance\Plugin;

// Initialize the plugin.
function run_custom_service_performance() {
     // Load the text domain for translation.
    load_plugin_textdomain(
        'custom-service-performance',
        false,
        dirname(plugin_basename( __FILE__ )) . '/languages/'
    );
    Plugin::get_instance();
}

add_action( 'plugins_loaded', 'run_custom_service_performance' );